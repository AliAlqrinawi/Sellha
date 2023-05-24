<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

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
}
