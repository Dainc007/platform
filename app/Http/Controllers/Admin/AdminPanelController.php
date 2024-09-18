<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminPanelController extends Controller
{
    public function __invoke(Request $request)
    {
        if (!$request->user()->can('view any setting')) {
            abort(403);
        }

        return inertia('Admin/Dashboard');
    }
}
