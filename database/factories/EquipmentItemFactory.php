<?php

namespace Database\Factories;

use App\Enums\EquipmentCondition;
use App\Enums\EquipmentStatus;
use App\Models\EquipmentCategory;
use App\Models\EquipmentItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EquipmentItem>
 */
class EquipmentItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EquipmentItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => EquipmentCategory::factory(),
            'asset_tag' => fake()->unique()->bothify('ASSET-###-????'),
            'serial_number' => fake()->unique()->bothify('SN###########'),
            'brand' => fake()->randomElement([
                'Dell',
                'HP',
                'Lenovo',
                'ASUS',
                'Acer',
                'Epson',
                'Canon',
            ]),
            'model' => fake()->bothify('Model ###-????'),
            'specifications' => fake()->paragraph(2),
            'description' => fake()->optional(0.7)->sentence(),
            'condition' => fake()->randomElement(EquipmentCondition::cases()),
            'status' => fake()->randomElement(EquipmentStatus::cases()),
            'purchase_price' => fake()->optional(0.8)->randomFloat(2, 500, 5000),
            'purchase_date' => fake()->dateTimeBetween('-3 years', '-1 year'),
            'warranty_expiry' => fake()->optional(0.9)->dateTimeBetween('now', '+2 years'),
            'location' => fake()->randomElement([
                'Storage Room A',
                'IT Office',
                'Meeting Room 1',
                'Conference Hall',
                'Training Center',
            ]),
            'notes' => fake()->optional(0.3)->sentence(),
            'is_active' => fake()->boolean(90), // 90% chance of being active
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the equipment is available.
     */
    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => EquipmentStatus::AVAILABLE,
        ]);
    }

    /**
     * Indicate that the equipment is on loan.
     */
    public function onLoan(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => EquipmentStatus::ON_LOAN,
        ]);
    }

    /**
     * Indicate that the equipment is in maintenance.
     */
    public function maintenance(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => EquipmentStatus::MAINTENANCE,
        ]);
    }

    /**
     * Indicate that the equipment is retired.
     */
    public function retired(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => EquipmentStatus::RETIRED,
        ]);
    }
}
