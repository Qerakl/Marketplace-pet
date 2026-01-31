<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Проверяет, может ли пользователь просматривать товар.
     */
    public function view(?User $user, Product $product): bool
    {
        if ($product->status === 'active') {
            return true;
        }

        return $user && ($user->id === $product->user_id || $user->isAdmin());
    }

    /**
     * Проверяет, может ли пользователь создавать товары.
     */
    public function create(User $user): bool
    {
        return $user->isSeller();
    }

    /**
     * Проверяет, может ли пользователь редактировать товар.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->id === $product->user_id || $user->isAdmin();
    }

    /**
     * Проверяет, может ли пользователь удалять товар.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->id === $product->user_id || $user->isAdmin();
    }

    /**
     * Проверяет, может ли пользователь менять статус товара.
     */
    public function changeStatus(User $user, Product $product): bool
    {
        return $user->id === $product->user_id || $user->isAdmin();
    }
}
