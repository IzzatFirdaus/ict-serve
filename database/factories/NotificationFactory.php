<?php

namespace Database\Factories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomNumber(),
            'type' => $this->faker->word(),
            'data' => $this->faker->sentence(),
            'read_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
