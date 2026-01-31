<?php

namespace App\Services\Catalog;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class CatalogService
{
    /**
     * Возвращает список товаров с фильтрацией и пагинацией.
     */
    public function getProducts(array $filters, int $perPage = 12): LengthAwarePaginator
    {
        return Product::query()
            ->with(['category:id,name,slug', 'mainImage', 'user:id,name'])
            ->withCount('reviews')
            ->active()
            ->filter($filters)
            ->sorted($filters['sort'] ?? null)
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Возвращает товар по slug с полными данными.
     */
    public function getProductBySlug(string $slug): ?Product
    {
        return Product::query()
            ->with([
                'category:id,name,slug',
                'mainImage',
                'images',
                'user:id,name,avatar,is_verified',
                'reviews' => fn ($q) => $q->with('user:id,name,avatar')->latest()->limit(10),
            ])
            ->withCount('reviews')
            ->where('slug', $slug)
            ->first();
    }

    /**
     * Увеличивает счётчик просмотров.
     */
    public function incrementViews(Product $product): void
    {
        $product->increment('views_count');
    }

    /**
     * Возвращает похожие товары.
     */
    public function getSimilarProducts(Product $product, int $limit = 4): \Illuminate\Support\Collection
    {
        return Product::query()
            ->with(['category:id,name,slug', 'mainImage'])
            ->withCount('reviews')
            ->active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }
}
