<?php

namespace Database\Factories;

use App\Models\TicketStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TicketStatusFactory extends Factory
{
    protected $model = TicketStatus::class;

    public function definition(): array
    {
        $code = strtoupper(Str::slug($this->faker->unique()->words(2, true), '_'));
        return [
            'code' => $code,
            'name' => ucwords(str_replace('_', ' ', strtolower($code))),
            'name_bm' => null,
            'is_active' => true,
            'is_final' => false,
            // Provide a sensible default color (neutral gray) to satisfy NOT NULL
            'color' => '#64748B',
            'sort_order' => $this->faker->numberBetween(1, 99),
        ];
    }
}
