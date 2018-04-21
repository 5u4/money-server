<?php

namespace App\Http\Services;

use App\Models\RDB\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(string $name, string $password)
    {
        if (Auth::attempt(['name' => $name, 'password' => $password])) {
            return $this->refreshToken();
        } else {
            return null;
        }
    }

    /**
     * Refresh current user's access token
     *
     * @return string
     */
    public function refreshToken(): string
    {
        $access_token = str_random(User::ACCESS_TOKEN_LENGTH);
        $user = Auth::user();
        $user->api_token = $access_token;
        $user->ip = request()->ip();
        $user->save();

        return $access_token;
    }

    /**
     * Get current user
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getCurrentUser()
    {
        $user = Auth::user();

        if ($user->ip == request()->ip()) {
            return $user;
        } else {
            return null;
        }
    }
}
