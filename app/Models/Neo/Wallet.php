<?php

namespace App\Models\Neo;

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 * @OGM\Node(label="Wallet")
 * Class Wallet
 * @package App\Models\Neo4J
 */
class Wallet
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
     * @OGM\Property(type="float")
     * @var float
     */
    protected $balance;

    /**
     * @OGM\Property(type="int")
     * @var int
     */
    protected $owner_graph_id;

    /**
     * @var User[]|Collection
     *
     * (:User)-[:HAS_WALLET]->(:Wallet)
     *
     * @OGM\Relationship(
     *     type="HAS_WALLET", direction="INCOMING", collection=true,
     *     mappedBy="wallets", targetEntity="User")
     */
    protected $users;

    /**
     * @var Transaction[]|Collection
     *
     * (:Wallet)-[:HAS_TX]->(:Transaction)
     *
     * @OGM\Relationship(
     *     type="HAS_TX", direction="OUTGOING", collection=true,
     *     mappedBy="wallet", targetEntity="Transaction")
     */
    protected $transactions;

    /**
     * Wallet constructor.
     * @param string $name
     * @param int $ownerGraphId
     * @param float $balance
     */
    public function __construct(string $name, int $ownerGraphId, float $balance = 0)
    {
        $this->name = $name;
        $this->balance = $balance;
        $this->owner_graph_id = $ownerGraphId;
        $this->users = new Collection();
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
     * @return float
     */
    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * @return int
     */
    public function getOwnerGraphId(): int
    {
        return $this->owner_graph_id;
    }

    /**
     * @return User[]|Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @return Transaction[]|Collection
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * @param float $balance
     */
    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }
}
