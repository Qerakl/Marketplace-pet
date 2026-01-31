<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;

class ProductService
{
    /**
     * Создаёт новый товар.
     */
    public function create(User $user, array $data): Product
    {
        $data['user_id'] = $user->id;
        $data['slug'] = $this->generateSlug($data['title']);
        $data['status'] = 'pending';

        return Product::create($data);
    }

    /**
     * Обновляет товар.
     */
    public function update(Product $product, array $data): Product
    {
        if (isset($data['title']) && $data['title'] !== $product->title) {
            $data['slug'] = $this->generateSlug($data['title']);
        }

        $product->update($data);

        return $product->fresh();
    }

    /**
     * Удаляет товар.
     */
    public function delete(Product $product): bool
    {
        return $product->delete();
    }

    /**
     * Генерирует уникальный slug.
     */
    protected function generateSlug(string $title): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    /**
     * Пересчитывает рейтинг товара.
     */
    public function recalculateRating(Product $product): void
    {
        $avgRating = $product->reviews()->avg('rating') ?? 0;
        $product->update(['rating' => round($avgRating, 1)]);
    }
}
