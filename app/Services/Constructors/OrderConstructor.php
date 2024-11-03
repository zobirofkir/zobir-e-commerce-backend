<?php
namespace App\Services\Constructors;

use App\Http\Requests\OrderRequest;

interface OrderConstructor
{
    public function createOrder(OrderRequest $request);
}