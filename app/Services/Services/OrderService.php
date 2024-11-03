<?php

namespace App\Services\Services;

use App\Enums\OrderStatus;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use App\Services\Constructors\OrderConstructor;
use Illuminate\Support\Facades\Auth;

class OrderService implements OrderConstructor
{
    public function getOrders()
    {
        return OrderResource::collection(
            Order::all()
        );
    }

    public function showOrder(Order $order)
    {
        return OrderResource::make( $order );
    }

    public function createOrder(OrderRequest $request)
    {
        $validated = $request->validated();

        $order = Order::create([
            'user_id' => Auth::user()->id,
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'total_amount' => 0, 
            'status' => OrderStatus::PENDING->value,
        ]);

        $totalAmount = 0;

        foreach ($validated['cart_items'] as $item) {
            $product = Product::findOrFail($item['product_id']); 

            $orderItem = $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price, 
            ]);

            $totalAmount += $orderItem->price * $orderItem->quantity;
        }

        $order->update(['total_amount' => $totalAmount]); 

        return OrderResource::make( $order );
    }

    public function deleteOrder(Order $order)
    {
        return $order->delete();
    }
}