<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class AvailableEndDate implements ValidationRule, DataAwareRule
{
    /**
     * All the data under validation.
     * @var array<string, mixed>
     */
    protected array $data = [];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $availableEndTime = [
            '8:20',
            '8:40',
            '9:00',
            '9:20',
            '9:40',
            '10:00',
            '10:20',
            '10:40',
            '11:00',
            '11:20',
            '11:40',
            '12:00',
            '12:20',
            '12:40',
            '13:00',
            '13:20',
            '13:40',
            '14:00',
            '14:20',
            '14:40',
            '15:00',
            '15:20',
            '15:40',
            '16:00',
        ];

        $currentEndTime = Carbon::parse($value);

        if (!in_array($currentEndTime->format('H:i'), $availableEndTime)) {
            $fail('The :attribute is invalid.');
        }

        if (Carbon::parse($this->data['date'])->isToday()) {
            if ($currentEndTime->isPast()) {
                $fail('The :attribute is invalid.');
            }
        }
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }
}
