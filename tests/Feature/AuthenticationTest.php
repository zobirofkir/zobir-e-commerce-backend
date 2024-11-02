<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{

    use RefreshDatabase;


    /**
     * Test Generate Access Token
     */
    public function generateAccessToken()
    {
        Passport::actingAs(
            User::factory()->create([
                "name" => "test",
                "email" => "test@example.com",
                "password" => "password",
            ])
        );
    }
}
