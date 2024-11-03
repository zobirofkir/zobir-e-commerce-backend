<?php
namespace App\Services\Constructors;

use App\Models\Order;

interface PaymentConstructor
{
    public function createPayment(Order $order, string $paymentMethodId);
}