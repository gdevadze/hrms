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
            'name_ka' => 'required',
            'surname_ka' => 'required',
            'name_en' => 'required',
            'surname_en' => 'required',
            'tel' => 'required',
            'email' => '',
            'personal_num' => 'required|unique:users,personal_num,' . $this->id,
            'password' => 'same:confirm-password',
            'birthdate' => 'required',
            'roles' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name_ka.required' => 'გთხოვთ მიუთითოთ სახელი (ქართულად)',
            'surname_ka.required' => 'გთხოვთ მიუთითოთ გვარი (ქართულად)',
            'name_en.required' => 'გთხოვთ მიუთითოთ სახელი (ლათინურად)',
            'surname_en.required' => 'გთხოვთ მიუთითოთ გვარი (ლათინურად)',
            'tel.required' => 'გთხოვთ მიუთითოთ მობილურის ნომერი',
            'email.required' => 'გთხოვთ მიუთითოთ ელ. ფოსტა'
        ];
    }
}
