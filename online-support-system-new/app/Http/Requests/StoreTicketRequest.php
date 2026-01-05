<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'problem_description' => 'required|string|min:10',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'problem_description.required' => 'Please describe your problem.',
            'problem_description.min' => 'Please provide more details about your problem (minimum 10 characters).',
        ];
    }
}
