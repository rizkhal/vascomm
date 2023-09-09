<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\CordinateRequest;
use App\Repositories\Setting\SettingRepository;

class CordinateController extends Controller
{
    public function __invoke(CordinateRequest $request)
    {
        $key = 'cordinate';
        $context = 'app';

        $settings = resolve(SettingRepository::class)->createSettingInstance($key, $context);

        $settings->fill([
            'name' => $key,
            'context' => $context,
            'value' => json_encode(collect($request->latLng)->first()),
        ]);

        $settings->save();

        return back()->success(__('Berhasil menambah loaksi absensi'));
    }
}
