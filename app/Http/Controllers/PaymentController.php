<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Order;
use App\Services\Facades\PaymentFacade;

class PaymentController extends Controller
{
    public function processPayment(Order $order, PaymentRequest $request)
    {
        return PaymentFacade::processPayment($order, $request);
    }
}
