<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientPost extends FormRequest
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
            //
            'full_name' => 'nullable',
            'birthday' => 'nullable',
            'bio' => 'nullable',
            'gender' => 'nullable',
            'email' => 'nullable|email|unique:clients,email',
            'mobile' => 'nullable|min:8',
            'username' => 'nullable|unique:clients,username',
            'password' => 'required|min:4',
        ];
    }
}
