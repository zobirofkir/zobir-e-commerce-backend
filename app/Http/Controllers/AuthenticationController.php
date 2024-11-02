<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticationLoginRequest;
use App\Http\Requests\AuthenticationRequest;
use App\Http\Resources\AuthenticationResource;
use App\Services\Facades\AuthenticationFacade;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function register(AuthenticationRequest $request) : AuthenticationResource
    {
        return AuthenticationFacade::register($request);
    }

    public function login(AuthenticationLoginRequest $request) : AuthenticationResource
    {
        return AuthenticationFacade::login($request);
    }

    public function logout() : bool
    {
        return AuthenticationFacade::logout();
    }
}
