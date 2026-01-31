<?php

namespace App\Services\Home;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;

class HomePageService
{
    /**
     * Возвращает данные для главной страницы.
     */
    public function getData(): array
    {
        return [
            'categories' => $this->getCategories(),
            'featured' => $this->getFeaturedProducts(),
            'stats' => $this->getStats(),
        ];
    }

    /**
     * Возвращает категории для главной страницы.
     */
    public function getCategories(): Collection
    {
        return Category::query()
            ->ordered()
            ->limit(8)
            ->get(['id', 'name', 'slug', 'description', 'icon', 'products_count']);
    }

    /**
     * Возвращает популярные товары.
     */
    public function getFeaturedProducts(): Collection
    {
        return Product::query()
            ->with(['category:id,name,slug', 'mainImage', 'user:id,name'])
            ->withCount('reviews')
            ->active()
            ->orderByDesc('views_count')
            ->limit(4)
            ->get();
    }

    /**
     * Возвращает статистику платформы.
     */
    public function getStats(): array
    {
        return [
            'products_count' => Product::active()->count(),
            'sellers_count' => Product::active()->distinct('user_id')->count('user_id'),
            'categories_count' => Category::count(),
        ];
    }
}
