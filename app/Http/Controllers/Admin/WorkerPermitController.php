<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermitStatus;
use App\Http\Controllers\Controller;
use App\Inertable\Admin\WorkerPermitApprovalDatatable;
use App\Models\Permit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class WorkerPermitController extends Controller
{
    public function index()
    {
        return inertia('admin/permit/index')
            ->inertable(new WorkerPermitApprovalDatatable)
            ->with(['permit_status' => PermitStatus::labels()])
            ->title(__('Daftar permintaan izin'));
    }

    public function status(Request $request, Permit $permit)
    {
        $request->validate(['status' => ['required', new Enum(PermitStatus::class)]]);

        $permit->update(['status' => $request->status]);

        return back()->info('Permintaan izin berhasil diubah ke: '.PermitStatus::from($request->status)->label());
    }
}
