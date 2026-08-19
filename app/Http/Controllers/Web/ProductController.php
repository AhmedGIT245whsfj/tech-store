<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $products = Product::with('category')
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('category', function ($categoryQuery) use ($request) {
                    $categoryQuery->where('slug', $request->category);
                });
            })
            ->orderBy('id')
            ->paginate(9)
            ->withQueryString();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load('category');

        return view('products.show', compact('product'));
    }
}
