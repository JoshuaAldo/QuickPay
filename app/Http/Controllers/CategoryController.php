<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('products')->get();
        foreach ($categories as $category) {
            $category->capital = $category->products->sum('base_price');
            $category->total_stock = $category->products->sum('stock');
        }

        return view('product_category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:product_categories',
        ]);

        $category = Category::create([
            'category_name' => $request->category_name
        ]);

        return redirect()->route('product_category.index');
    }
}
