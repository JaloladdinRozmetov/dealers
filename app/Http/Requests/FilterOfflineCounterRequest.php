<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterOfflineCounterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'serial_number' => 'nullable|string|max:255',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
