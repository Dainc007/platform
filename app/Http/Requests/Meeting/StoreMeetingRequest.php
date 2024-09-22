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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:128',
            ],
            'description' => [
                'nullable',
                'string',
                'max:512'
            ],
            'date' => [
                'required',
                'string',
                'date_format:Y-m-d',
                'after_or_equal:now'
            ],
            'start_date' => [
                'required',
                'string',
                'date_format:Y-m-d H:i:s',
                'after_or_equal:now',
                new AvailableStartDate(),
            ],
            'end_date' => [
                'required',
                'string',
                'date_format:Y-m-d H:i:s',
                'after:start_date',
                new AvailableEndDate(),
            ],
        ];
    }

    /**
     * @throws Exception
     */
    protected function prepareForValidation(): void
    {
        [$startPeriod, $endPeriod] = explode(' - ', isset($this->period) ? $this->period : '');

        $startDate = (new \DateTime($this->date .' '. $startPeriod));
        $endDate = (new \DateTime($this->date .' '. $endPeriod));

        $this->merge([
            'date' => date('Y-m-d', strtotime($this->date)),
            'start_date' => $startDate->format('Y-m-d H:i:s'),
            'end_date' => $endDate->format('Y-m-d H:i:s'),
        ]);
    }

    public function getForInsert(): array
    {
        return [
            'title' => $this->title,
            'description' => $this?->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'user_id' => $this->user()->id,
        ];
    }
}
