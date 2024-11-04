<?php
namespace App\Services\Services;

use App\Enums\OrderStatus;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\Constructors\PaymentConstructor;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentService implements PaymentConstructor
{

    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }
    public function processPayment(Order $order, PaymentRequest $request)
    {
        $validated = $request->validated();

        $paymentResponse = $this->createPaymentIntent($order->total_amount, $order, $validated);

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
            'payment_method' => $validated['payment_method_id'],
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
}