<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class CategoryFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'CategoryService';
    }
}