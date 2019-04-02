<?php

declare(strict_types=1);

namespace App\DTO;

class UrlCodeDTO
{

    /**
     * @var string
     */
    private $instance;

    /**
     * @var string
     */

    private $namespace;
    /**
     * @var string
     */
    private $hash;

    public function __construct(
        string $instance,
        string $namespace,
        string $hash
    ) {
        $this->instance = $instance;
        $this->namespace = $namespace;
        $this->hash = $hash;
    }

    /**
     * @return string
     */
    public function getInstance(): string
    {
        return $this->instance;
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    public function __toString():string
    {
        return $this->instance . $this->namespace . $this->hash;
    }
}
