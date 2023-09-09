<?php

declare(strict_types=1);

namespace App\Inertable;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Rizkhal\Inertable\Inertable;
use Rizkhal\Inertable\View\Column;

class ProductTable extends Inertable
{
    public function query(): Builder
    {
        return Product::query()->with('author')->when(auth()->user()->hasRole('user'), fn (Builder $query) => $query->active());
    }

    public function columns(): array
    {
        return [
            Column::make('Foto', 'picture'),
            Column::make('Nama Produk', 'name')->sortable()->searchable(),
            Column::make('Harga', 'price')->sortable()->searchable(),
            Column::make('status', 'status')->sortable()->format(fn (Product $row) => [
                'value' => $row->status->value,
                'label' => $row->status->label(),
            ]),
            Column::make('Author', 'author.name')->sortable()->searchable()->nullable(),
            Column::action(),
        ];
    }
}
