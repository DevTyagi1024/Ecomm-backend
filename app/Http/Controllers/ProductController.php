<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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

        // ✅ Upload to Cloudinary
        $uploadedFile = $request->file('image')->getRealPath();
        $result = Cloudinary::upload($uploadedFile);
        $imageUrl = $result->getSecurePath();

        // ✅ Save to DB
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imageUrl
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Product added successfully',
            'product' => $product
        ]);
    }

    // ✅ Product list
    public function getProducts(){
        $product = Product::latest()->get();

        return response()->json([
            'status' => true,
            'products' => $product
        ]);
    }

    // ✅ Search
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