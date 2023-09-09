<?php

namespace App\Facades;

use App\Overrides\Navigator\Nav;
use Illuminate\Support\Facades\Facade;

class Navigator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Nav::class;
    }
}
