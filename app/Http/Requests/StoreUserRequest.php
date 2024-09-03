<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'address' => 'required',
            'email' => '',
            'personal_num' => 'required|unique:users,personal_num',
            'birthdate' => 'required',
            'password' => 'same:confirm-password',
            'company_ids' => 'required',
            'card_number' => 'required'
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
            'personal_num.required' => 'გთხოვთ მიუთითოთ პირადი ნომერი',
            'birthdate.required' => 'გთხოვთ მიუთითოთ დაბადების თარიღი',
            'email.required' => 'გთხოვთ მიუთითოთ ელ. ფოსტა'
        ];
    }
}
