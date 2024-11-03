<?php
namespace App\Services\Constructors;

use App\Http\Requests\OrderRequest;
use App\Models\Order;

interface OrderConstructor
{
    public function createOrder(OrderRequest $request);

    public function deleteOrder(Order $order);
}