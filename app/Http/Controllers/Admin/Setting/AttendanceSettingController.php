<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Enums\AttendanceSettingEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\AttendanceSettingRequest;
use App\Models\Admin\Setting\AttendanceSetting;
use App\Models\Worker;
use App\Repositories\Setting\AttendanceSettingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceSettingController extends Controller
{
    public function step1(Request $request)
    {
        $group = AttendanceSetting::when(
            $request->has('type') && $request->get('type') === 'show',
            fn ($query) => $query->where('id', $request->query('group')),
            fn ($query) => $query->where('status', AttendanceSettingEnum::PROGRESS())
        )->first();

        return inertia('admin/setting/attendance/step1', [
            'group' => $group,
        ])->title(__('Pengaturan Absensi'));
    }

    public function step2(Request $request)
    {
        $group = AttendanceSetting::when(
            $request->has('type') && $request->get('type') === 'show',
            fn ($query) => $query->where('id', $request->query('group')),
            fn ($query) => $query->where('status', AttendanceSettingEnum::PROGRESS())
        )->with(['attributes' => fn ($query) => $query->where('key', 'workers')])->first();

        $ids = resolve(AttendanceSettingRepository::class)->getSelectedWorkers();

        $workers = Worker::query()->when(is_array($ids) && count($ids), function ($query) use ($ids) {
            return $query->whereNotIn('id', $ids);
        })->paginate(1000);

        return inertia('admin/setting/attendance/step2')
            ->with([
                'group' => $group,
                'workers' => $workers,
            ])
            ->title(__('Pengaturan Absensi'));
    }

    public function step3(Request $request)
    {
        $group = AttendanceSetting::when(
            $request->has('type') && $request->get('type') === 'show',
            fn ($query) => $query->where('id', $request->query('group')),
            fn ($query) => $query->where('status', AttendanceSettingEnum::PROGRESS())
        )->with(['attributes' => fn ($query) => $query->where('key', 'cordinates')])->first();

        return inertia('admin/setting/attendance/step3')
            ->with([
                'group' => $group,
            ])
            ->title(__('Pengaturan Absensi'));
    }

    public function step4(Request $request)
    {
        $group = AttendanceSetting::when(
            $request->has('type') && $request->get('type') === 'show',
            fn ($query) => $query->where('id', $request->query('group')),
            fn ($query) => $query->where('status', AttendanceSettingEnum::PROGRESS())
        )->with(['attributes' => fn ($query) => $query->where('key', 'timestamps')])->first();

        return inertia('admin/setting/attendance/step4')
            ->with([
                'group' => $group,
            ])
            ->title(__('Pengaturan Absensi'));
    }

    public function review(Request $request)
    {
        $group = AttendanceSetting::when(
            $request->has('type') && $request->get('type') === 'show',
            fn ($query) => $query->where('id', $request->query('group')),
            fn ($query) => $query->where('status', AttendanceSettingEnum::PROGRESS())
        )->with(['attributes'])->first();

        $attr = $group->attributes()->get();
        $workerIds = json_decode($attr->where('key', 'workers')->first()?->value, true);

        $workers = Worker::query()->when(is_array($workerIds), function ($query) use ($workerIds) {
            return $query->whereIn('id', $workerIds);
        })->get();

        $timestamps = json_decode($attr->where('key', 'timestamps')->first()?->value, true);

        return inertia('admin/setting/attendance/review')
            ->with([
                'group' => $group,
                'workers' => $workers,
                'timestamps' => $timestamps,
            ])
            ->title(__('Pengaturan Absensi'));
    }

    public function store(AttendanceSettingRequest $request)
    {
        DB::beginTransaction();

        try {
            if ($request->isStep1()) {
                AttendanceSetting::where('id', $request->id)
                    ->firstOrNew()->fill($request->getStep1Data())->save();
            }

            if ($request->isStep2()) {
                $setting = AttendanceSetting::where('id', $request->get('group'))->first();

                if (! $setting) {
                    return response()->json([
                        'success' => false,
                        'messasge' => __('Group not found'),
                    ], 404);
                }

                $related = $setting->attributes()->where('key', 'workers')->firstOrNew([
                    'key' => 'workers',
                ]);

                $related->fill([
                    'key' => 'workers',
                    'attendance_setting_id' => $setting->id,
                    'value' => json_encode($request->workers),
                ]);

                $related->save();

                if (! $request->has('type') || $request->query('type') !== 'show') {
                    $setting->update([
                        'step' => AttendanceSettingEnum::STEP2(),
                    ]);
                }
            }

            if ($request->isStep3()) {
                $setting = AttendanceSetting::where('id', $request->get('group'))->first();

                if (! $setting) {
                    return response()->json([
                        'success' => false,
                        'messasge' => __('Group not found'),
                    ], 404);
                }

                $related = $setting->attributes()->where('key', 'cordinates')->firstOrNew([
                    'key' => 'cordinates',
                ]);

                $related->fill([
                    'key' => 'cordinates',
                    'attendance_setting_id' => $setting->id,
                    'value' => json_encode($request->cordinates),
                ]);

                $related->save();

                if (! $request->has('type') || $request->query('type') !== 'show') {
                    $setting->update([
                        'step' => AttendanceSettingEnum::STEP3(),
                    ]);
                }
            }

            if ($request->isStep4()) {
                $setting = AttendanceSetting::where('id', $request->get('group'))->first();

                if (! $setting) {
                    return response()->json([
                        'success' => false,
                        'messasge' => __('Group not found'),
                    ], 404);
                }

                $related = $setting->attributes()->where('key', 'timestamps')->firstOrNew([
                    'key' => 'timestamps',
                ]);

                $related->fill([
                    'key' => 'timestamps',
                    'attendance_setting_id' => $setting->id,
                    'value' => json_encode($request->getStep4Data()),
                ]);

                $related->save();

                if (! $request->has('type') || $request->query('type') !== 'show') {
                    $setting->update([
                        'step' => AttendanceSettingEnum::STEP4(),
                    ]);
                }
            }

            if ($request->isComplete()) {
                $setting = AttendanceSetting::where('id', $request->get('group'))->first();

                if (! $setting) {
                    return response()->json([
                        'success' => false,
                        'messasge' => __('Group not found'),
                    ], 404);
                }

                if (! $request->has('type') || $request->query('type') !== 'show') {
                    $setting->update([
                        'step' => AttendanceSettingEnum::COMPLETE(),
                        'status' => AttendanceSettingEnum::COMPLETE(),
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'success' => true,
            ], 500);
        }
    }

    public function destroy(AttendanceSetting $setting)
    {
        return DB::transaction(function () use ($setting) {
            $setting->delete();

            return back()->success(__('Berhasil menghapus penyuluh'));
        });
    }
}
