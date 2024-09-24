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
            'email' => ['nullable','email'],
            'phone_number' => ['nullable','string','max:20','regex:/^[0-9\+]+$/'],
            'address' => ['nullable','string','max:255'],
            'dob' => ['required', 'date'],
            'occupation' => ['nullable', 'string', 'max:255'],
            'wedding_date' => ['nullable', 'date']
        ];
    }
}
