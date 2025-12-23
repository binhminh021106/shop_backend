<?php

namespace App\Http\Controllers\Api\client;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::all();

        return response()->json($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $productDetail = Product::findOrFail($id);

        return response()->json($productDetail);
    }
}
