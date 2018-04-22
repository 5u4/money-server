<?php

namespace App\Models\Neo;

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 * @OGM\Node(label="User")
 * Class User
 * @package App\Models\Neo4J
 */
class User
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
     * @var Wallet[]|Collection
     *
     * (:User)-[:HAS_WALLET]->(:Wallet)
     *
     * @OGM\Relationship(
     *     type="HAS_WALLET", direction="OUTGOING", collection=true,
     *     mappedBy="users", targetEntity="Wallet")
     */
    protected $wallets;

    /**
     * @var Store[]|Collection
     *
     * (:User)-[:HAS_STORE]->(:Store)
     *
     * @OGM\Relationship(
     *     type="HAS_STORE", direction="OUTGOING", collection=true,
     *     mappedBy="user", targetEntity="Store")
     */
    protected $stores;

    /**
     * @var Service[]|Collection
     *
     * (:User)-[:HAS_SERVICE]->(:Service)
     *
     * @OGM\Relationship(
     *     type="HAS_SERVICE", direction="OUTGOING", collection=true,
     *     mappedBy="user", targetEntity="Service")
     */
    protected $services;

    /**
     * @var Transaction[]|Collection
     *
     * (:User)-[:HAS_TX]->(:Transaction)
     *
     * @OGM\Relationship(
     *     type="HAS_TX", direction="OUTGOING", collection=true,
     *     mappedBy="user", targetEntity="Transaction")
     */
    protected $transactions;

    /**
     * @var Log[]|Collection
     *
     * (:User)-[:IS_LOGGED]->(:Log)
     *
     * @OGM\Relationship(
     *     type="IS_LOGGED", direction="OUTGOING", collection=true,
     *     mappedBy="user", targetEntity="Log")
     */
    protected $logs;

    /**
     * User constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->wallets = new Collection();
        $this->stores = new Collection();
        $this->services = new Collection();
        $this->transactions = new Collection();
        $this->logs = new Collection();
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
     * @return Wallet[]|Collection
     */
    public function getWallets()
    {
        return $this->wallets;
    }

    /**
     * @return Store[]|Collection
     */
    public function getStores()
    {
        return $this->stores;
    }

    /**
     * @return Service[]|Collection
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @return Transaction[]|Collection
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * @return Log[]|Collection
     */
    public function getLogs()
    {
        return $this->logs;
    }
}
