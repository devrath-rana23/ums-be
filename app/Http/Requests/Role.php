<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class Role extends FormRequest
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
            'name' => 'required|max:255|unique:skills',
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
            "name.required" => "Please enter name",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();
        $errorMessage = "";
        foreach ($errors as $key => $value) {
            $errorMessage = isset($value[0]) && !empty($value[0]) ? $value[0] : "";
            break;
        }
        throw new HttpResponseException(response()->json([
            'data' => [],
            'message'   => $errorMessage,
            'errors'      => $errors,
            'status' => Response::HTTP_BAD_REQUEST
        ]));
    }
}
