<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Services\Facades\OrderFacade;

class OrderController extends Controller
{
    public function store(OrderRequest $request)
    {   
        return OrderFacade::createOrder($request);
    }
}
