<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\Admin\WorkerImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class WorkerImportController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx'],
        ]);

        try {
            File::ensureDirectoryExists('imports/worker');
            $filename = $request->file->store('imports/worker');

            $file = storage_path("app/public/$filename");

            (new WorkerImport())->import($file, 'public', \Maatwebsite\Excel\Excel::XLSX);

            return back()->success(__('Berhail mengimport penyuluh'));
        } catch (\Throwable $th) {
            return back()->error(__('Terjadi kesalahan'));
        }
    }
}
