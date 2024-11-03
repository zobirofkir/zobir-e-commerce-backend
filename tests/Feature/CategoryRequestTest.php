<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CategoryRequestTest extends TestCase
{
    use RefreshDatabase;

    public function generateAccessToken()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        return $user;
    }

    /**
     * Test the category create page.
     */
    public function testCreateCategory(): void
    {
        $user = $this->generateAccessToken();

        $categoryData = Category::factory()->make([
            'user_id' => $user->id,
        ])->toArray();

        $response = $this->post('/api/categories', $categoryData);
        $response->assertStatus(201);
    }

    /**
     * Test Get Categories
     */
    public function testGetCategories()
    {
        $this->generateAccessToken();
        $response = $this->get("/api/categories");
        $response->assertStatus(200);
    }


    /**
     * Test Update Category
     */
    public function testUpdateCategory()
    {
        $user = $this->generateAccessToken();
        $category = Category::factory()->create([
            'user_id' => $user->id,
        ]);

        $categoryData = [
            "title" => "test",
        ];

        $response = $this->put("/api/categories/$category->id", $categoryData);
        $response->assertStatus(200);
    }

    /**
     * Test Show Category
     */
    public function testShowCategory()
    {
        $user = $this->generateAccessToken();
        $category = Category::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->get("/api/categories/$category->id");
        $response->assertStatus(200);
    }


    /**
     * Test Delete Category
     */
    public function testDeleteCategory()
    {
        $user = $this->generateAccessToken();
        $category = Category::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->delete("/api/categories/$category->id");
        $response->assertStatus(200);
    }
}
