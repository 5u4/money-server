<?php

namespace App\Http\Services;

use App\Models\RDB\User;
use App\Models\Neo\User as NeoUser;
use GraphAware\Neo4j\OGM\EntityManager;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /** @var EntityManager $entityManager */
    private $entityManager;

    /**
     * AuthService constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $email
     * @param string $password
     * @return null|string
     */
    public function login(string $email, string $password)
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
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

    /**
     * Get a user by the email
     *
     * @param string $email
     * @return int
     */
    public function getUserGraphIdByEmail(string $email): int
    {
        $userRepo = $this->entityManager->getRepository(NeoUser::class);

        $user = User::where('email', $email)->first();

        $user = $userRepo->findOneById($user->graph_id);

        return $user->getId();
    }
}
