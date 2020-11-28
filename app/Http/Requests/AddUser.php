<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddUser extends FormRequest
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
            'name'  => 'required|min:3',
            'password' => 'required|regex:/^(?=.*\d+.*)(?=.*\w+.*)[0-9a-zA-Z]{6,}$/',
            'mobile' => 'nullable|regex:/^09\d{2}\-?\d{3}\-?\d{3}$/',
            'email' => 'unique:users,email',
        ];
    }
}
