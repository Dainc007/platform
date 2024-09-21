<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminPanelController extends Controller
{
    public function __invoke(Request $request)
    {
        Gate::authorize('viewAny', Setting::class);

        return inertia('Admin/Dashboard');
    }
}
