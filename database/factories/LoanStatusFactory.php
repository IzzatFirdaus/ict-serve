<?php

namespace Database\Factories;

use App\Models\LoanStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanStatusFactory extends Factory
{
    protected $model = LoanStatus::class;

    public function definition(): array
    {
        $code = $this->faker->unique()->randomElement([
            'pending_bpm_review',
            'pending_supervisor_approval',
            'pending_ict_approval',
            'approved',
            'rejected',
            'collected',
            'returned',
            'overdue',
            'cancelled',
        ]);

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
