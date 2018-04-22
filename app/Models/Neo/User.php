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
     * (:User)-[:has_wallet]->(:Wallet)
     *
     * @OGM\Relationship(
     *     type="has_wallet", direction="OUTGOING", collection=true,
     *     mappedBy="users", targetEntity="Wallet")
     */
    protected $wallets;

    /**
     * @var Store[]|Collection
     *
     * (:User)-[:has_store]->(:Store)
     *
     * @OGM\Relationship(
     *     type="has_store", direction="OUTGOING", collection=true,
     *     mappedBy="user", targetEntity="Store")
     */
    protected $stores;

    /**
     * @var Service[]|Collection
     *
     * (:User)-[:has_service]->(:Service)
     *
     * @OGM\Relationship(
     *     type="has_service", direction="OUTGOING", collection=true,
     *     mappedBy="user", targetEntity="Service")
     */
    protected $services;

    /**
     * @var Transaction[]|Collection
     *
     * (:User)-[:has_tx]->(:Transaction)
     *
     * @OGM\Relationship(
     *     type="has_tx", direction="OUTGOING", collection=true,
     *     mappedBy="user", targetEntity="Transaction")
     */
    protected $transactions;

    /**
     * @var Log[]|Collection
     *
     * (:User)-[:is_logged]->(:Log)
     *
     * @OGM\Relationship(
     *     type="is_logged", direction="OUTGOING", collection=true,
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
