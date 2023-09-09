<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ApprovalController extends Controller
{
    public function index()
    {
        return inertia('admin/approval/index')->title(__('Persetujuan'));
    }
}
