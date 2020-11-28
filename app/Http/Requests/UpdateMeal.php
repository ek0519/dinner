<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMeal extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'meal_name' => 'required|min:2',
            'price' => 'required|integer',
            'description' => 'nullable',
            'meal_img' => 'nullable|image',
            'status' => 'nullable|in:0,1'
        ];
    }
}
