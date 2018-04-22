<?php

namespace App\Models\Neo;

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 * @OGM\Node(label="Log")
 * Class Log
 * @package App\Models\Neo4J
 */
class Log
{
    /*
    |--------------------------------------------------------------------------
    | Action Constants
    |--------------------------------------------------------------------------
    */

    /* Auth */
    public const LOGIN = 'LOGIN';
    public const LOGOUT = 'LOGOUT';

    /* User */
    public const CREATE_USER = 'CREATE_USER';
    public const DELETE_USER = 'DELETE_USER';

    /* Wallet */
    public const CREATE_WALLET = 'CREATE_WALLET';

    /* Store */
    public const CREATE_STORE = 'CREATE_STORE';

    /* Service */
    public const CREATE_SERVICE = 'CREATE_SERVICE';

    /* Transaction */
    public const CREATE_TRANSACTION = 'CREATE_TRANSACTION';

    /**
     * @OGM\GraphId()
     * @var int
     */
    protected $id;

    /**
     * @OGM\Property(type="string")
     * @var string
     */
    protected $action;

    /**
     * @OGM\Property(type="int")
     * @var int
     */
    protected $timestamp;

    /**
     * @OGM\Property(type="string")
     * @var string
     */
    protected $data;

    /**
     * @var User[]
     *
     * (:User)-[:IS_LOGGED]->(:Log)
     *
     * @OGM\Relationship(
     *     type="IS_LOGGED", direction="INCOMING", collection=false,
     *     mappedBy="logs", targetEntity="User")
     */
    protected $user;

    /**
     * Log constructor.
     * @param string $action
     * @param string|null $data
     */
    public function __construct(string $action, string $data = null)
    {
        $this->action = $action;
        $this->timestamp = time();
        $this->data = $data;
        $this->user = new Collection();
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
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @return User[]
     */
    public function getUser(): array
    {
        return $this->user;
    }
}
