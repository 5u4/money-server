<?php

namespace App\Http\Services;

use App\Models\RDB\User;
use App\Models\Neo\User as NeoUser;
use GraphAware\Neo4j\OGM\EntityManager;

class UserService
{
    /** @var EntityManager $entityManager */
    private $entityManager;
    /** @var AuthService $authService */
    private $authService;

    /**
     * UserService constructor.
     * @param EntityManager $entityManager
     * @param AuthService $authService
     */
    public function __construct(EntityManager $entityManager, AuthService $authService)
    {
        $this->entityManager = $entityManager;
        $this->authService = $authService;
    }

    /**
     * Get user in Neo4J, create one if not found
     *
     * @param string $name
     * @return null|object
     * @throws \Exception
     */
    public function getNeoUser(int $id)
    {
        $userRepo = $this->entityManager->getRepository(NeoUser::class);

        $user = $userRepo->findOneById($id);

        return $user;
    }

    /**
     * @param string $name
     * @return NeoUser
     * @throws \Exception
     */
    public function createNeoUser(string $name): NeoUser
    {
        $user = new NeoUser($name);

        $this->entityManager->persist($user);

        $this->entityManager->flush();

        return $user;
    }

    /**
     * Create a user in relational database
     *
     * @param int $graphId
     * @param string $name
     * @param string $email
     * @param string $password
     * @return User
     */
    public function createUserInRDB(int $graphId, string $name, string $email, string $password): User
    {
        return User::create([
            'graph_id' => $graphId,
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'api_token' => str_random(User::ACCESS_TOKEN_LENGTH),
            'ip' => request()->ip()
        ]);
    }

    /**
     * Soft delete current user
     *
     * @return bool
     */
    public function softDeleteCurrentUser(): bool
    {
        $user = $this->authService->getCurrentUser();

        if ($user && !$user->trashed()) {
            $user->delete();
            return true;
        }

        return false;
    }
}
