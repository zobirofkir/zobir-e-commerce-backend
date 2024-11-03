<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ProductRequestTest extends TestCase
{

    public function generateAccessToken()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        return $user;
    }

    /**
     * Test Create Product
     */
    public function testCreateProduct(): void
    {
        $user = $this->generateAccessToken();
        $category = Category::factory()->create([
            "user_id" => $user->id
        ]);

        $products = Product::factory()->create([
            "user_id" => $user->id,
            "category_id" => $category->id
        ]);

        $response = $this->post("/api/products", $products->toArray());
        $response->assertStatus(201);
    }

    /**
     * Test Show Product
     */
    public function testShowProduct()
    {
        $user = $this->generateAccessToken();
        $category = Category::factory()->create([
            "user_id" => $user->id
        ]);

        $products = Product::factory()->create([
            "user_id" => $user->id,
            "category_id" => $category->id
        ]);

        $response = $this->get("/api/products/$products->id");
        $response->assertStatus(200);
    }

    /**
     * Test Delete Product
     */
    public function testDeleteProduct()
    {
        $user = $this->generateAccessToken();
        $category = Category::factory()->create([
            "user_id" => $user->id
        ]);

        $products = Product::factory()->create([
            "user_id" => $user->id,
            "category_id" => $category->id
        ]);

        $response = $this->delete("/api/products/$products->id");
        $response->assertStatus(200);
    }
}
