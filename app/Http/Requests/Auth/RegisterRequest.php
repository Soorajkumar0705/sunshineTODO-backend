<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required|max:10',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|max:6'
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(
            response()->errorJson([], [
                'errors' => $validator->errors()
            ], 400)
        );
    }
}
