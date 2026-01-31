<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'description',
        'price',
        'old_price',
        'location',
        'status',
        'views_count',
        'rating',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'rating' => 'decimal:1',
        'views_count' => 'integer',
    ];

    /**
     * Продавец товара.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Категория товара.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Изображения товара.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    /**
     * Главное изображение товара.
     */
    public function mainImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_main', true);
    }

    /**
     * Отзывы о товаре.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Пользователи, добавившие в избранное.
     */
    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')
            ->withTimestamps();
    }

    /**
     * Только активные товары.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    /**
     * Фильтрация по параметрам.
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['q'] ?? null, function (Builder $q, string $search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->when($filters['category'] ?? null, function (Builder $q, string $slug) {
                $q->whereHas('category', fn ($c) => $c->where('slug', $slug));
            })
            ->when($filters['min_price'] ?? null, function (Builder $q, $price) {
                $q->where('price', '>=', $price);
            })
            ->when($filters['max_price'] ?? null, function (Builder $q, $price) {
                $q->where('price', '<=', $price);
            });
    }

    /**
     * Сортировка по параметру.
     */
    public function scopeSorted(Builder $query, ?string $sort): Builder
    {
        return match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'popular' => $query->orderByDesc('views_count'),
            default => $query->orderByDesc('created_at'),
        };
    }

    /**
     * Форматированная цена.
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, '', ' ') . ' ₽';
    }

    /**
     * Форматированная старая цена.
     */
    public function getFormattedOldPriceAttribute(): ?string
    {
        if (!$this->old_price) {
            return null;
        }

        return number_format($this->old_price, 0, '', ' ') . ' ₽';
    }

    /**
     * Есть ли скидка.
     */
    public function getHasDiscountAttribute(): bool
    {
        return $this->old_price && $this->old_price > $this->price;
    }

    /**
     * URL товара.
     */
    public function getUrlAttribute(): string
    {
        return route('products.show', $this->slug);
    }
}
