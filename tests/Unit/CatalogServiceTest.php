<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Services\Catalog\CatalogService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogServiceTest extends TestCase
{
    use RefreshDatabase;

    private CatalogService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CatalogService();
    }

    public function test_get_products_returns_only_active_products(): void
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

        $result = $this->service->getProducts([]);

        $this->assertEquals(1, $result->total());
    }

    public function test_get_products_filters_by_category(): void
    {
        $category1 = Category::factory()->create(['slug' => 'cat1']);
        $category2 = Category::factory()->create(['slug' => 'cat2']);
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

        $result = $this->service->getProducts(['category' => 'cat1']);

        $this->assertEquals(3, $result->total());
    }

    public function test_get_products_filters_by_search(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->seller()->create();

        Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'title' => 'iPhone 14',
            'status' => 'active',
        ]);

        Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'title' => 'Samsung Phone',
            'status' => 'active',
        ]);

        $result = $this->service->getProducts(['q' => 'iPhone']);

        $this->assertEquals(1, $result->total());
    }

    public function test_get_products_filters_by_min_price(): void
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

        $result = $this->service->getProducts(['min_price' => 1000]);

        $this->assertEquals(1, $result->total());
    }

    public function test_get_product_by_slug_returns_product(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->seller()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'slug' => 'test-product',
        ]);

        $result = $this->service->getProductBySlug('test-product');

        $this->assertNotNull($result);
        $this->assertEquals($product->id, $result->id);
    }

    public function test_get_product_by_slug_returns_null_for_nonexistent(): void
    {
        $result = $this->service->getProductBySlug('nonexistent');

        $this->assertNull($result);
    }

    public function test_increment_views_increases_counter(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->seller()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'views_count' => 10,
        ]);

        $this->service->incrementViews($product);

        $this->assertEquals(11, $product->fresh()->views_count);
    }

    public function test_get_similar_products_excludes_current_product(): void
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

        $result = $this->service->getSimilarProducts($product);

        $this->assertCount(4, $result);
        $this->assertFalse($result->contains('id', $product->id));
    }
}
