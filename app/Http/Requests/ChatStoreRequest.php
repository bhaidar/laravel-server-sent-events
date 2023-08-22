<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'prompt' => ['required', 'string', 'min:10'],
        ];
    }
}
