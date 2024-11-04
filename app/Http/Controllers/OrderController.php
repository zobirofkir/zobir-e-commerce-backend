<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Requests\PaymentRequest;
use App\Models\Order;
use App\Services\Facades\OrderFacade;

class OrderController extends Controller
{
    public function index()
    {
        return OrderFacade::getOrders();
    }
    public function show(Order $order)
    {
        return OrderFacade::showOrder($order);
    }
    
    public function store(OrderRequest $request)
    {   
        return OrderFacade::createOrder($request);
    }

    public function destroy(Order $order)
    {
        return OrderFacade::deleteOrder($order);
    }
}
