<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_page_loads_successfully(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->seller()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'status' => 'active',
        ]);

        $response = $this->get("/products/{$product->slug}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Products/Show'));
    }

    public function test_product_page_increments_views(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->seller()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'status' => 'active',
            'views_count' => 10,
        ]);

        $this->get("/products/{$product->slug}");

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'views_count' => 11,
        ]);
    }

    public function test_product_page_returns_404_for_nonexistent_product(): void
    {
        $response = $this->get('/products/nonexistent-product');

        $response->assertStatus(404);
    }

    public function test_product_page_contains_product_data(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->seller()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'title' => 'Test Product',
            'status' => 'active',
        ]);

        $response = $this->get("/products/{$product->slug}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Products/Show')
            ->has('product')
            ->where('product.title', 'Test Product')
        );
    }

    public function test_product_page_contains_similar_products(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->seller()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'status' => 'active',
        ]);

        Product::factory(5)->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'status' => 'active',
        ]);

        $response = $this->get("/products/{$product->slug}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Products/Show')
            ->has('similar', 4)
        );
    }
}
