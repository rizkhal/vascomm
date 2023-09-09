<?php

declare(strict_types=1);

namespace App\Inertable;

use App\Models\WeeklyReport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Rizkhal\Inertable\Inertable;
use Rizkhal\Inertable\View\Column;

class ReportWeekTable extends Inertable
{
    public function __construct(
        private $year,
        private $worker,
        private $location,
        private $week
    ) {
        //
    }

    public function query(): Builder
    {
        return WeeklyReport::query()
            ->where('worker_id', $this->worker)
            ->where('location_id', $this->location)
            ->whereYear('created_at', $this->year)
            ->where(DB::raw('WEEK(created_at)'), $this->week);
    }

    public function columns(): array
    {
        return [
            Column::make('Komoditas', 'komoditas')->sortable()->searchable(),
            Column::make('Luas Tanah', 'luas_tanah')->sortable()->searchable(),
            Column::make('Luas Panen', 'luas_panen')->sortable()->searchable(),
            Column::make('Produksi', 'produksi')->sortable()->searchable(),
            Column::make('Produktifitas', 'produktifitas')->sortable()->searchable(),
        ];
    }
}
