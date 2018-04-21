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
     * @var User[]
     *
     * (:User)-[:is_logged]->(:Log)
     *
     * @OGM\Relationship(
     *     type="is_logged", direction="INCOMING", collection=false,
     *     mappedBy="logs", targetEntity="User")
     */
    protected $user;

    /**
     * Log constructor.
     * @param string $action
     */
    public function __construct(string $action)
    {
        $this->action = $action;
        $this->timestamp = time();
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
     * @return User[]
     */
    public function getUser(): array
    {
        return $this->user;
    }
}
