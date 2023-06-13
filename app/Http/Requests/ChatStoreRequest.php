<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ChatStoreRequest extends FormRequest
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
            'status' => 'required|in:NORMAL,ARCHIVED,BLOCKED',
            'sender_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'receiver_id' => 'required|exists:users,id',
        ];
    }

    public function userData()
    {
        $data = $this->validated();
        return $data;
    }
}
