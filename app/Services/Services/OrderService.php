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
        return OrderResource::collection(Order::all());
    }

    public function showOrder(Order $order)
    {
        return OrderResource::make($order);
    }

    public function createOrder(OrderRequest $request)
    {
        $validated = $request->validated();

        $order = Order::create([
            'user_id' => Auth::id(),
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'total_amount' => 0, 
            'status' => OrderStatus::PENDING->value,
            'payment_method' => $validated['payment_method']['type'],
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

        if ($validated['payment_method']['type'] === 'visa') { 
            $cardDetails = $validated['payment_method']['card']; 
            $this->processPayment($order, $cardDetails); 
        }

        return OrderResource::make($order);
    }

    public function deleteOrder(Order $order)
    {
        return $order->delete();
    }

    public function processPayment(Order $order, array $cardDetails)
    {
        $paymentService = new PaymentService();

        $paymentService->createPayment($order, $cardDetails);

    }
}
