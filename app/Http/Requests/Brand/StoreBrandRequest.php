<?php

namespace App\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBrandRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|unique:brands,name',
        ];
    }
}
