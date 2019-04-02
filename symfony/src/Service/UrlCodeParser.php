<?php

namespace App\Service;

use App\DTO\UrlCodeDTO;

class UrlCodeParser
{

    /**
     * @param string $urlCode
     *
     * @return UrlCodeDTO
     */
    public function parse(string $urlCode): UrlCodeDTO
    {
        $instance = mb_substr($urlCode, 0, 1);
        $namespace = mb_substr($urlCode, 1, 1);
        $urlHash = mb_substr($urlCode, 2);

        return new UrlCodeDTO($instance, $namespace, $urlHash);
    }
}
