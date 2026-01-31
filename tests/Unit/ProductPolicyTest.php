<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Policies\ProductPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductPolicyTest extends TestCase
{
    use RefreshDatabase;

    private ProductPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new ProductPolicy();
    }

    public function test_anyone_can_view_active_product(): void
    {
        $category = Category::factory()->create();
        $seller = User::factory()->seller()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $seller->id,
            'status' => 'active',
        ]);

        $this->assertTrue($this->policy->view(null, $product));
    }

    public function test_only_owner_can_view_pending_product(): void
    {
        $category = Category::factory()->create();
        $seller = User::factory()->seller()->create();
        $otherUser = User::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $seller->id,
            'status' => 'pending',
        ]);

        $this->assertTrue($this->policy->view($seller, $product));
        $this->assertFalse($this->policy->view($otherUser, $product));
    }

    public function test_admin_can_view_any_product(): void
    {
        $category = Category::factory()->create();
        $seller = User::factory()->seller()->create();
        $admin = User::factory()->admin()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $seller->id,
            'status' => 'pending',
        ]);

        $this->assertTrue($this->policy->view($admin, $product));
    }

    public function test_seller_can_create_product(): void
    {
        $seller = User::factory()->seller()->create();

        $this->assertTrue($this->policy->create($seller));
    }

    public function test_buyer_cannot_create_product(): void
    {
        $buyer = User::factory()->create();

        $this->assertFalse($this->policy->create($buyer));
    }

    public function test_owner_can_update_product(): void
    {
        $category = Category::factory()->create();
        $seller = User::factory()->seller()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $seller->id,
        ]);

        $this->assertTrue($this->policy->update($seller, $product));
    }

    public function test_other_user_cannot_update_product(): void
    {
        $category = Category::factory()->create();
        $seller = User::factory()->seller()->create();
        $otherUser = User::factory()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $seller->id,
        ]);

        $this->assertFalse($this->policy->update($otherUser, $product));
    }

    public function test_admin_can_update_any_product(): void
    {
        $category = Category::factory()->create();
        $seller = User::factory()->seller()->create();
        $admin = User::factory()->admin()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $seller->id,
        ]);

        $this->assertTrue($this->policy->update($admin, $product));
    }

    public function test_owner_can_delete_product(): void
    {
        $category = Category::factory()->create();
        $seller = User::factory()->seller()->create();

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'user_id' => $seller->id,
        ]);

        $this->assertTrue($this->policy->delete($seller, $product));
    }
}
