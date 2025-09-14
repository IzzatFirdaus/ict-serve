<?php

namespace Database\Factories;

use App\Models\TicketCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketCategoryFactory extends Factory
{
    protected $model = TicketCategory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'name_bm' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'description_bm' => $this->faker->sentence(),
            'icon' => 'icon-default',
            'priority' => 'medium',
            'default_sla_hours' => 24,
            'is_active' => true,
            'sort_order' => 1,
        ];
    }
}
