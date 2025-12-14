<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:100|unique:customers',
            'address' => 'nullable|string|max:255',
            'citizen_id' => 'nullable|string|max:20',
            'birthday' => 'nullable|date',
            'nationality' => 'nullable|string|max:100',
            'rank' => 'nullable|in:normal,vip,blacklist',
            'note' => 'nullable|string',
            'gender' => 'nullable|string|max:10',
        ];
    }
}
