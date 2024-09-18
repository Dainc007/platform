<?php

namespace App\Http\Requests\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{

    public function authorize(): bool
    {
        return $this->user()->can('update setting');
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
