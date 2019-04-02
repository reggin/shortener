<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Exception\ValidatorException;

class UrlCodeValidator
{
    private const URL_CODE_LENGTH = 6;

    /**
     * @param string $urlCode
     */
    public function validate(string $urlCode): void
    {
        if (self::URL_CODE_LENGTH !== $urlCode) {
            throw new ValidatorException();
        }
    }
}
