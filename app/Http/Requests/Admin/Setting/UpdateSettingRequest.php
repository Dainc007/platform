<?php

namespace App\Http\Requests\Admin\Setting;

use App\Models\Setting;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{

    public function authorize()
    {
        return $this->user()->can('update', Setting::class);
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
