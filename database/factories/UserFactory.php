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
    protected static ?string $password;

    /**
     * Определяет состояние модели по умолчанию.
     */
    public function definition(): array
    {
        return [
            'name' => fake('ru_RU')->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'phone' => fake('ru_RU')->phoneNumber(),
            'avatar' => null,
            'role' => 'buyer',
            'is_verified' => fake()->boolean(30),
        ];
    }

    /**
     * Email не подтверждён.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Пользователь — продавец.
     */
    public function seller(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'seller',
            'is_verified' => true,
        ]);
    }

    /**
     * Пользователь — администратор.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'is_verified' => true,
        ]);
    }
}
