<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
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
                return redirect()->route('order.index');
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

        // Mengembalikan hasil pencarian ke tampilan yang sesuai
        if ($redirect === 'product_category') {
            return view('product_category.index', compact('categories', 'query', 'redirect'));
        }

        if ($redirect === 'product') {
            return view('product.index', compact('products', 'categories', 'query', 'redirect'));
        }

        if ($redirect === 'order') {
            return view('order.index', compact('products', 'query', 'redirect'));
        }

        return view('product.index', compact('products', 'categories', 'query'));
    }
}
