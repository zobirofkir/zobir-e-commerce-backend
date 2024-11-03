<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Facades\PaymentFacade;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentRequest;

class PaymentController extends Controller
{
    public function createPayment(Order $order, PaymentRequest $request)
    {
        $validatedData = $request->validated();
        
        $paymentMethodId = $validatedData['payment_method']['id'];

        return PaymentFacade::createPayment($order, $paymentMethodId);
    }
}