<?php

namespace App\Http\Requests\Vacation;

use App\Models\Vacation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVacationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(Vacation::AVAILABLE_STATUSES)],
            'message' => ['nullable', 'string'],
        ];
    }
}
