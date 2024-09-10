<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AdminPanelController extends Controller
{
    public function __invoke()
    {
        if(!Auth::user()->isAdmin()) {
            return abort(403);
        }

        return inertia('Admin/Dashboard');
    }
}
