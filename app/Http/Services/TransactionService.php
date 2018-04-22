<?php

namespace App\Http\Services;

use App\Models\Neo\Transaction;
use App\Models\Neo\User;
use GraphAware\Neo4j\OGM\EntityManager;

class TransactionService
{
    /** @var EntityManager $entityManager */
    private $entityManager;
    /** @var AuthService $authService */
    private $authService;

    /**
     * TransactionService constructor.
     * @param EntityManager $entityManager
     * @param AuthService $authService
     */
    public function __construct(EntityManager $entityManager, AuthService $authService)
    {
        $this->entityManager = $entityManager;
        $this->authService = $authService;
    }

    /**
     * @return array|null
     */
    public function getUserTransactions()
    {
        /* Get User */
        if (!$user = $this->authService->getCurrentUser()) {
            return null;
        }

        /* Get User */
        $userRepo = $this->entityManager->getRepository(User::class);

        $user = $userRepo->findOneById($user->graph_id);

        /* Create Transaction Objects */
        $transactions = [];

        foreach ($user->getTransactions() as $transaction) {
            $transactions[] = [
                'id' => $transaction->getId(),
                'timestamp' => $transaction->getTimestamp(),
                'amount' => $transaction->getAmount(),
                'wallet_id' => $transaction->getWallet()->getId(),
                'store_id' => $transaction->getStore() ? $transaction->getStore()->getId() : null,
                'service_id' => $transaction->getService() ? $transaction->getService()->getId() : null
            ];
        }

        return $transactions;
    }

    /**
     * @param float $amount
     * @param int $walletId
     * @return int|null
     * @throws \Exception
     */
    public function createTransaction(float $amount, int $walletId)
    {
        /* Get User */
        if (!$user = $this->authService->getCurrentUser()) {
            return null;
        }

        /* Create Transaction */
        $transaction = new Transaction($amount);

        $this->entityManager->persist($transaction);

        /* Add Transaction To User */
        $userRepo = $this->entityManager->getRepository(User::class);

        $user = $userRepo->findOneById($user->graph_id);

        $user->getTransactions()->add($transaction);

        /* Check User Has Wallet */
        $isUserWallet = false;
        $neoWallet = null;
        foreach ($user->getWallets() as $wallet) {
            if ($wallet->getId() == $walletId) {
                $isUserWallet = true;
                $neoWallet = $wallet;
                break;
            }
        }

        if (!$isUserWallet) {
            return null;
        }

        /* Add Transaction to Wallet */
        $transaction->getWallet()->add($neoWallet);

        $this->entityManager->flush();

        return $transaction->getId();
    }

    public function transactionInStore(int $transactionId, int $storeId)
    {
        /* Get User */
        if (!$user = $this->authService->getCurrentUser()) {
            return;
        }

        $userRepo = $this->entityManager->getRepository(User::class);

        $user = $userRepo->findOneById($user->graph_id);

        /* Check User Has Store */
        $isUserStore = false;
        $neoStore = null;
        foreach ($user->getStores() as $store) {
            if ($store->getId() == $storeId) {
                $isUserStore = true;
                $neoStore = $store;
                break;
            }
        }

        if (!$isUserStore) {
            return;
        }

        /* Add Transaction to Store */
        $transactionRepo = $this->entityManager->getRepository(Transaction::class);

        $transaction = $transactionRepo->findOneById($transactionId);

        $transaction->getStore()->add($neoStore);

        $this->entityManager->flush();
    }

    public function transactionOnService(int $transactionId, int $serviceId)
    {
        /* Get User */
        if (!$user = $this->authService->getCurrentUser()) {
            return;
        }

        $userRepo = $this->entityManager->getRepository(User::class);

        $user = $userRepo->findOneById($user->graph_id);

        /* Check User Has Service */
        $isUserService = false;
        $neoService = null;
        foreach ($user->getServices() as $service) {
            if ($service->getId() == $serviceId) {
                $isUserService = true;
                $neoService = $service;
                break;
            }
        }

        if (!$isUserService) {
            return;
        }

        /* Add Transaction to Service */
        $transactionRepo = $this->entityManager->getRepository(Transaction::class);

        $transaction = $transactionRepo->findOneById($transactionId);

        $transaction->getService()->add($neoService);

        $this->entityManager->flush();
    }
}
