<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Http\Requests\InventoryRequest;


class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventory = auth()->user()->inventory;
        // If you need to access the items for each cart
        foreach ($inventory as $inventory) {
            $inventory = $inventory->items;
        }
        return $inventory;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InventoryRequest $request)
    {
        // Validate the request data
        $validated = $request->validated();
        $user = auth()->user();
        $storeId = $user->user_id;

        // Find existing cart or create a new one
        $inventory = Inventory::firstOrCreate(['store_id' => $storeId]);
        $validated['inventory_id'] = $inventory->inventory_id;

        if ($inventory->items()->where('product_id', $validated['product_id'])->exists()) {
            return response()->json(['message' => 'Cart product item already exist.'], 404);
        }
        $inventoryItem = $inventory->items()->create($validated);

        return $inventoryItem;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inventory =  auth()->user()->inventory;
        if (!$inventory->items()->where('product_id', $id)->exists()) {
            return response()->json(['message' => 'Inventory item not found.'], 404);
        }

        $inventory->items()->where('product_id', $id)->delete();

        return response()->json(['message' => 'Inventory item removed successfully.']);
    }
}
