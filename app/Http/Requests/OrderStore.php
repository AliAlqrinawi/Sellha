<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class OrderStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'total' => 'required|numeric|integer',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'buyer_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'seller_id' => 'required|exists:users,id',
        ];
    }
}
