<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_page_loads_successfully(): void
    {
        $response = $this->get('/catalog');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Catalog/Index'));
    }

    public function test_catalog_displays_products(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->seller()->create();

        Product::factory(5)->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'status' => 'active',
        ]);

        $response = $this->get('/catalog');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Catalog/Index')
            ->has('products.data', 5)
        );
    }

    public function test_catalog_filters_by_category(): void
    {
        $category1 = Category::factory()->create(['slug' => 'electronics']);
        $category2 = Category::factory()->create(['slug' => 'fashion']);
        $user = User::factory()->seller()->create();

        Product::factory(3)->create([
            'category_id' => $category1->id,
            'user_id' => $user->id,
            'status' => 'active',
        ]);

        Product::factory(2)->create([
            'category_id' => $category2->id,
            'user_id' => $user->id,
            'status' => 'active',
        ]);

        $response = $this->get('/catalog?category=electronics');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Catalog/Index')
            ->has('products.data', 3)
        );
    }

    public function test_catalog_filters_by_search_query(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->seller()->create();

        Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'title' => 'iPhone 14 Pro',
            'status' => 'active',
        ]);

        Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'title' => 'Samsung Galaxy',
            'status' => 'active',
        ]);

        $response = $this->get('/catalog?q=iPhone');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Catalog/Index')
            ->has('products.data', 1)
        );
    }

    public function test_catalog_filters_by_price_range(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->seller()->create();

        Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'price' => 500,
            'status' => 'active',
        ]);

        Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'price' => 1500,
            'status' => 'active',
        ]);

        Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'price' => 3000,
            'status' => 'active',
        ]);

        $response = $this->get('/catalog?min_price=1000&max_price=2000');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Catalog/Index')
            ->has('products.data', 1)
        );
    }

    public function test_catalog_only_shows_active_products(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->seller()->create();

        Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'status' => 'active',
        ]);

        Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'status' => 'pending',
        ]);

        Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'status' => 'sold',
        ]);

        $response = $this->get('/catalog');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Catalog/Index')
            ->has('products.data', 1)
        );
    }

    public function test_catalog_paginates_products(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->seller()->create();

        Product::factory(20)->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'status' => 'active',
        ]);

        $response = $this->get('/catalog');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Catalog/Index')
            ->has('products.data', 12)
            ->has('products.meta')
        );
    }
}
