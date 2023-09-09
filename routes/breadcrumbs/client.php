<?php

use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;

Breadcrumbs::for(
    'client.dashboard.index',
    fn (Trail $trail): Trail => $trail->push(__('Dashboard'))
);
