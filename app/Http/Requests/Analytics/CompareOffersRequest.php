<?php

namespace App\Http\Requests\Analytics;

use Illuminate\Foundation\Http\FormRequest;

class CompareOffersRequest extends FormRequest
{

    public function rules(): array
    {
        return [
//            'files' => ['required', 'array'],
//            'brand_id' => ['required', 'integer', 'exists:brands,id'],
            'file' => ['required', 'file'],
        ];
    }
}
