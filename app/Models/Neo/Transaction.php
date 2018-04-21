<?php

namespace App\Models\Neo;

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 * @OGM\Node(label="Transaction")
 * Class Transaction
 * @package App\Models\Neo4J
 */
class Transaction
{
    /**
     * @OGM\GraphId()
     * @var int
     */
    protected $id;

    /**
     * @OGM\Property(type="int")
     * @var int
     */
    protected $timestamp;

    /**
     * @OGM\Property(type="float")
     * @var float
     */
    protected $amount;

    /**
     * @var User[]
     *
     * (:User)-[:has_tx]->(:Transaction)
     *
     * @OGM\Relationship(
     *     type="has_tx", direction="INCOMING", collection=false,
     *     mappedBy="transactions", targetEntity="User")
     */
    protected $user;

    /**
     * @var Wallet[]
     *
     * (:Wallet)-[:has_tx]->(:Transaction)
     *
     * @OGM\Relationship(
     *     type="has_tx", direction="INCOMING", collection=false,
     *     mappedBy="transactions", targetEntity="Wallet")
     */
    protected $wallet;

    /**
     * @var Store[]
     *
     * (:Transaction)-[:in_store]->(:Store)
     *
     * @OGM\Relationship(
     *     type="in_store", direction="OUTGOING", collection=false,
     *     mappedBy="transactions", targetEntity="Store")
     */
    protected $store;

    /**
     * @var Service[]
     *
     * (:Wallet)-[:on_service]->(:Service)
     *
     * @OGM\Relationship(
     *     type="on_service", direction="OUTGOING", collection=false,
     *     mappedBy="transactions", targetEntity="Service")
     */
    protected $service;

    /**
     * Transaction constructor.
     * @param float $amount
     */
    public function __construct(float $amount)
    {
        $this->timestamp = time();
        $this->amount = $amount;
        $this->user = new Collection();
        $this->wallet = new Collection();
        $this->store = new Collection();
        $this->service = new Collection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return User[]
     */
    public function getUser(): array
    {
        return $this->user;
    }

    /**
     * @return Wallet[]
     */
    public function getWallet(): array
    {
        return $this->wallet;
    }

    /**
     * @return Store[]
     */
    public function getStore(): array
    {
        return $this->store;
    }

    /**
     * @return Service[]
     */
    public function getService(): array
    {
        return $this->service;
    }
}
