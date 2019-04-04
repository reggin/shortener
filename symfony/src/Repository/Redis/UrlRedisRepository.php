<?php

namespace App\Repository\Redis;

use App\DTO\UrlCodeDTO;
use Predis\Client;

class UrlRedisRepository
{

    private const URL_HASH_TEMPLATE = 'url_hash_%s';

    private const LAST_ID_TEMPLATE = 'last_id_%s';

    /**
     * @var Client
     */
    private $client;

    public function __construct(
        Client $client
    ) {
        $this->client = $client;
    }

    /**
     * @param UrlCodeDTO $urlCodeDTO
     *
     * @return null|string
     */
    public function get(UrlCodeDTO $urlCodeDTO): ?string
    {
        return $this->client->hget($this->getHashName($urlCodeDTO->getNamespace()), $urlCodeDTO->getHash());
    }

    /**
     * @param string $namespace
     *
     * @return null|string
     */
    public function getLastHashForNamespace(string $namespace): ?string
    {
        return $this->client->get($this->getLastIdKey($namespace));
    }

    /**
     * @param string $namespace
     * @param string $lastHash
     */
    public function setLastHashForNamespace(string $namespace, string $lastHash): void
    {
        $this->client->set($this->getLastIdKey($namespace), $lastHash);
    }

    /**
     * @param UrlCodeDTO $urlCodeDTO
     *
     * @param string $url
     */
    public function set(UrlCodeDTO $urlCodeDTO, string $url): void
    {
        $this->client->hset($this->getHashName($urlCodeDTO->getNamespace()), $urlCodeDTO->getHash(), $url);
    }

    /**
     * @param string $namespace
     *
     * @return string
     */
    private function getHashName(string $namespace): string
    {
        return sprintf(self::URL_HASH_TEMPLATE, $namespace);
    }

    /**
     * @param string $namespace
     *
     * @return string
     */
    private function getLastIdKey(string $namespace): string
    {
        return sprintf(self::LAST_ID_TEMPLATE, $namespace);
    }
}
