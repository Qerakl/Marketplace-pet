<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Заполняет таблицу товаров.
     */
    public function run(): void
    {
        $sellers = User::factory(20)->seller()->create();
        $buyers = User::factory(50)->create();
        $categories = Category::all();

        foreach ($sellers as $seller) {
            $productsCount = rand(3, 10);

            for ($i = 0; $i < $productsCount; $i++) {
                $product = Product::factory()->create([
                    'user_id' => $seller->id,
                    'category_id' => $categories->random()->id,
                ]);

                // Главное изображение
                ProductImage::factory()->main()->create([
                    'product_id' => $product->id,
                ]);

                // Дополнительные изображения
                $extraImages = rand(0, 4);
                for ($j = 0; $j < $extraImages; $j++) {
                    ProductImage::factory()->create([
                        'product_id' => $product->id,
                        'sort_order' => $j + 1,
                    ]);
                }

                // Отзывы
                $reviewsCount = rand(0, 8);
                $reviewers = $buyers->random(min($reviewsCount, $buyers->count()));

                foreach ($reviewers as $reviewer) {
                    Review::factory()->create([
                        'product_id' => $product->id,
                        'user_id' => $reviewer->id,
                    ]);
                }

                // Пересчитываем рейтинг
                $avgRating = $product->reviews()->avg('rating') ?? 0;
                $product->update(['rating' => round($avgRating, 1)]);
            }
        }

        // Обновляем счётчики товаров в категориях
        foreach ($categories as $category) {
            $category->update([
                'products_count' => $category->products()->active()->count(),
            ]);
        }
    }
}
