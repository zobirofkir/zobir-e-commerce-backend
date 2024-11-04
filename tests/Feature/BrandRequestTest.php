<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class BrandRequestTest extends TestCase
{
    use RefreshDatabase;

    public function generateAccessToken()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        return $user;
    }
 
    /**
     * Test Get All Brands.
     */
    public function testGetAllBrands()
    {
        $this->generateAccessToken();
        $response = $this->get('/api/brands');
        $response->assertStatus(200);
    }

    /**
     * Test show Brand.
     */
    public function testShowBrand()
    {
        $user = $this->generateAccessToken();
        $brand = Brand::factory()->create([
            "user_id" => $user->id
        ]);
        $response = $this->get('/api/brands/'.$brand->id);
        $response->assertStatus(200);
    }

    /**
     * Test Create Brand.
     */
    public function testCreateBrand()
    {
        $user = $this->generateAccessToken();

        $brand = Brand::factory()->create([
            "user_id" => $user->id
        ]);

        $response = $this->post('/api/brands', $brand->toArray());

        $response->assertStatus(201);
    }

    /**
     * Test Update Brand.
     */
    public function testUpdateBrand()
    {
        $user = $this->generateAccessToken();

        $brand = Brand::factory()->create([
            "user_id" => $user->id
        ]);

        $response = $this->put('/api/brands/'.$brand->id, [
            "user_id" => $user->id,
            "title" => "Brand 1",
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test Delete Brand.
     */
    public function testDeleteBrand()
    {
        $user = $this->generateAccessToken();

        $brand = Brand::factory()->create([
            "user_id" => $user->id
        ]);

        $response = $this->delete("/api/brands/$brand->id");

        $response->assertStatus(200);
    }
}
