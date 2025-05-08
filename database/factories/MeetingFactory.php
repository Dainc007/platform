<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Carbon\CarbonImmutable;
use App\Models\Meeting;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meeting>
 */
class MeetingFactory extends Factory
{
    private Collection $users;

    public function __construct($count = null, ?Collection $states = null, ?Collection $has = null, ?Collection $for = null, ?Collection $afterMaking = null, ?Collection $afterCreating = null, $connection = null, ?Collection $recycle = null)
    {
        parent::__construct($count, $states, $has, $for, $afterMaking, $afterCreating, $connection, $recycle);

        $this->users = User::get();
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-1 month', '+1 month');
        $endDate = CarbonImmutable::parse($startDate)->addMinutes(Meeting::DURATION);
        return [
            'user_id' => fake()->randomElement($this->users)->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'hours_worked' => fake()->numberBetween(1, 8),
            'status' => fake()->randomElement(Meeting::AVAILABLE_STATUSES),
        ];
    }
}
