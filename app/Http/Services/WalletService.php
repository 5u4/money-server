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
     * @return int
     * @throws \Exception
     */
    public function createWallet(string $name): int
    {
        $wallet = new Wallet($name);

        $this->entityManager->persist($wallet);

        $this->entityManager->flush();

        return $wallet->getId();
    }

    /**
     * @param int $walletId
     * @throws \Exception
     */
    public function ownWallet(int $walletId)
    {
        if (!$user = $this->authService->getCurrentUser()) {
            return;
        }

        $query = $this->entityManager->createQuery(
            'MATCH (u:User) where ID(u)={user_id}
            MATCH (w:Wallet) where ID(w)={wallet_id}
            CREATE (u)-[r:has_wallet]->(w)'
        );

        $query->addEntityMapping('u', User::class);
        $query->addEntityMapping('w', Wallet::class);

        $query->setParameter('user_id', $user->graph_id);
        $query->setParameter('wallet_id', $walletId);

        $query->execute();
    }
}
