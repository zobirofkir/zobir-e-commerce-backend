<?php
namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class BrandFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'BrandService';
    }
}