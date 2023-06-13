<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class MessageStoreRequest extends FormRequest
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
            'content' => 'nullable',
            'lat' => 'nullable',
            'lng' => 'nullable',
            'image' => 'nullable|image',
            'is_read' => 'required|in:0,1',
            'type' => 'required|in:CONTENT,IMAGE,LOCATION',
            'chat_id' => 'nullable|exists:chats,id',
            'sender_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'receiver_id' => 'required|exists:users,id',
        ];
    }

    public function messageData()
    {
        $data = $this->validated();
        if (isset($data['image'])) {
            $name = Str::random(12);
            $image = $data['image'];
            $imageName = $name . time() . '_' . '.' . $image->getClientOriginalExtension();
            $image->move('uploads/messages/', $imageName);
            $data['image'] = 'uploads/messages/' . $imageName;
        }
        return $data;
    }
}
