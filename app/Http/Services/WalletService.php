<?php

namespace App\Http\Services;

use App\Models\Neo\User;
use App\Models\Neo\Wallet;
use GraphAware\Neo4j\OGM\EntityManager;

class WalletService
{
    /** @var EntityManager $entityManager */
    private $entityManager;
    /** @var AuthService */
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
     * @throws \Exception
     */
    public function createWallet(string $name)
    {
        /* Get User */
        if (!$user = $this->authService->getCurrentUser()) {
            return;
        }

        /* Create Wallet */
        $wallet = new Wallet($name);

        $this->entityManager->persist($wallet);

        /* Add Wallet To User */
        $userRepo = $this->entityManager->getRepository(User::class);

        $user = $userRepo->findOneById($user->graph_id);

        $user->getWallets()->add($wallet);

        $this->entityManager->flush();
    }
}
