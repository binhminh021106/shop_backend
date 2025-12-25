<?php

namespace App\Http\Controllers\Api\client;

use App\Models\Variant;
use Illuminate\Http\Request;

class VariantController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $variant = Variant::all();

        return response()->json($variant);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $variant_detail = Variant::findOrFail($id);

        return response()->json($variant_detail);
    }

}
