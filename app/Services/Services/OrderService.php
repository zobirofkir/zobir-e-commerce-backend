<?php

namespace App\Services\Services;

use App\Enums\OrderStatus;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use App\Services\Constructors\OrderConstructor;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class OrderService implements OrderConstructor
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function getOrders()
    {
        return OrderResource::collection(
            Order::all()
        );
    }

    public function showOrder(Order $order)
    {
        return OrderResource::make($order);
    }


    public function createOrder(OrderRequest $request)
    {
        $validated = $request->validated();

        // Create the order
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

        // Pass the $order instance here
        $paymentResponse = $this->createPaymentIntent($totalAmount, $order, $validated);

        if (isset($paymentResponse['error'])) {
            return response()->json(['error' => 'Payment failed: ' . $paymentResponse['error']], 500);
        }

        $order->update([
            'stripe_payment_intent_id' => $paymentResponse['payment_intent_id'],
            'status' => OrderStatus::COMPLETED->value,
        ]);

        return response()->json([
            'order' => OrderResource::make($order),
            'payment_intent' => $paymentResponse['client_secret'],
        ]);
    }

    private function createPaymentIntent($totalAmount, Order $order, $validated)
    {
        $paymentIntent = PaymentIntent::create([
            'amount' => $totalAmount * 100,
            'currency' => 'usd', 
            'payment_method_data' => [
                'type' => 'card',
                'card' => [
                    'number' => $validated['card_number'],
                    'exp_month' => $validated['exp_month'],
                    'exp_year' => $validated['exp_year'],
                    'cvc' => $validated['cvc'],
                ],
            ],
            'confirm' => true, 
            'metadata' => [
                'order_id' => $order->id,
                'user_id' => Auth::user()->id,
            ],
            'automatic_payment_methods' => [
                'enabled' => true,
                'allow_redirects' => 'never', 
            ],
        ]);

        return [
            'payment_intent_id' => $paymentIntent->id,
            'client_secret' => $paymentIntent->client_secret,
        ];
    }

    public function deleteOrder(Order $order)
    {
        return $order->delete();
    }
}
