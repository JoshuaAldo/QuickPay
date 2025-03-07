<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DraftOrder;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isNull;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $redirect = "order";
        $productQuantities = session('productQuantities', []); // Ambil productQuantities dari session            
        $productDescription = session('productDescription', []); // Ambil productDescription dari session
        $custName = session('draftOrderCustName');
        $draftId = session('draftId');
        $discount = session('discount');
        $categories = Auth::user()->categories()->withCount('products')->get();
        $selectedCategory = $request->input('category');
        $productQty = 0;

        if ($selectedCategory) {
            // Ambil produk berdasarkan kategori yang dipilih
            $products = Auth::user()->products()
                ->select('*', DB::raw("CAST(REGEXP_SUBSTR(product_name, '[0-9]+') AS UNSIGNED) as numeric_part"))
                ->orderBy(DB::raw("REGEXP_SUBSTR(product_name, '^[A-Za-z ]*')"), 'asc')
                ->orderBy('numeric_part', 'asc')
                ->where('category_id', $selectedCategory)
                ->get();
        } else {

            // Tampilkan semua produk jika tidak ada kategori yang dipilih
            $products = Auth::user()->products()
                ->select('*', DB::raw("CAST(REGEXP_SUBSTR(product_name, '[0-9]+') AS UNSIGNED) as numeric_part"))
                ->orderBy(DB::raw("REGEXP_SUBSTR(product_name, '^[A-Za-z ]*')"), 'asc')
                ->orderBy('numeric_part', 'asc')
                ->get();
        }

        return view('order.index', compact(
            'products',
            'redirect',
            'productQuantities',
            'productDescription',
            'custName',
            'draftId',
            'discount',
            'categories',
            'selectedCategory',
            'productQty'
        ));
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

        // Redirect ke halaman order dan kirim data productQuantities ke view
        return redirect()->route('order.index')->with('productQuantities', $productQuantities)->with('productDescription', $productDescription)->with('draftOrderCustName', $custName)->with('draftId', $draftId);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
        // Validasi input
        $draftId = $request->input('draftId');
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
        if (!empty($validatedData['order_date'])) {
            try {
                // Normalisasi format AM/PM (ubah am/pm ke AM/PM)
                $normalizedDate = preg_replace_callback('/\b(am|pm)\b/', function ($matches) {
                    return strtoupper($matches[0]);
                }, $validatedData['order_date']);

                // Coba format 12 jam dengan AM/PM dalam huruf besar
                $orderDate = Carbon::createFromFormat('m/d/Y, h:i:s A', $normalizedDate)->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                // Jika format 12 jam gagal, coba format 24 jam sebagai alternatif
                try {
                    $orderDate = Carbon::createFromFormat('m/d/Y, H:i:s', $validatedData['order_date'])->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    // Log atau tangani error, atau set default value
                    \Log::error('Invalid date format for order_date: ' . $validatedData['order_date']);
                    $orderDate = Carbon::now()->format('Y-m-d H:i:s'); // atau set default date jika perlu
                }
            }
        } else {
            // Tangani kasus jika order_date kosong
            \Log::error('Order date is empty');
            $orderDate = null; // atau nilai default
        }
        // Hitung total item dari transaksi
        $totalItem = array_reduce($transactionDetails, function ($sum, $item) {
            return $sum + $item['itemTotal'];
        }, 0);
        $discount = $request->input('diskon');

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
            'discount' => $discount,
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
        $change = $validatedData['payment_amount'] - ($totalItem - $discount);
        if ($draftId !== null) {
            $draftOrder = DraftOrder::with('items')->findOrFail($draftId);
            $draftOrder->items()->delete();
            $draftOrder->delete();
        }
        return redirect()->route('order.index')
            ->with('success', 'Order Successfully Created')
            ->with('change', $change)
            ->with('orderId', $order->id)->with('orderNumber', $orderNumber)->with('discount', $discount);
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
