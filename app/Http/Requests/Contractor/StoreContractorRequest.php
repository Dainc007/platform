<?php

namespace App\Http\Requests\Contractor;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class StoreContractorRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'file' => 'nullable|file|max:100240',
            'currency_id' => 'required_with:file',
            'brand_id' => 'required_with:file',
            'type' => 'required|string|in:' . implode(',', Product::AVAILABLE_TYPES),
        ];
    }
}
