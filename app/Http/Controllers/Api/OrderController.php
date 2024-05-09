<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;



class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = auth()->user()->order;
        // If you need to access the items for each cart
        foreach ($orders as $order) {
            $orderItems = $orders->items;
        }
        return $orders;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {

        // Validate the request data
        $validated = $request->validated();
        $user = auth()->user();
        $customerId = $user->user_id;
        $storeId = $validated['store_id'];

        // Find existing cart or create a new one
        $order = Order::firstOrCreate(['customer_id' => $customerId, 'store_id' => $storeId]);
        $validated['order_id'] = $order->order_id;

        // Assuming 'items' is an array within $validated data
        foreach ($validated['items'] as $item) {
            // Validate product_id
            $product = Product::find($item['product_id']);  // Replace 'Product' with your model
            if (!$product) {
                // Handle invalid product_id, e.g., return an error response
                return response()->json(['error' => 'Invalid product ID'], 400);
            }

            // Get the price (adjust how you determine the price)
            $price = $product->price;

            // Create OrderItem
            OrderItem::create([
                'order_id' => $order->order_id,
                'product_id' => $item['product_id'],
                'price' => $price,
                'quantity' => $item['quantity']
            ]);
        }
        $totalPrice = 0;
        foreach ($validated['items'] as $item) {
            // ... (your product validation and OrderItem creation logic) ...

            $totalPrice += $price * $item['quantity'];
        }

        // Update the order with the total price
        $order->total_price = $totalPrice;
        $order->save();


        return $order;
    }

    public function destroy(string $id)
    {
    }
}
