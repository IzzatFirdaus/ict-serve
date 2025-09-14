<?php

namespace Database\Factories;

use App\Models\HelpdeskTicket;
use Illuminate\Database\Eloquent\Factories\Factory;

class HelpdeskTicketFactory extends Factory
{
    protected $model = HelpdeskTicket::class;

    public function definition(): array
    {
        return [
            'ticket_number' => 'TCK-'.$this->faker->unique()->numerify('#####'),
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(),
            'priority' => 'medium', // Valid enum value
            'category_id' => \App\Models\TicketCategory::factory(),
            'user_id' => 1, // Will be set in test
            'status_id' => \App\Models\TicketStatus::factory(),
            'due_at' => now()->addDays(3),
        ];
    }
}
