<?php
namespace App\Services\Services;

use App\Http\Requests\AuthenticationLoginRequest;
use App\Http\Requests\AuthenticationRequest;
use App\Http\Resources\AuthenticationResource;
use App\Models\User;
use App\Services\Constructors\AuthenticationConstructor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationService implements AuthenticationConstructor
{
    public function register(AuthenticationRequest $request): AuthenticationResource
    {
        return AuthenticationResource::make(
            User::create($request->validated())
        );
    }

    public function login(AuthenticationLoginRequest $request): AuthenticationResource
    {
        $validatedInfo = $request->validated();

        $user = User::where('email', $validatedInfo['email'])->first();

        if (!$user || !Hash::check($validatedInfo['password'], $user->password)) {
            abort(401);
        }

        return AuthenticationResource::make( $user );
    }

    public function logout(): bool
    {
        $currentUser = $this->currentAuthenticatedUser();

        if ($currentUser) {
            Auth::logout();
            return true;
        }

        return false;
    }

    public function currentAuthenticatedUser() : ?User
    {
        return User::find(Auth::user()->id);
    }
}
