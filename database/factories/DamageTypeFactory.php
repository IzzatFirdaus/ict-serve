<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DamageType>
 */
class DamageTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $damageTypes = [
            ['Hardware Malfunction', 'Kerosakan Perkakasan'],
            ['Software Issue', 'Masalah Perisian'],
            ['Network Problem', 'Masalah Rangkaian'],
            ['Power Supply Failure', 'Kegagalan Bekalan Kuasa'],
            ['Display Issue', 'Masalah Paparan'],
            ['Audio Problem', 'Masalah Audio'],
            ['Peripheral Device Error', 'Ralat Peranti Luaran'],
        ];

        $randomType = fake()->randomElement($damageTypes);

        return [
            'name_en' => $randomType[0],
            'name_bm' => $randomType[1],
            'is_active' => fake()->boolean(80), // 80% chance of being active
        ];
    }
}
