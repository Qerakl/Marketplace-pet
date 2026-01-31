<?php

namespace App\Services\Catalog;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryService
{
    /**
     * Возвращает все категории.
     */
    public function getAll(): Collection
    {
        return Category::query()
            ->ordered()
            ->get(['id', 'name', 'slug', 'description', 'icon', 'products_count']);
    }

    /**
     * Возвращает категорию по slug.
     */
    public function getBySlug(string $slug): ?Category
    {
        return Category::query()
            ->where('slug', $slug)
            ->first();
    }

    /**
     * Обновляет счётчик товаров в категориях.
     */
    public function updateProductsCount(): void
    {
        Category::query()->update(['products_count' => 0]);

        $counts = \DB::table('products')
            ->select('category_id', \DB::raw('count(*) as count'))
            ->where('status', 'active')
            ->groupBy('category_id')
            ->get();

        foreach ($counts as $item) {
            Category::where('id', $item->category_id)
                ->update(['products_count' => $item->count]);
        }
    }
}
