<?php

namespace App\Services\Constructors;

use App\Http\Requests\AuthenticationLoginRequest;
use App\Http\Requests\AuthenticationRequest;
use App\Http\Resources\AuthenticationResource;
use App\Models\User;

interface AuthenticationConstructor
{
    public function register(AuthenticationRequest $request) : AuthenticationResource;

    public function login(AuthenticationLoginRequest $request) : AuthenticationResource;

    public function logout() : bool;

    public function currentAuthenticatedUser() : ?User;
}