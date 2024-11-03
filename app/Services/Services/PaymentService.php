<?php

namespace App\Services\Services;

use App\Models\Order;
use App\Services\Constructors\PaymentConstructor;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentService implements PaymentConstructor
{
    public function createPayment(Order $order, string $paymentMethodId) 
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => (int)($order->total_amount * 100), 
                'currency' => 'usd',
                'payment_method' => $paymentMethodId,
                'confirm' => true,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never', // Set to 'never' to avoid redirects
                ],
            ]);

            $order->update(['payment_intent_id' => $paymentIntent->id]);

            return $paymentIntent;
        } catch (ApiErrorException $e) {
            throw new \Exception("Payment error: " . $e->getMessage());
        }
    }
}
