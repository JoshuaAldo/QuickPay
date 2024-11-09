<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrderController extends Controller
{
    // Menampilkan semua produk untuk halaman order
    public function index()
    {
        $products = Auth::user()->products; // Ambil semua produk
        $redirect = "order";
        return view('order.index', compact('products', 'redirect')); // Kirim data ke view
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'order_date' => 'required|date',
            'payment_method' => 'required|string',
            'payment_amount' => 'required|numeric',
            'cash_amount' => 'nullable|numeric',
            'qr_amount' => 'nullable|numeric',
            'settlement_status' => 'required|string',
            'payment_reference' => 'nullable|string',
            'transaction_details' => 'required|string',
        ]);
        $orderNumber = $request->input('order_number');
        // Decode transaction details JSON
        $transactionDetails = json_decode($validatedData['transaction_details'], true);
        // $orderDate = Carbon::createFromFormat('m/d/Y, h:i:s A', $validatedData['order_date'])->format('Y-m-d H:i:s');
        try {
            $orderDate = Carbon::createFromFormat('m/d/Y, h:i:s A', $validatedData['order_date'])->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            // Jika format 12 jam gagal, coba format 24 jam sebagai alternatif
            try {
                $orderDate = Carbon::createFromFormat('m/d/Y, H:i:s', $validatedData['order_date'])->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                // Handle the error, log, or return a default/fallback value
                $orderDate = null; // atau berikan pesan error sesuai kebutuhan
            }
        }
        // dd($orderDate);
        // dd($validatedData['order_date']);
        // Hitung total item dari transaksi
        $totalItem = array_reduce($transactionDetails, function ($sum, $item) {
            return $sum + $item['itemTotal'];
        }, 0);

        // Buat order baru
        $order = Order::create([
            'order_number' => $orderNumber,
            'customer_name' => $validatedData['customer_name'],
            'order_date' => $orderDate,
            'payment_method' => $validatedData['payment_method'],
            'payment_amount' => $validatedData['payment_amount'],
            'cash_amount' => $validatedData['cash_amount'],
            'qr_amount' => $validatedData['qr_amount'],
            'settlement_status' => $validatedData['settlement_status'],
            'payment_reference' => $validatedData['payment_reference'],
        ]);

        // Simpan setiap item transaksi
        foreach ($transactionDetails as $item) {
            $order->items()->create([
                'product_name' => $item['productName'],
                'quantity' => $item['quantity'],
                'item_total' => $item['itemTotal'],
                'description' => $item['description'],
            ]);

            // Kurangi stok produk di database
            $product = Product::where('product_name', $item['productName'])->first();
            if ($product) {
                $product->stock -= $item['quantity'];
                $product->save();
            }
        }
        // Hitung change (kembalian)
        $change = $validatedData['payment_amount'] - $totalItem;

        return redirect()->route('order.index')
            ->with('success', 'Order Successfully Created')
            ->with('change', $change)
            ->with('orderId', $order->id)->with('orderNumber', $orderNumber);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
