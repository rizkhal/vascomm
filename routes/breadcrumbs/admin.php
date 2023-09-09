<?php

use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;

Breadcrumbs::for(
    'admin.dashboard',
    fn (Trail $trail): Trail => $trail->push(__('Dashboard'))
);
