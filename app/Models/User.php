<?php

namespace App\Models;

use App\Enums\UserStatus;
use Illuminate\Support\Str;
use App\Models\Traits\HasAuthor;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use App\Abstract\AuthenticableUserModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends AuthenticableUserModel
{
    use HasFactory,
        HasAuthor,
        SoftDeletes,
        HasRoles;

    protected $guarded = [];

    protected $casts = [
        'status' => UserStatus::class,
    ];

    protected $appends = [
        'profile_picture',
    ];

    public  static function booted()
    {
        static::creating(function (self $model) {
            if (!app()->runningInConsole()) {
                $model->fill([
                    'status' => UserStatus::ACTIVE(),
                    'created_by' => auth()->user()->id,
                    'password' => !$model->password ? Hash::make(Str::random(6)) : $model->password,
                ]);
            }
        });
    }

    public function profilePicture(): Attribute
    {
        return Attribute::make(
            get: fn () => "https://ui-avatars.com/api/?name={$this->username}&color=FFFFFF&background=111827"
        );
    }

    public function scopeActive(Builder $query): void
    {
        $query->where($this->qualifyColumn('status'), UserStatus::ACTIVE());
    }
}
