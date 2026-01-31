<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Определяет состояние модели по умолчанию.
     */
    public function definition(): array
    {
        $title = fake('ru_RU')->words(rand(2, 5), true);
        $price = fake()->numberBetween(100, 100000);
        $hasDiscount = fake()->boolean(30);

        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => ucfirst($title),
            'slug' => Str::slug($title) . '-' . fake()->unique()->randomNumber(5),
            'description' => fake('ru_RU')->paragraphs(3, true),
            'price' => $price,
            'old_price' => $hasDiscount ? $price * 1.2 : null,
            'location' => fake('ru_RU')->city(),
            'status' => 'active',
            'views_count' => fake()->numberBetween(0, 5000),
            'rating' => fake()->randomFloat(1, 0, 5),
        ];
    }

    /**
     * Товар в ожидании модерации.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Товар продан.
     */
    public function sold(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'sold',
        ]);
    }
}
