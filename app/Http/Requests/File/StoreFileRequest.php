<?php

namespace App\Http\Requests\File;

use App\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'file' => 'required|file|max:10240',
            'currency_id' => 'required',
            'brand_id' => 'required',
            'contractor_id'  => 'required',
            'type' => 'required|string|in:' . implode(',', Product::AVAILABLE_TYPES),
        ];
    }
}
