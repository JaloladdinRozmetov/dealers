<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Counter extends FormRequest
{
    /**
     * @var string $route_parameter
     */
    protected static string $route_parameter = 'counter';


    private function rulesList(): array
    {
        return [
            'getInn' => [
                'serialNumbers' => 'required|array',
                'serialNumbers.*' => 'integer|max:999999999999999|exists:counters,serial_number',
            ],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return $this->rulesList()[$this->route()->getActionMethod()];
    }
}
