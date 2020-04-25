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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:clients,email',
            'mobile' => 'required|min:8',
            'username' => 'required|unique:clients,username',
            'password' => 'required|min:4',
        ];
    }
}
