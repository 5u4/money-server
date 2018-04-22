<?php

namespace App\Models\Neo;

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 * @OGM\Node(label="Service")
 * Class Service
 * @package App\Models\Neo4J
 */
class Service
{
    /**
     * @OGM\GraphId()
     * @var int
     */
    protected $id;

    /**
     * @OGM\Property(type="string")
     * @var string
     */
    protected $name;

    /**
     * @var User[]
     *
     * (:User)-[:HAS_SERVICE]->(:Service)
     *
     * @OGM\Relationship(
     *     type="HAS_SERVICE", direction="INCOMING", collection=false,
     *     mappedBy="services", targetEntity="User")
     */
    protected $user;

    /**
     * @var Store[]|Collection
     *
     * (:Store)-[:PROVIDES]->(:Service)
     *
     * @OGM\Relationship(
     *     type="PROVIDES", direction="INCOMING", collection=true,
     *     mappedBy="services", targetEntity="Store")
     */
    protected $stores;

    /**
     * @var Transaction[]|Collection
     *
     * (:Transaction)-[:ON_SERVICE]->(:Service)
     *
     * @OGM\Relationship(
     *     type="ON_SERVICE", direction="INCOMING", collection=true,
     *     mappedBy="service", targetEntity="Transaction")
     */
    protected $transactions;

    /**
     * Service constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->user = new Collection();
        $this->stores = new Collection();
        $this->transactions = new Collection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return User[]
     */
    public function getUser(): array
    {
        return $this->user;
    }

    /**
     * @return Store[]|Collection
     */
    public function getStores()
    {
        return $this->stores;
    }

    /**
     * @return Transaction[]|Collection
     */
    public function getTransactions()
    {
        return $this->transactions;
    }
}
