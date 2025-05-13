<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MinWords implements ValidationRule
{
    /**
     * The minimum number of words required.
     *
     * @var int
     */
    protected $minWords;

    /**
     * Create a new rule instance.
     *
     * @param  int  $minWords
     * @return void
     */
    public function __construct(int $minWords)
    {
        $this->minWords = $minWords;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (str_word_count(trim($value)) < $this->minWords) {
            $fail(__('validation.min_words', [
                'attribute' => $attribute,
                'min' => $this->minWords
            ]));
        }
    }
} 