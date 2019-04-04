<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\UrlCodeDTO;
use App\Repository\Redis\UrlRedisRepository;

class UrlGenerator
{

    private const CHARS = "1KwyfDzLHgxrtQ7vnjl83CkPchqTZB9saXS62mYJdWVbpAFN54MGR";

    private const CHARS_LAST_INDEX = 52;

    private const HASH_LENGTH = 4;

    /**
     * @var UrlRedisRepository
     */
    private $urlRepository;

    public function __construct(
        UrlRedisRepository $urlRepository
    ) {
        $this->urlRepository = $urlRepository;
    }

    /**
     * @return UrlCodeDTO
     */
    public function generateUrlCode(): UrlCodeDTO
    {
        $instance = $this->getRandChar();

        $namespace = $this->getRandChar();

        $lastHash = $this->urlRepository->getLastHashForNamespace($namespace);

        if (null === $lastHash) {
            $lastHash = $this->generateFirstHash();
        }
        $lastHash++;

        $this->urlRepository->setLastHashForNamespace($namespace, $lastHash);

        return new UrlCodeDTO($instance, $namespace, $lastHash);
    }

    /**
     * @return string
     */
    private function generateFirstHash(): string
    {
        $hash = '';
        for ($i = 0; $i <= self::HASH_LENGTH; $i++) {
            $hash .= $this->getRandChar();
        }

        return $hash;
    }

    /**
     * @return string
     */
    private function getRandChar(): string
    {
        return self::CHARS[rand(0, self::CHARS_LAST_INDEX)];
    }
}
