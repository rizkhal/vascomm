<?php

declare(strict_types=1);

namespace App\Inertable;

use App\Enums\UserStatus;
use App\Models\User;
use Rizkhal\Inertable\Inertable;
use Rizkhal\Inertable\View\Column;
use Illuminate\Database\Eloquent\Builder;

class UserTable extends Inertable
{
    public function query(): Builder
    {
        return User::query();
    }

    public function columns(): array
    {
        return [
            Column::make('Nama Produk', 'name')->sortable()->searchable(),
            Column::make('Harga', 'email')->sortable()->searchable(),
            Column::make('Nomor Telepon', 'phone_number')->sortable()->searchable()->nullable(),
            Column::make('status', 'status')->sortable()->format(fn (User $row) => [
                'value' => $row->status->value,
                'label' => $row->status->label(),
            ]),
            Column::action(),
        ];
    }
}
