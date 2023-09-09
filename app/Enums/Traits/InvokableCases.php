<?php

namespace App\Enums\Traits;

trait InvokableCases
{
    public function __invoke()
    {
        $this->value;
    }

    public static function __callStatic(mixed $name, mixed $arguments): mixed
    {
        return collect(self::cases())->firstWhere('name', $name)->value;
    }
}
