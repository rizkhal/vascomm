<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LocationTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WorkerRequest;
use App\Inertable\Admin\WorkerDatatable;
use App\Models\Worker;
use Illuminate\Support\Facades\DB;

class WorkerController extends Controller
{
    public function index()
    {
        return inertia('admin/worker/index')
            ->inertable(new WorkerDatatable)
            ->with([
                'types' => LocationTypes::labels(),
            ])
            ->title(__('Daftar penyuluh'));
    }

    public function store(WorkerRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $worker = Worker::create($request->getData());
            $worker->assignRole($request->getRole());

            return back()->success(__('Berhasil menambah penyuluh'));
        });
    }

    public function update(WorkerRequest $request, Worker $worker)
    {
        return DB::transaction(function () use ($worker, $request) {
            $worker->update($request->validated());

            return back()->success(__('Berhasil mengubah penyuluh'));
        });
    }

    public function destroy(Worker $worker)
    {
        return DB::transaction(function () use ($worker) {
            $worker->delete();

            return back()->success(__('Berhasil menghapus penyuluh'));
        });
    }
}
