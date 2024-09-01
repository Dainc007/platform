<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Support\Facades\Gate;

class AdminPanelController extends Controller
{
    public function __invoke()
    {
        Gate::authorize('view', Setting::class);

        return inertia('Admin/Dashboard');
    }
}
