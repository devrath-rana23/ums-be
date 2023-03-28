<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Employee extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
            'role_id' => 'required',
            'avatar' => 'required',
            'birth' => 'required',
            'salary' => 'required',
            'martial_status' => 'required',
            'bonus' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'skills' => 'required',
        ];
    }
}
