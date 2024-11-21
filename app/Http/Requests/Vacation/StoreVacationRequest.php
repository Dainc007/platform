<?php

namespace App\Http\Requests\Vacation;

use Illuminate\Foundation\Http\FormRequest;

class StoreVacationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'startDate' => 'required',
            'endDate' => 'required|date',
            'message' => 'nullable|string',
            'hours_worked' => 'nullable|integer',
            'note' => 'nullable|string',
        ];
    }
}
