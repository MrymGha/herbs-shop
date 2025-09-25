<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->where('is_active', true);


        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }


        if ($request->filled('q')) {
            $query->where('name', 'like', "%{$request->q}%")
            ->orWhere('description', 'like', "%{$request->q}%");
        }


        $products = $query->paginate(12);
        $categories = Category::all();


        return view('products.index', compact('products', 'categories'));
    }
    
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('products.show', compact('product'));
    }

}
