<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStore extends FormRequest
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
            'title_ar' => 'required|min:3|max:255',
            'title_en' => 'required|min:3|max:255',
            'image' => 'nullable|image',
            'files' => 'nullable|array',
            'video' => 'nullable|mimes:mp4,avi,wmv|max:50000',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric',
            'description_ar' => 'required|min:3|max:255',
            'description_en' => 'required|min:3|max:255',
            'lat' => 'required',
            'lng' => 'required',
            'is_sale' => 'nullable|in:0,1',
            'type' => 'required|in:NEW,LIKENEW,GOOD,NOTSODUSTY,OLD',
            'category_id' => 'required|integer|exists:categories,id',
            'sub_category_id' => 'required|integer|exists:categories,id',
        ];
    }

    public function messages()
    {
        $messages = [
            'title_ar.required' => 'يرجى إدخال اسم المنتج بالإنجليزي',
            'title_ar.max' => 'يجب أن يكون أسم المنتج بالإنجليزي 255 حرف',
            'title_en.required' =>  'يرجى إدخال اسم المنتج بالعربي',
            'title_en.max' => 'يجب أن يكون أسم المنتج بالعربي 255 حرف',
            'image.required' => 'يرجى إدخال صوره خاصة ب المنتج',
            'is_sale.in' => 'لا يمكن تحديث حالة البيع الا من خلال أرسال 0 او 1',
            'image.image' => 'لا يمكن رفع غير صوره',
            'video.mimes' => 'يرجى رفع ملفات الفيديو فقط بالامتدادات التالية: mp4 و avi و wmv. ويجب أن يكون حجم الملف لا يتجاوز 5 ميجابايت.',
            'price.required' => 'يرجى إدخال سعر المنتج الخاص بك',
            'price.numeric' => 'يرجى إدخال السعر رقم وليس نص',
            'discount.numeric' => 'يرجى إدخال الخصم رقم وليس نص',
            'description_ar.required' => 'يرجى إدخال وصف المنتج بالعربي',
            'description_ar.max' => 'يجب أن يكون وصف المنتج بالعربي 255 حرف',
            'description_en.required' => 'يرجى إدخال وصف المنتج بالإنجليزي',
            'description_en.max' => 'يجب أن يكون وصف المنتج بالإنجليزي 255 حرف',
            'lat.required' => 'يرجى إدخال lat',
            'lng.required' => 'يرجى إدخال lng',
            'type.required' => 'يرجى إدخال مستوى نظافتة',
            'type.in' => 'لا توجد هذه النظافة عنا',
            'category_id.required' => 'يرجى إدخال الفئة التي ينتمي اليها المنتج',
            'category_id.integer' => 'لا توجد فئة بهذا الأسم',
            'category_id.exists' => 'لا توجد فئة بهذا الأسم',
            'sub_category_id.required' => 'يرجى إدخال الفئة فرعية التي ينتمي اليها المنتج',
            'sub_category_id.integer' => 'لا توجد فئة فرعية بهذا الأسم',
            'sub_category_id.exists' => 'لا توجد فئة فرعية بهذا الأسم',
        ];

        return $messages;
    }
}
