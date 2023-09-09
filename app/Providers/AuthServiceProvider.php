<?php

namespace App\Providers;

use App\Facades\Auth;
use App\Models\SchoolSchedule;
use App\Models\SmartSchedule;
use App\Models\User\Student;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('smart_teacher_absent', function (Authenticatable $user, SmartSchedule $schedule) {
            if (! Auth::isSmartTeacher()) {
                return false;
            }

            return $user->id === $schedule->guru_smart_id;
        });

        Gate::define('absent', function (Authenticatable|Student $user, SchoolSchedule $schedule) {
            if (! $user instanceof Student) {
                if (Auth::isSchoolTeacher()) {
                    return $user->id_guru === $schedule->id_guru;
                }
            }

            // if true, the given student has live schedule for presence
            return $user->id_kelas === $schedule->id_kelas;
        });
    }
}
