<?php

namespace App\Http\Requests;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class Employee extends FormRequest
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
            'name' => 'required|max:255',
            'role_id' => 'required|numeric',
            'avatar' => 'required|image',
            'birth' => 'required',
            'salary' => 'required|numeric',
            'martial_status' => 'required|in:single,married,divorced',
            'bonus' => 'required|numeric',
            'phone' => 'required|numeric|digits:10|unique:App\Models\ContactInfo,phone|exclude_if:phone,' . User::find(auth()->user()->id)->employee->contactInfo->phone,
            'email' => 'required|email|unique:App\Models\ContactInfo,email|exclude_if:email,' . User::find(auth()->user()->id)->employee->contactInfo->email,
            'skills' => 'required',
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
