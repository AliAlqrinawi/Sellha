<?php

namespace App\Http\Requests;

use Faker\Core\Coordinates;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileStore extends FormRequest
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
            'phone' => 'nullable|numeric|unique:users,phone,' . Auth::user()->id,
            'avatar' => 'nullable|image',
            'user_name' => 'nullable|string|max:255',
            'about' => 'nullable|string|max:255',
            'distance' => 'nullable|in:MILE,KILO',
            'lat' => 'nullable',
            'lng' => 'nullable',
        ];
    }

    public function messages()
    {
        $messages = [
            'phone.numeric' => 'يجب أن يكون الرقم الجوال رقم وليس نص',
            'phone.unique' => 'الرقم المدخل مستخدم من قبل',
            'avatar.image' => 'يرجى رفع صورة',
            'user_name.max' => 'لا يمكن لأسم المستخدم أن يتعدى 255 حرف',
            'about.max' => 'لا يمكن للنبذة أن تتعدى 255 حرف',
            'distance.in' => 'يجب أن يكون قياس المسافة ب الميل او الكيلو',
            'lat.nullable' => '',
            'lng.nullable' => '',
        ];

        return $messages;
    }
}
