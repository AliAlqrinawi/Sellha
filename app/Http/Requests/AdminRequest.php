<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' =>  $this->getMethod() === 'POST' ? 'unique:users' : 'unique:users,email,' . $this->route('admin') .'|required|string|email|max:255',
            'password' => $this->getMethod() === 'POST' ? 'required' : 'nullable' .'|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:ACTIVE,INACTIVE',
        ];
    }
}
