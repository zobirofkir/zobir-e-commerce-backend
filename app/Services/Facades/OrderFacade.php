<?php
namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class OrderFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'OrderService';
    }
}