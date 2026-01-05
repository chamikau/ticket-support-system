<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketReplyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAgent();
    }

    public function rules(): array
    {
        return [
            'message' => 'required|string|min:5',
        ];
    }
}
