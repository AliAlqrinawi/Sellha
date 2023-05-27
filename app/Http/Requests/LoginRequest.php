<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'phone' => 'required|numeric|exists:users,phone',
        ];
    }

    public function userData()
    {
        $data = $this->validated();
        $data['otp'] = Hash::make(mt_rand(1000, 9999));
        return $data;
    }
}
