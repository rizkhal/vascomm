<?php

namespace App\Providers;

use App\Facades\Navigator as Nav;
use Illuminate\Support\ServiceProvider;

class NavigatorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Nav::define(function () {
            $user = auth()?->user();

            return [
                Nav::item(__('Dashboard'))->for('dashboard')->icon('HomeIcon'),
                Nav::item(__('Produk'))->for('products.index')->icon('BookmarkSquareIcon')->when($user?->hasRole('user')),
                Nav::item(__('Manajemen User'))->for('users.index')->icon('UserIcon')->when($user?->hasRole('admin')),
                Nav::item(__('Manajemen Produk'))->for('products.index')->icon('BookmarkSquareIcon')->when($user?->hasRole('admin')),
            ];
        });
    }
}
