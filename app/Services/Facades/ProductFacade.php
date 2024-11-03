<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class ProductFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'ProductService';
    }
}