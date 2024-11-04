<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class OrderRequestTest extends TestCase
{
    use RefreshDatabase; 

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
            "category_id" => $category->id,
            "user_id" => $user->id,
            "price" => 50.00
        ]);

        $requestData = [
            'phone' => '123-456-7890',
            'address' => '123 Main St, City, Country',
            'cart_items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                ]
            ],
        ];

        $response = $this->postJson('/api/orders', $requestData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'phone' => '123-456-7890',
            'address' => '123 Main St, City, Country',
            'total_amount' => $product->price * 2,
            'status' => 'pending',
        ]);
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
            "user_id" => $user->id
        ]);
        $response = $this->get("/api/orders/$order->id");
        $response->assertStatus(200);
    }

    /**
     * Test Delete Order
     */
    public function testDeleteOrder()
    {
        $user = $this->generateAccessToken();
        $order = Order::factory()->create([
            "user_id" => $user->id
        ]);
        $response = $this->delete("/api/orders/$order->id");
        $response->assertStatus(200);
    }
}
