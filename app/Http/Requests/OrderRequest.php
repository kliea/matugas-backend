<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if (request()->routeIs('order.create')) {
            return [
                'store_id' => 'required|exists:users,user_id',
                'items' => 'required|array',
                'items.*.product_id' => 'required|exists:products,product_id',
                'items.*.quantity' => 'required|numeric|min:1',
            ];
        } else {
            return [
                'cart_id' => 'exists:carts,cart_id',
                'product_id' => 'required|exists:products,product_id',
                'quantity'   => 'required|numeric|min:1',
            ];
        }
    }
}
