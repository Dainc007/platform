<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TableFilterRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'year' => 'nullable|integer|min:2020',
            'month' => 'nullable|integer|min:1|max:12',
            'status' => 'nullable|string',
        ];
    }
}
