<?php

declare(strict_types=1);

namespace App\Manager;

use App\DTO\UrlCodeDTO;
use App\Repository\Redis\UrlRedisRepository;
use App\Service\UrlCodeParser;
use App\Service\UrlGenerator;

class UrlManager
{
    /**
     * @var UrlCodeParser
     */
    private $urlCodeParser;

    /**
     * @var UrlRedisRepository
     */
    private $urlRedisRepository;
    /**
     * @var UrlGenerator
     */
    private $urlGenerator;

    public function __construct(
        UrlCodeParser $urlCodeParser,
        UrlRedisRepository $urlRedisRepository,
        UrlGenerator $urlGenerator
    ) {
        $this->urlCodeParser = $urlCodeParser;
        $this->urlRedisRepository = $urlRedisRepository;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param string $urlCode
     *
     * @return string
     *
     * @throws UrlNotFoundException
     */
    public function getUrl(string $urlCode): string
    {
        $urlCodeDTO = $this->urlCodeParser->parse($urlCode);
        $url = $this->urlRedisRepository->get($urlCodeDTO);

        if ($url === null) {
            throw new UrlNotFoundException();
        }

        return $url;
    }

    /**
     * @param string $url
     *
     * @return UrlCodeDTO
     */
    public function saveUrl(string $url): UrlCodeDTO
    {
        $urlCodeDTO = $this->urlGenerator->generateUrlCode();

        $this->urlRedisRepository->set($urlCodeDTO, $url);

        return $urlCodeDTO;
    }
}
