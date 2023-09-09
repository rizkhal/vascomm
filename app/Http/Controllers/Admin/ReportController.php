<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presence;

class ReportController extends Controller
{
    public function reportQuery()
    {
        // return Presence::query()->
    }

    public function index()
    {
        // $r = $this->reportQuery();
        // dd($r);

        return inertia('admin/report/index')->title(__('Laporan Kehadiran'));
    }
}
