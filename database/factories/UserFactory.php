<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'staff_id' => fake()->unique()->regexify('[A-Z]{3}[0-9]{3}'),
            'division' => fake()->randomElement([
                'ICT Division',
                'Tourism Division',
                'Arts and Culture Division',
                'Policy and Strategic Planning Division',
                'Corporate Division',
            ]),
            'department' => fake()->randomElement([
                'Information Technology',
                'Tourism Development',
                'Arts Development',
                'Cultural Heritage',
                'Strategic Planning',
                'Human Resources',
                'Finance',
            ]),
            'position' => fake()->randomElement([
                'Assistant Director',
                'Principal Assistant Director',
                'Senior Officer',
                'Officer',
                'Assistant Officer',
                'System Administrator',
                'Technician',
            ]),
            'phone' => fake()->phoneNumber(),
            'role' => 'user',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
