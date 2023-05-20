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

    public function messages()
    {
        if (App::getLocale() == 'ar') {
            $messages = [
                'total.required' => 'يرجى إرسال المجموع الخاص ب الطلب',
                'total.numeric' => 'يجب عليك ارسال مجوع الطلب رقم',
                'total.integer' => 'يجب عليك ارسال مجوع الطلب رقم',
                'lat.required' => 'يرجى أرسال العرض',
                'lat.numeric' => 'يرجى أرسال العرض',
                'lng.required' => 'يرجى أرسال الطول',
                'lng.numeric' => 'يرجى أرسال الطول',
                'buyer_id.required' => 'يرجى أرسال من هوه البائع',
                'buyer_id.exists' => 'لا يوجد بائع بهذا الأسم',
                'product_id.required' => 'يرجى أرسال المنتج الخاص ب الطلب',
                'product_id.exists' => 'لا يوجد طلب بهذا الاسم',
                'seller_id.required' =>  'يرجى أرسال من هوه الشاري',
                'seller_id.exists' => 'لا يوجد شاري بهذا الأسم',
            ];
            return $messages;
        }
        return [];
    }
}
