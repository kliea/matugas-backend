<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if (request()->routeIs('cart.destroy')) {
            return [
                'product_id' => 'required|exists:products,product_id',
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
