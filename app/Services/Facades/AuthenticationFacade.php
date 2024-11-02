<?php
namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class AuthenticationFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'AuthenticationService';
    }
}