<?php

namespace App\Overrides\Navigator;

use Nedwors\Navigator\Nav as NavigatorNav;

class Nav extends NavigatorNav
{
    public function item(string $name): Item
    {
        return resolve(Item::class)->called($name);
    }
}
