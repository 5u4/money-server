<?php

namespace App\Http\Services;

use App\Models\Neo\Log;
use App\Models\Neo\User;
use GraphAware\Neo4j\OGM\EntityManager;

class LogService
{
    /** @var EntityManager $entityManager */
    private $entityManager;
    /** @var AuthService $authService */
    private $authService;

    /**
     * LogService constructor.
     * @param EntityManager $entityManager
     * @param AuthService $authService
     */
    public function __construct(EntityManager $entityManager, AuthService $authService)
    {
        $this->authService = $authService;
        $this->entityManager = $entityManager;
    }

    /**
     * @return array|null
     */
    public function getUserLogs()
    {
        /* Get User */
        if (!$user = $this->authService->getCurrentUser()) {
            return null;
        }

        /* Get User */
        $userRepo = $this->entityManager->getRepository(User::class);

        $user = $userRepo->findOneById($user->graph_id);

        /* Create Log Objects */
        $logs = [];

        foreach ($user->getLogs() as $log) {
            $logs[] = [
                'action' => $log->getAction(),
                'timestamp' => $log->getTimestamp(),
                'data' => json_decode($log->getData())
            ];
        }

        return $logs;
    }

    /**
     * @param string $action
     * @param string|null $data
     * @throws \Exception
     */
    public function log(string $action, string $data = null)
    {
        /* Get User */
        if (!$user = $this->authService->getCurrentUser()) {
            return;
        }

        /* Create Log */
        $log = new Log($action, $data);

        $this->entityManager->persist($log);

        /* Add Log to User */
        $userRepo = $this->entityManager->getRepository(User::class);

        $user = $userRepo->findOneById($user->graph_id);

        $user->getLogs()->add($log);

        $this->entityManager->flush();
    }
}
