<?php
namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class PaymentFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'PaymentService';
    }
}