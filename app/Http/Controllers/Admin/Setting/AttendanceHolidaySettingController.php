<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\HolidayRequest;
use App\Inertable\Admin\HolidayDatatable;
use App\Models\Admin\Holiday;
use Illuminate\Support\Facades\DB;

class AttendanceHolidaySettingController extends Controller
{
    public function index()
    {
        return inertia('admin/setting/holiday/index')
            ->inertable(new HolidayDatatable)->title(__('Kelola Hari Libur'));
    }

    public function store(HolidayRequest $request)
    {
        return DB::transaction(function () use ($request) {
            Holiday::create($request->validated());

            return back()->success(__('Berhasil menambah hari libur'));
        });
    }

    public function update(HolidayRequest $request, Holiday $holiday)
    {
        return DB::transaction(function () use ($request, $holiday) {
            $holiday->update($request->validated());

            return back()->success(__('Berhasil mengubah hari libur'));
        });
    }

    public function destroy(Holiday $holiday)
    {
        return DB::transaction(function () use ($holiday) {
            $holiday->delete();

            return back()->success(__('Berhasil menghapus penyuluh'));
        });
    }
}
