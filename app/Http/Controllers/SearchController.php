<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DraftOrder;
use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $redirect = $request->input('redirect'); // Ambil parameter redirect
        // Jika query kosong, redirect ke halaman produk atau kategori sesuai parameter
        if (empty($query)) {
            if ($redirect === 'product') {
                return redirect()->route('product.index');
            } elseif ($redirect === 'product_category') {
                return redirect()->route('product_category.index');
            } elseif ($redirect === 'order') {
                return redirect()->route('order.index');;
            }
            // Tambah kondisi lain jika diperlukan
        }

        // Mencari produk berdasarkan nama sesuai user yang login
        $products = Product::where('product_name', 'LIKE', "%{$query}%")
            ->where('user_id', Auth::id()) // Hanya produk milik user yang sedang login
            ->get();

        // Mencari kategori berdasarkan nama
        $categories = Category::where('category_name', 'LIKE', "%{$query}%")
            ->where('user_id', Auth::id()) // Hanya kategori milik user yang sedang login
            ->get();

        $orders = Order::where('customer_name', 'LIKE', "%{$query}%")
            ->where('user_id', Auth::id()) // Hanya kategori milik user yang sedang login
            ->get();

        $purchases = Purchase::where('item_name', 'LIKE', "%{$query}%")
            ->where('user_id', Auth::id()) // Hanya kategori milik user yang sedang login
            ->get();

        $ordersWithTotals = $orders->map(function ($order) {
            $discount = $order->discount;
            $totalOrder = $order->items->sum('item_total');
            $order->total_item_value = $totalOrder - $discount;
            return $order;
        });

        // Mengembalikan hasil pencarian ke tampilan yang sesuai
        if ($redirect === 'product_category') {
            return view('product_category.index', compact('categories', 'query', 'redirect'));
        }

        if ($redirect === 'product') {
            return view('product.index', compact('products', 'categories', 'query', 'redirect'));
        }

        if ($redirect === 'sales-report') {

            return view('sales_report.index', compact('ordersWithTotals', 'orders', 'query', 'redirect'));
        }

        if ($redirect === 'purchase-of-goods') {

            return view('purchase_of_goods.index', compact('purchases', 'redirect'));
        }

        return view('product.index', compact('products', 'categories', 'query'));
    }
}
