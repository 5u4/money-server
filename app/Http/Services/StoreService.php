<?php

namespace App\Http\Services;

use App\Models\Neo\Store;
use App\Models\Neo\User;
use GraphAware\Neo4j\OGM\EntityManager;

class StoreService
{
    /** @var EntityManager $entityManager */
    private $entityManager;
    /** @var AuthService $authService */
    private $authService;

    /**
     * WalletService constructor.
     * @param EntityManager $entityManager
     * @param AuthService $authService
     */
    public function __construct(EntityManager $entityManager, AuthService $authService)
    {
        $this->entityManager = $entityManager;
        $this->authService = $authService;
    }

    /**
     * @param string $name
     * @return int|null
     * @throws \Exception
     */
    public function createStore(string $name)
    {
        /* Get User */
        if (!$user = $this->authService->getCurrentUser()) {
            return null;
        }

        /* Create Store */
        $store = new Store($name);

        $this->entityManager->persist($store);

        /* Add Store To User */
        $userRepo = $this->entityManager->getRepository(User::class);

        $user = $userRepo->findOneById($user->graph_id);

        $user->getStores()->add($store);

        $this->entityManager->flush();

        return $store->getId();
    }
}
