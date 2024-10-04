<?php

namespace App\Http\Requests\Meeting;

use App\Rules\AvailableEndDate;
use App\Rules\AvailableStartDate;
use Exception;
use Illuminate\Foundation\Http\FormRequest;

class StoreMeetingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hoursWorked' => 'integer|min:0',
            'date' => 'required|date|after_or_equal:today',
            'note' => 'nullable|string',
            'startDate' => 'required|date_format:Y-m-d H:i:s',
            'endDate' => 'required|after:startDate|date_format:Y-m-d H:i:s',
        ];
    }

    /**
     * @throws Exception
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'date' => date('Y-m-d', strtotime($this->date)),
            'startDate' => date('Y-m-d', strtotime($this->date)) . ' ' . date('H:i:s', strtotime($this->hours['start_date'])),
            'endDate' => date('Y-m-d', strtotime($this->date)) . ' ' . date('H:i:s', strtotime($this->hours['end_date'])),
        ]);
    }

    public function getForInsert(): array
    {
        return [
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'hours_worked' => $this->hoursWorked,
            'user_id' => $this->user()->id,
            'status' => 'booked'
        ];
    }
}
