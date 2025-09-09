<?php

namespace Database\Factories;

use App\Models\HelpdeskTicket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\HelpdeskTicket>
 */
class HelpdeskTicketFactory extends Factory
{
    protected $model = HelpdeskTicket::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomNumber(),
            'category_id' => $this->faker->randomNumber(),
            'status_id' => $this->faker->randomNumber(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
