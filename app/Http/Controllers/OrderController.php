<?php

namespace App\Http\Controllers;

use App\Models\DraftOrder;
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
        $draftOrders = DraftOrder::with('items')->get();
        $products = Auth::user()->products; // Ambil semua produk
        $redirect = "order";
        $productQuantities = session('productQuantities', []);
        $productDescription = session('productDescription', []);
        $custName = session('draftOrderCustName');
        return view('order.index', compact('products', 'redirect', 'productQuantities', 'productDescription', 'custName')); // Kirim data ke view
    }

    public function redirectToOrderPage(Request $request, $draftId)
    {
        // Ambil data draft order dan itemnya
        $draftOrder = DraftOrder::with('items')->findOrFail($draftId);
        $draftOrder2 = DraftOrder::findOrFail($draftId);

        // Persiapkan data quantity untuk setiap produk
        $productQuantities = [];
        $productDescription = [];
        foreach ($draftOrder->items as $item) {
            $productQuantities[$item->product_name] = $item->quantity; // Menyimpan quantity produk sesuai dengan draft order
            $productDescription[$item->product_name] = $item->description;
        }
        $custName = $draftOrder2->customer_name;

        // $draftOrder->items()->delete();
        // $draftOrder->delete();
        // Redirect ke halaman order dan kirim data productQuantities ke view
        return redirect()->route('order.index')->with('productQuantities', $productQuantities)->with('productDescription', $productDescription)->with('draftOrderCustName', $custName);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
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
            'user_id' => $userId,
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
