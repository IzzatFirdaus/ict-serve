<?php

namespace Database\Factories;

use App\Models\EquipmentCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EquipmentCategory>
 */
class EquipmentCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EquipmentCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            ['name' => 'Laptop', 'name_bm' => 'Komputer Riba'],
            ['name' => 'Desktop', 'name_bm' => 'Komputer Meja'],
            ['name' => 'Monitor', 'name_bm' => 'Monitor'],
            ['name' => 'Printer', 'name_bm' => 'Printer'],
            ['name' => 'Projector', 'name_bm' => 'Projektor'],
            ['name' => 'Scanner', 'name_bm' => 'Pengimbas'],
            ['name' => 'Camera', 'name_bm' => 'Kamera'],
            ['name' => 'Audio Equipment', 'name_bm' => 'Peralatan Audio'],
            ['name' => 'Network Equipment', 'name_bm' => 'Peralatan Rangkaian'],
            ['name' => 'Other', 'name_bm' => 'Lain-lain'],
        ];

        $category = fake()->randomElement($categories);

        return [
            'name' => $category['name'],
            'name_bm' => $category['name_bm'],
            'description' => fake()->optional(0.7)->sentence(),
            'description_bm' => fake()->optional(0.7)->sentence(),
            'icon' => fake()->optional(0.5)->randomElement([
                'laptop',
                'desktop',
                'monitor',
                'printer',
                'projector',
                'scanner',
                'camera',
                'headphones',
                'router',
                'other',
            ]),
            'is_active' => fake()->boolean(85), // 85% chance of being active
            'sort_order' => fake()->numberBetween(1, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the category is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the category is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
