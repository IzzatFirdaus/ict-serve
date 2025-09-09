<?php

namespace Database\Factories;

use App\Models\LoanRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\LoanRequest>
 */
class LoanRequestFactory extends Factory
{
    protected $model = LoanRequest::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomNumber(),
            'status_id' => $this->faker->randomNumber(),
            'requested_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
