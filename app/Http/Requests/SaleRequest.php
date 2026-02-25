<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
            return [
        'customer_id' => 'required|exists:users,id',
        'discount' => 'nullable|numeric|min:0',
        'vat_percent' => 'nullable|numeric|min:0|max:100',
        'paid' => 'nullable|numeric|min:0',
        'products' => 'required|array|min:1',
        'products.*.qty' => 'required|integer|min:1',
        'products.*.price' => 'required|numeric|min:0',
    ];
    }

}