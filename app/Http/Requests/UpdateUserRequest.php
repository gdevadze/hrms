<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required',
            'surname' => 'required',
            'tel' => 'required',
            'email' => 'required|unique:users,email,' . $this->id,
            'personal_num' => 'required|unique:users,personal_num,' . $this->id,
            'password' => 'same:confirm-password',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'გთხოვთ მიუთითოთ სახელი',
            'surname.required' => 'გთხოვთ მიუთითოთ გვარი',
            'tel.required' => 'გთხოვთ მიუთითოთ მობილურის ნომერი'
        ];
    }
}
