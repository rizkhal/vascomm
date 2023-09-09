<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Inertia\Response as InertiaResponse;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerInertia()
            ->registerRequest()
            ->regsisterCommonFields()
            ->registerSearchWhereLike()
            ->registerSessionHelper();
    }

    private function registerRequest(): self
    {
        Request::macro('getFilter', function ($key) {
            return $this->whenFilled($key, fn () => $this->get($key), fn () => false);
        });

        return $this;
    }

    public function registerSessionHelper(): self
    {
        RedirectResponse::macro('success', function (string $message) {
            $this->with(['success' => $message]);

            return $this;
        });

        RedirectResponse::macro('info', function (string $message) {
            $this->with(['info' => $message]);

            return $this;
        });

        RedirectResponse::macro('warning', function (string $message) {
            $this->with(['warning' => $message]);

            return $this;
        });

        RedirectResponse::macro('error', function (string $message, $context = []) {
            if (!empty($context)) {
                Log::error($message, $context);
            }

            $this->with(['error' => $message]);

            return $this;
        });

        return $this;
    }

    public function registerInertia(): self
    {
        InertiaResponse::macro('title', function ($title) {
            return $this->with('title', $title);
        });

        return $this;
    }

    protected function registerSearchWhereLike(): self
    {
        Builder::macro('whereLike', function ($attributes, string|null $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (Arr::wrap($attributes) as $attribute) {
                    $query->when(
                        Str::contains($attribute, '.'),
                        function (Builder $query) use ($attribute, $searchTerm) {
                            if (count(explode('.', $attribute)) > 2) {
                                [$relationName_1, $relationName_2, $relationAttribute_1] = explode('.', $attribute);

                                $query->orWhereHas($relationName_1 . '.' . $relationName_2, function (Builder $query) use ($relationAttribute_1, $searchTerm) {
                                    $query->where($relationAttribute_1, 'LIKE', "%{$searchTerm}%");
                                });
                            } else {
                                [$relationName, $relationAttribute] = explode('.', $attribute);

                                $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerm) {
                                    $query->where($relationAttribute, 'LIKE', "%{$searchTerm}%");
                                });
                            }
                        },
                        function (Builder $query) use ($attribute, $searchTerm) {
                            $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                        }
                    );
                }
            });

            return $this;
        });

        return $this;
    }

    protected function regsisterCommonFields(): self
    {
        Blueprint::macro('commonFields', function () {
            $this->timestamps();
            $this->softDeletes();
            $this->foreignId('created_by')->nullable();
            $this->foreignId('updated_by')->nullable();
            $this->foreignId('deleted_by')->nullable();
        });

        return $this;
    }
}
