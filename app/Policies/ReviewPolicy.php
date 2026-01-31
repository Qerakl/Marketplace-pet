<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    /**
     * Проверяет, может ли пользователь создать отзыв.
     */
    public function create(User $user, Product $product): bool
    {
        // Нельзя оставлять отзыв на свой товар
        if ($user->id === $product->user_id) {
            return false;
        }

        // Один отзыв на товар
        return !Review::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->exists();
    }

    /**
     * Проверяет, может ли пользователь редактировать отзыв.
     */
    public function update(User $user, Review $review): bool
    {
        return $user->id === $review->user_id;
    }

    /**
     * Проверяет, может ли пользователь удалять отзыв.
     */
    public function delete(User $user, Review $review): bool
    {
        return $user->id === $review->user_id || $user->isAdmin();
    }
}
