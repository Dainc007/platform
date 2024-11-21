<?php

namespace App\Http\Requests\Meeting;

use App\Models\Meeting;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMeetingRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'required|in:' . implode(',', Meeting::AVAILABLE_STATUSES),
        ];
    }
}
