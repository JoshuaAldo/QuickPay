<?php

namespace App\Http\Controllers;

use App\Models\DraftOrder;
use App\Models\DraftOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DraftOrderController extends Controller
{
    public function index()
    {
        $draftOrders = DraftOrder::with('items')->get();
        $redirect = "order";
        return view('draft_order.index', compact('draftOrders', 'redirect'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'cart_items' => json_decode($request->cart_items, true)
        ]);

        // Validasi input
        $validated = $request->validate([
            'customer_name' => 'required|string',
            'cart_items' => 'required|array',
            'cart_items.*.productId' => 'required|integer',  // Validasi ID produk
            'cart_items.*.productName' => 'required|string', // Validasi nama produk
            'cart_items.*.productPrice' => 'required|numeric', // Validasi harga produk
            'cart_items.*.quantity' => 'required|integer|min:1', // Validasi kuantitas
            'cart_items.*.productImage' => 'required|url', // Validasi URL gambar
        ]);
        // dd($validated);
        // Jika validasi gagal, Laravel akan otomatis mengembalikan error 422
        if (!$validated) {
            return response()->json(['error' => 'Validation failed'], 422);
        }

        // Menyimpan Draft Order
        $draftOrder = DraftOrder::create([
            'customer_name' => $request->customer_name
        ]);

        // Menyimpan Item Keranjang ke dalam Draft Order
        foreach ($request->cart_items as $item) {
            DraftOrderItem::create([
                'draft_order_id' => $draftOrder->id,
                'product_name' => $item['productName'],
                'product_price' => $item['productPrice'],
                'quantity' => $item['quantity'],
                'product_image' => $item['productImage'],
                'description' => $item['description'],
                'status' => 'Pending'
            ]);
        }

        return redirect()->route('draftOrder.index')
            ->with('success', 'Order save to Draft Order')
            ->with('draftOrderId', $draftOrder->id);
    }

    public function show($id)
    {
        $order = DraftOrder::with('items')->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }
}
