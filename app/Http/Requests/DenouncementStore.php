<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DenouncementStore extends FormRequest
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
            'reason' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
        ];
    }

    public function messages()
    {
        $messages = [
            'reason.required' => 'يرجى إدخال السبب الإبلاغ',
            'reason.max' => 'لا يمكن ان يكون السبب أكثر من 255 حرف',

            'product_id.required' => 'يرجى إدخال المنتج الذي تريد الإبلاغ عنه',
            'product_id.exists' => 'لا يوجد منتج بهذا الأسم',
        ];

        return $messages;
    }

}
