<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class AvailableStartDate implements ValidationRule, DataAwareRule
{
    /**
     * All the data under validation.
     * @var array<string, mixed>
     */
    protected array $data = [];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $availableStartTime = [
            '8:00',
            '8:21',
            '8:41',
            '9:01',
            '9:21',
            '9:41',
            '10:01',
            '10:21',
            '10:41',
            '11:01',
            '11:21',
            '11:41',
            '12:01',
            '12:21',
            '12:41',
            '13:01',
            '13:21',
            '13:41',
            '14:01',
            '14:21',
            '14:41',
            '15:01',
            '15:21',
            '15:41',
        ];

        $currentStartTime = Carbon::parse($value);

        if (!in_array($currentStartTime->format('H:i'), $availableStartTime)) {
            $fail('The :attribute is invalid.');
        }

        if (Carbon::parse($this->data['date'])->isToday()) {
            if ($currentStartTime->isPast()) {
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
