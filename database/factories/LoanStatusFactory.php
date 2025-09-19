<?php

namespace Database\Factories;

use App\Models\LoanStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanStatusFactory extends Factory
{
    protected $model = LoanStatus::class;

    public function definition(): array
    {
        // Use only valid LoanRequestStatus enum values for code
        $validCodes = [
            'pending_supervisor',
            'approved_supervisor',
            'pending_ict',
            'approved_ict',
            'ready_pickup',
            'in_use',
            'returned',
            'overdue',
            'rejected',
            'cancelled',
        ];
        $code = $this->faker->unique()->randomElement($validCodes);

        return [
            'code' => $code,
            'name' => ucfirst(str_replace('_', ' ', $code)),
            'name_bm' => ucfirst(str_replace('_', ' ', $code)).' BM',
            'description' => $this->faker->sentence(),
            'description_bm' => $this->faker->sentence(),
            'color' => $this->faker->hexColor(),
            'is_active' => true,
            'sort_order' => $this->faker->numberBetween(1, 10),
        ];
    }
}
