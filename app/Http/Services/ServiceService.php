<?php

namespace App\Http\Services;

use App\Models\Neo\Service;
use App\Models\Neo\User;
use GraphAware\Neo4j\OGM\EntityManager;

class ServiceService
{
    /** @var EntityManager $entityManager */
    private $entityManager;
    /** @var AuthService $authService */
    private $authService;

    /**
     * ServiceService constructor.
     * @param EntityManager $entityManager
     * @param AuthService $authService
     */
    public function __construct(EntityManager $entityManager, AuthService $authService)
    {
        $this->entityManager = $entityManager;
        $this->authService = $authService;
    }

    /**
     * @param int $serviceId
     * @return Service
     */
    public function getService(int $serviceId): Service
    {
        $serviceRepo = $this->entityManager->getRepository(Service::class);

        return $serviceRepo->findOneById($serviceId);
    }

    /**
     * @return array|null
     */
    public function getUserServices()
    {
        /* Get User */
        if (!$user = $this->authService->getCurrentUser()) {
            return null;
        }

        /* Get User */
        $userRepo = $this->entityManager->getRepository(User::class);

        $user = $userRepo->findOneById($user->graph_id);

        /* Create Service Objects */
        $services = [];

        foreach ($user->getServices() as $service) {
            $services[] = [
                'id' => $service->getId(),
                'name' => $service->getName(),
            ];
        }

        return $services;
    }

    /**
     * @param string $name
     * @return int|null
     * @throws \Exception
     */
    public function createService(string $name)
    {
        /* Get User */
        if (!$user = $this->authService->getCurrentUser()) {
            return null;
        }

        /* Create Service */
        $service = new Service($name);

        $this->entityManager->persist($service);

        $this->entityManager->flush();

        /* Add Service To User */
        $user->addService($service->getId());

        $userRepo = $this->entityManager->getRepository(User::class);

        $user = $userRepo->findOneById($user->graph_id);

        $user->getServices()->add($service);

        $this->entityManager->flush();

        return $service->getId();
    }
}
