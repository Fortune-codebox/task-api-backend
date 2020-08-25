<?php

namespace App\Requests; 

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'country' => 'required|string',
            'assigned_to' => 'required|string',
            'date' => 'required|date',
        ];
    }

     /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name' => 'name is required',
            'country' => 'country is required',
            'assigned_to' => 'assigned_to is required',
            'date' => 'date is required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(['errors' => $errors
        ], 422));
        // JsonResponse::HTTP_UNPROCESSABLE_ENTITY
    }
}