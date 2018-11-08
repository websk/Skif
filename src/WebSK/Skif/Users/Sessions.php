<?php

namespace WebSK\Skif\Users;

use WebSK\Entity\BaseEntity;

/**
 * Class Sessions
 * @package WebSK\WebSK\Skif\Users
 */
class Sessions extends BaseEntity
{
    const ENTITY_SERVICE_CONTAINER_ID = 'users.sessions_service';
    const ENTITY_REPOSITORY_CONTAINER_ID = 'users.sessions_repository';
    const DB_TABLE_NAME = 'sessions';

    const SESSION_LIFE_TIME = 31536000; // 1 год

    /** @var int */
    protected $user_id;

    /** @var string */
    protected $session;

    /** @var string */
    protected $hostname;

    /** @var int */
    protected $timestamp;

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getSession(): string
    {
        return $this->session;
    }

    /**
     * @param string $session
     */
    public function setSession(string $session): void
    {
        $this->session = $session;
    }

    /**
     * @return string
     */
    public function getHostname(): string
    {
        return $this->hostname;
    }

    /**
     * @param string $hostname
     */
    public function setHostname(string $hostname): void
    {
        $this->hostname = $hostname;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @param int $timestamp
     */
    public function setTimestamp(int $timestamp): void
    {
        $this->timestamp = $timestamp;
    }
}
