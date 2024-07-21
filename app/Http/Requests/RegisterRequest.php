<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => ['required','string','max:255', 'regex:/^[a-zA-Z0-9 \-]+$/'],
            'last_name' => ['required','string','max:255', 'regex:/^[a-zA-Z0-9 \-]+$/'],
            'email' => ['required','email','unique:users,email'],
            'phone_number' => ['nullable','string','max:20','regex:/^[0-9\+]+$/','unique:users,phone_number'],
            'address' => ['nullable','string','max:255'],
            'dob' => ['required', 'date'],
            'occupation' => ['nullable', 'string', 'max:255'],
            'picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png','max:2048']
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => 'Kindly use the email you were invited with'
        ];
    }
}
