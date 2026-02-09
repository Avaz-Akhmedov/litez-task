<?php

namespace Database\Factories\Crm;

use App\Enums\Crm\RecurrenceType;
use App\Enums\Crm\TaskPriority;
use App\Enums\Crm\TaskStatus;
use App\Enums\Crm\TaskType;
use App\Models\Crm\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isRecurring = $this->faker->boolean(30);

        return [

            'user_id' => User::factory(),
            'client_id' => Client::factory(),

            'type' => $this->faker->randomElement(TaskType::cases())->value,
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->optional()->paragraph(),

            'priority' => $this->faker->randomElement(TaskPriority::cases())->value,

            'status' => $this->faker->randomElement(TaskStatus::cases())->value,

            'deadline' => $this->faker->dateTimeBetween('now', '+1 month'),

            'is_recurring' => $isRecurring,
            'recurrence_type' => $isRecurring
                ? $this->faker->randomElement(RecurrenceType::cases())->value
                : null,

            'remind_before_minutes' => $this->faker->optional()->randomElement([5, 10, 30, 60]),
            'remind_via' => $this->faker->optional()->randomElement(['email', 'sms']),
            'reminder_sent_at' => null,
            'completed_at' => null,
        ];
    }

    public function completed(): self
    {
        return $this->state(fn() => [
            'status' => TaskStatus::Done,
            'completed_at' => now(),
        ]);
    }
}
