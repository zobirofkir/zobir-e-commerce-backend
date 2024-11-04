<?php
namespace App\Services\Constructors;

use App\Http\Requests\PaymentRequest;
use App\Models\Order;

interface  PaymentConstructor
{

    public function processPayment(Order $order, PaymentRequest $request);
    
}