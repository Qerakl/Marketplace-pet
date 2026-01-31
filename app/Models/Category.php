<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'sort_order',
        'products_count',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'products_count' => 'integer',
    ];

    /**
     * Товары в категории.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Сортировка по порядку.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Только категории с товарами.
     */
    public function scopeWithProducts(Builder $query): Builder
    {
        return $query->where('products_count', '>', 0);
    }

    /**
     * Генерирует URL категории.
     */
    public function getUrlAttribute(): string
    {
        return route('catalog.index', ['category' => $this->slug]);
    }
}
