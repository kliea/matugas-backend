<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $user = auth()->user();
        $role = $user->role;

        if ($role === 'supplier') {
            $supplierId = $user->user_id;
        } else if ($role === 'admin') {
            // Validate and retrieve supplier ID for admin case
            $supplierId = $request->input('supplier_id');
        } else {
            // Handle unauthorized access
            abort(403, 'Unauthorized');
        }
        $validated = $request->validated();
        $product = Product::create(['supplier_id' => $supplierId, ...$validated]);

        return $product;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Product::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $validated = $request->validated();
        $product = Product::findOrFail($id);
        $product->update($validated);

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return $product;
    }
}
