<?php

namespace App\Modules\manage_dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\CliController;

class manage_dashboard_controller extends CliController
{
    // show admin dashboard
    public function index() {
        return view('cms.index');
    }
}
