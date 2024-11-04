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
}
