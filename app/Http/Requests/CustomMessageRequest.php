<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomMessageRequest extends FormRequest
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
            'emails' => ['nullable', 'string'],
            'phoneNumbers' => ['nullable', 'string'],
            'mailMessage' => ['nullable', 'string'],
            'textMessage' => ['nullable', 'string'],
            'subject' => ['nullable', 'string']
        ];
    }
}
