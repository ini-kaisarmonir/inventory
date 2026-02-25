<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'purchase_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'opening_stock' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Product name is required.',
            'purchase_price.required' => 'Purchase price is required.',
            'purchase_price.numeric' => 'Purchase price must be a number.',
            'purchase_price.min' => 'Purchase price must be at least 0.',
            'sell_price.required' => 'Selling price is required.',
            'sell_price.numeric' => 'Selling price must be a number.',
            'sell_price.min' => 'Selling price must be at least 0.',
            'opening_stock.required' => 'Opening stock is required.',
            'opening_stock.numeric' => 'Opening stock must be a number.',
            'opening_stock.min' => 'Opening stock must be at least 0.',
        ];
    }
}