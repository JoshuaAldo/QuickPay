<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class productController extends Controller
{
    public function index()
    {
        // Ambil semua produk dan kategori
        $products = Product::all();
        $categories = Category::all(); // Ambil semua kategori

        return view('product.index', compact('products', 'categories')); // Kirim ke view
    }

    public function create()
    {
        $categories = Category::all();
        return view('product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:product_categories,id',
        ]);

        Product::create($request->all());
        return redirect()->route('product.index');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all(); // Ambil semua kategori jika ada
        return response()->json(['product' => $product, 'category' => $categories]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:product_categories,id',
        ]);


        // dd($request->all());
        $product = Product::findOrFail($id);
        $product->update($request->all());
        // Log::info('Updating product: ', [$product]);
        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }
}
