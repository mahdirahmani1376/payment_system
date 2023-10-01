<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class checkoutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'method' => ['required'],
            'gateway' => ['required_if:method,online'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
