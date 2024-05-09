<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Http\Requests\CartRequest;
use App\Http\Controllers\Controller;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = auth()->user()->cart;
        // If you need to access the items for each cart
        foreach ($carts as $cart) {
            $cartItems = $carts->items;
        }
        return $carts;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CartRequest $request)
    {
        // Validate the request data
        $validated = $request->validated();
        $user = auth()->user();
        $customerId = $user->user_id;

        // Find existing cart or create a new one
        $cart = Cart::firstOrCreate(['customer_id' => $customerId]);
        $validated['cart_id'] = $cart->cart_id;

        if ($cart->items()->where('product_id', $validated['product_id'])->exists()) {
            return response()->json(['message' => 'Cart product item already exist.'], 404);
        }
        $cartItem = $cart->items()->create($validated);

        return $cartItem;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cart =  auth()->user()->cart;
        if (!$cart->items()->where('product_id', $id)->exists()) {
            return response()->json(['message' => 'Cart item not found.'], 404);
        }

        $cart->items()->where('product_id', $id)->delete();

        return response()->json(['message' => 'Cart item removed successfully.']);
    }
}
