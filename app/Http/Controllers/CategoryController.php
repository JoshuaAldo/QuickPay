<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        // Ambil kategori hanya untuk pengguna yang sedang login, sertakan hitungan produk
        $categories = Auth::user()->categories()->withCount('products')->get();

        foreach ($categories as $category) {
            // Hitung kapital dan total stok untuk setiap kategori
            $category->capital = $category->products->sum(function ($product) {
                return $product->base_price * $product->stock;
            });
            $category->total_stock = $category->products->sum('stock');

            // Update kategori dengan kapital dan total stok
            $category->update([
                'capital' => $category->capital,
                'total_stock' => $category->total_stock
            ]);
        }
        $redirect = "product_category";
        // Kirim data kategori ke view
        return view('product_category.index', compact('categories', 'redirect'));
    }

    public function store(Request $request)
    {
        // Validasi input dari pengguna
        $request->validate([
            'category_name' => [
                'required',
                Rule::unique('product_categories', 'category_name')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                }),
            ],
        ]);

        // Simpan data kategori
        $categoryData = [
            'category_name' => $request->category_name,
            'user_id' => Auth::id(), // Menambahkan user_id untuk mengasosiasikan kategori dengan pengguna yang sedang login
        ];

        Category::create($categoryData);

        // Redirect ke halaman kategori setelah berhasil menyimpan
        return redirect()->route('product_category.index')->with('success', 'Category added successfully.');
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->delete();
            return redirect()->route('product_category.index')->with('success', 'Category deleted successfully');
        }

        return redirect()->route('product_category.index')->with('error', 'Category not found');
    }
}
