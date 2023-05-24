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
            'type' => 'required|in:SALE,BUY',
            'status' => 'required|in:NORMAL,ARCHIVED,BLOCKED',
            'image' => 'required|image',
            'buyer_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'seller_id' => 'required|exists:users,id',
        ];
    }

    public function userData()
    {
        $data = $this->validated();
        if (isset($data['image'])) {
            $name = Str::random(12);
            $firstimage = $data['image'];
            $firstimageName = $name . time() . '_' . '.' . $firstimage->getClientOriginalExtension();
            $firstimage->move('uploads/chats/', $firstimageName);
            $data['image'] = 'uploads/chats/' . $firstimageName;
        }
        return $data;
    }
}
