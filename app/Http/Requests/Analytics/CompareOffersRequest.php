<?php

namespace App\Http\Requests\Analytics;

use Illuminate\Foundation\Http\FormRequest;

class CompareOffersRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'mimes:csv,txt', 'max:51200'],
            'files' => ['required', 'array'],
            'brand_id' => ['required', 'exists:brands,id'],
            'currency_id' => ['required', 'exists:currencies,id'],
        ];
    }
}
