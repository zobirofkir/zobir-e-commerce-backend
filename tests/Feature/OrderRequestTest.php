<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use App\Models\Product; // Import the Product model
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class OrderRequestTest extends TestCase
{
    use RefreshDatabase; // Ensure the database is refreshed for each test

    public function generateAccessToken()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        return $user;
    }

    /**
     * Test Create Order
     */
    public function testCreateOrder()
    {
        $user = $this->generateAccessToken();

        $category = Category::factory()->create([
            "user_id" => $user->id
        ]);

        $product = Product::factory()->create([
            "user_id" => $user->id,
            "category_id" => $category->id

        ]);

        $data = [
            'phone' => '123-456-7890',
            'address' => '123 Test St, Test City',
            'cart_items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                ],
            ],
        ];

        $response = $this->post('/api/orders', $data);

        $response->assertStatus(201); 
    }

    /**
     * Test Get Orders
     */
    public function testGetOrders()
    {
        $this->generateAccessToken();
        $response = $this->get('/api/orders');
        $response->assertStatus(200);
    }

    /**
     * Test Show Order
     */

    public function testShowOrder()
    {
        $user = $this->generateAccessToken();
        $order = Order::factory()->create([
            'user_id' => $user->id,
        ]);
        $response = $this->get('/api/orders/' . $order->id);
        $response->assertStatus(200);
    }

    /**
     * Test Delete Order
     */

    public function testDeleteOrder()
    {
        $user = $this->generateAccessToken();
        $order = Order::factory()->create([
            'user_id' => $user->id,
        ]);
        $response = $this->delete('/api/orders/' . $order->id);
        $response->assertStatus(200);
    }

}
