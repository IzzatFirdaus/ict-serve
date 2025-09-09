<?php

namespace Database\Factories;

use App\Models\EquipmentItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\EquipmentItem>
 */
class EquipmentItemFactory extends Factory
{
    protected $model = EquipmentItem::class;

    public function definition(): array
    {
        return [
            'category_id' => $this->faker->randomNumber(),
            'name' => $this->faker->word(),
            'serial_number' => $this->faker->uuid(),
            'status' => $this->faker->word(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
