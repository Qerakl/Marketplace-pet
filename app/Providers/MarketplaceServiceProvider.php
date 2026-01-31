<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Review;
use App\Policies\ProductPolicy;
use App\Policies\ReviewPolicy;
use App\Services\Catalog\CatalogService;
use App\Services\Catalog\CategoryService;
use App\Services\Home\HomePageService;
use App\Services\Product\ProductService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class MarketplaceServiceProvider extends ServiceProvider
{
    /**
     * Регистрирует сервисы маркетплейса.
     */
    public function register(): void
    {
        $this->app->singleton(HomePageService::class);
        $this->app->singleton(CatalogService::class);
        $this->app->singleton(CategoryService::class);
        $this->app->singleton(ProductService::class);
    }

    /**
     * Загружает сервисы маркетплейса.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }

    /**
     * Регистрирует политики доступа.
     */
    protected function registerPolicies(): void
    {
        Gate::policy(Product::class, ProductPolicy::class);
        Gate::policy(Review::class, ReviewPolicy::class);
    }
}
