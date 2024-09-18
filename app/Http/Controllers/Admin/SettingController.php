<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\UpdateSettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!$request->user()->can('view any setting')) {
            abort(403);
        }

        return inertia('Admin/Setting/Index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        $setting->value === 1 ? $setting->value = 0 : $setting->value = 1;
        $setting->save();

        return redirect()->route('admin.dashboard');
    }
}
