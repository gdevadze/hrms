<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreHonorableReasonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'start_date' => 'required',
            'end_date' => 'required',
            'use_previous_year' => ''
        ];
    }

    public function messages(): array
    {
        return [
            'start_date.required' => 'გთხოვთ მიუთითოთ შვებულების დაწყების თარიღი',
            'end_date.required' => 'გთხოვთ მიუთითოთ შვებულების დასრულების თარიღი'
        ];
    }
}
