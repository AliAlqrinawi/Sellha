<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class RegisterRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|unique:users',
        ];
    }

    public function userData()
    {
        $data = $this->validated();
        $data['email'] = $data['phone'];
        $data['phone'] = $data['phone'];
        $data['password'] = $data['phone'];
        $data['otp'] = Hash::make(mt_rand(1000, 9999));
        return $data;
    }
}
