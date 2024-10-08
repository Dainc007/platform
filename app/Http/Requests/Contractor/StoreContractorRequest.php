<?php

namespace App\Http\Requests\Contractor;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContractorRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'file' => 'nullable|file|max:10240',
            'currency_id' => 'required_with:file',
            'brand_id' => 'required_with:file'
        ];
    }
}
