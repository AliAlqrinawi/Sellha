<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CategoryRequest extends FormRequest
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
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'image' =>  $this->getMethod() === 'POST' ? 'required' : 'nullable'.'|image',
            'status' => 'required|in:ACTIVE,INACTIVE',
        ];
    }

    public function categoryData()
    {
        $data = $this->validated();
        if (isset($data['image'])) {
            $name = Str::random(12);
            $image = $data['image'];
            $imageName = $name . time() . '_' . '.' . $image->getClientOriginalExtension();
            $image->move('uploads/Categories/', $imageName);
            $data['image'] = 'uploads/Categories/' . $imageName;
        }
        return $data;
    }
}
