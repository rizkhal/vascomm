<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class LevelException extends HttpException
{
    public static function notLoggedIn(): self
    {
        return new static(403, 'User is not logged in.', null, []);
    }

    public static function forLevels(array $roles): self
    {
        return new static(403, 'User does not have the right levels.', null, []);
    }
}
