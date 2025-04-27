<?php

namespace App\Http\Requests\Todo;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'=>'required',
            'description'=>'required',
            'priority'=>'required|in:low,high,medium',
            'isFavorite'=>'boolean',
            'due_date'=>'required|date_format:d-m-Y',
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
