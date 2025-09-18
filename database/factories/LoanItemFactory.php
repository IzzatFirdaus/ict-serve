<?php

namespace Database\Factories;

use App\Models\LoanItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\LoanItem>
 */
class LoanItemFactory extends Factory
{
    protected $model = LoanItem::class;

    public function definition(): array
    {
        return [
            'loan_request_id' => $this->faker->randomNumber(),
            'equipment_item_id' => $this->faker->randomNumber(),
            'status_id' => $this->faker->randomNumber(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
