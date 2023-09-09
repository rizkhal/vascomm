<?php

namespace App\Enums;

use App\Enums\Traits\InvokableCases;
use Illuminate\Support\Collection;

enum UserStatus: string
{
    use InvokableCases;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Aktif',
            self::INACTIVE => 'Tidak Aktif',
        };
    }

    public static function labels(): Collection
    {
        return collect(self::cases())->map(function (self $value): array {
            return [
                'value' => $value->value,
                'label' => $value->label(),
            ];
        });
    }
}
