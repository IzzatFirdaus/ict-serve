<?php

namespace Database\Factories;

use App\Models\TicketStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketStatusFactory extends Factory
{
    protected $model = TicketStatus::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Open', 'Assigned', 'In Progress', 'Resolved', 'Closed']),
        ];
    }
}
