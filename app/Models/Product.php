<?php

namespace App\Models;

use App\Enums\ProductStatus;
use App\Models\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory,
        HasAuthor,
        SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => ProductStatus::class,
    ];

    public  static function booted()
    {
        if (!app()->runningInConsole()) {
            static::created(function (self $model) {
                $model->update([
                    'created_by' => auth()->user()->id,
                ]);
            });

            static::forceDeleted(function (self $model) {
                if ($model->hasPicture()) {
                    Storage::delete($model->picture['path']);
                }
            });
        }
    }

    public function picture(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => [
                'path' => $value,
                'full_path' => $value ? env('APP_URL') . '/' . $value : null
            ],
        );
    }

    public function hasPicture(): bool
    {
        return Storage::fileExists($this->picture['path']);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where($this->qualifyColumn('status'), ProductStatus::ACTIVE());
    }

    public static function price($number)
    {
        $ret = $number ? (string) number_format((float) $number, 0, ',', '.') : 0;

        return 'Rp. ' . $ret;
    }
}
