<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMeetingDateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => 'required|date|date_format:Y-m-d',
            'is_disabled' => 'required|boolean',
        ];
    }
}
