<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreMeetingDateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'is_enabled' => 'boolean',
            'disabled_hours' => 'nullable',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'disabled_hours' => json_encode($this->input('disabled_hours', [])),
            'date' => Carbon::parse($this->input('date'))->format('Y-m-d'),
        ]);
    }
}
