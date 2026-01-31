<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Определяет состояние модели по умолчанию.
     */
    public function definition(): array
    {
        $name = fake('ru_RU')->unique()->word();

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'description' => fake('ru_RU')->sentence(),
            'icon' => null,
            'sort_order' => fake()->numberBetween(0, 100),
            'products_count' => 0,
        ];
    }
}
