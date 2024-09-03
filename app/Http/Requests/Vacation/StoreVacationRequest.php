<?php

namespace App\Http\Requests\Vacation;

use Illuminate\Foundation\Http\FormRequest;

class StoreVacationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => 'required|array|size:2',
            'date.0' => 'required|date',
            'date.1' => 'nullable|date',
        ];
    }
}
