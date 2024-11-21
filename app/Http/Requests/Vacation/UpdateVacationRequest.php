<?php

namespace App\Http\Requests\Vacation;

use App\Models\Vacation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVacationRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'start_at' => $this->startDate,
            'end_at' => $this->endDate,
        ]);
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(Vacation::AVAILABLE_STATUSES)],
            'message' => ['nullable', 'string'],
            'start_at' => ['nullable', 'date'],
            'end_at' => ['nullable', 'date', 'after_or_equal:start_at'],
        ];
    }
}
