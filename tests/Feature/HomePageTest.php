<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_home_page_displays_categories(): void
    {
        Category::factory(3)->create();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Welcome')
            ->has('categories', 3)
        );
    }

    public function test_home_page_displays_featured_products(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->seller()->create();

        Product::factory(5)->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'status' => 'active',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Welcome')
            ->has('featured', 4)
        );
    }

    public function test_home_page_contains_stats(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Welcome')
            ->has('stats')
            ->has('stats.products_count')
            ->has('stats.sellers_count')
        );
    }
}
