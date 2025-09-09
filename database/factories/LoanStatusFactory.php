<?php

namespace Database\Factories;

use App\Models\LoanStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\LoanStatus>
 */
class LoanStatusFactory extends Factory
{
    protected $model = LoanStatus::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
