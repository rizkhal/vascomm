<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Inertable\Admin\AttendanceSettingDatatable;

class SettingController extends Controller
{
    public function attendance()
    {
        return inertia('admin/setting/attendance/index')
            ->inertable(new AttendanceSettingDatatable())
            ->title(__('Pengaturan'));
    }
}
