<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function addProduct(Request $request)
    {
        // ✅ Validation
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        // ✅ Image upload
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('products'), $imageName);

        // ✅ Save to DB
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imageName
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Product added successfully',
            'product' => $product
        ]);
    }


    // API for product listing

    public function getProducts(){
      $product = Product::latest()->get();

       // Add full image URL
    $product->map(function ($product) {
        $product->image_url = url('productlist/' . $product->image);
        return $product;
    });

    return response()->json([
        'status' => true,
        'products' => $product
    ]);
    }


    // API for the search result page

    public function searchProducts(Request $request)
    {
        $query = $request->query('query');

        if (!$query) {
            return response()->json([
                'status' => false,
                'message' => 'Search query is required'
            ], 400);
        }

        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->latest()
            ->get();


        return response()->json([
            'status' => true,
            'products' => $products
        ]);
    }
}