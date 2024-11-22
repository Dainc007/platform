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

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated();

        if (is_null($validated['start_at'])) {
            unset($validated['start_at']);
        }

        if (is_null($validated['end_at'])) {
            unset($validated['end_at']);
        }

        return $validated;
    }
}
