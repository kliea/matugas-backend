<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    private const ALLOWED_ROLES = ['admin', 'customer', 'store', 'supplier'];
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
        if (request()->routeIs('user.login')) {
            return [
                'email'         => 'required|string|email|max:255',
                'password'      => 'required|min:8'
            ];
        } else if (request()->routeIs('user.signup')) {
            return [
                'first_name'            => 'required|string|max:255',
                'last_name'             => 'nullable|string|max:255',
                'role'                  => 'required|in:' . implode(',', self::ALLOWED_ROLES),
                'photo_url'             => 'nullable|string',
                'email'                 => 'required|string|email|unique:App\Models\User,email|max:255',
                'password'              => 'required|min:8'
            ];
        }
    }
}
