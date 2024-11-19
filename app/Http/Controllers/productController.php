<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the user's products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ambil produk yang dimiliki oleh user yang sedang login
        $products = Auth::user()->products;
        $categories = Category::where('user_id', Auth::id())->get();
        $redirect = "product"; // Menetapkan nilai redirect untuk halaman produk
        return view('product.index', compact('products', 'categories', 'redirect'));
    }


    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     // Ambil semua kategori
    //     $categories = Category::all();

    //     return view('product.create', compact('categories'));
    // }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'product_name' => 'required|string|max:255|unique:products,product_name',
            'base_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:product_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Persiapkan data produk
        $productData = [
            'product_name' => $request->product_name,
            'base_price' => $request->base_price,
            'sell_price' => $request->sell_price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
        ];

        // Jika ada gambar, simpan dan tambahkan ke data produk
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/products', 'public');
            $productData['image'] = $imagePath; // Simpan path gambar
        }

        // Tambahkan produk baru untuk user yang sedang login
        Auth::user()->products()->create($productData);

        return redirect()->route('product.index')->with('success', 'Product added successfully.');
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Cari produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Cek apakah produk ini milik user yang sedang login
        if (Auth::id() !== $product->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Ambil semua kategori
        $categories = Category::all();

        return response()->json(['product' => $product, 'categories' => $categories]);
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // Ambil nama produk lama untuk membandingkan
        $oldProductName = $product->product_name;

        $request->validate([
            'product_name' => 'required|string|max:255|unique:products,product_name,' . $product->id, // Ignore validation for current product
            'base_price' => 'required|numeric',
            'sell_price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'nullable|exists:product_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update image if a new one is uploaded
        if ($request->hasFile('image')) {
            // Delete the old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('images/products', 'public');
        } else {
            Log::info('masuk else baru');
            $imagePath = $product->image; // Retain old image
        }

        $product->update([
            'product_name' => $request->product_name,
            'base_price' => $request->base_price,
            'sell_price' => $request->sell_price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'image' => $imagePath
        ]);

        return redirect()->route('product.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return redirect()->route('product.index')->with('success', 'Product deleted successfully');
        }

        return redirect()->route('product.index')->with('error', 'Product not found');
    }
}
