<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::whereAny(['name', 'email'], 'LIKE', '%' . $request->input('search', '') . '%')->paginate(10);

        return inertia('User/Index', ['users' => $users]);
    }

    public function edit(User $user)
    {
        return back()->with(['message' => 'Feature Not Supported']);
    }

    public function show()
    {
        return back()->with(['message' => 'Feature Not Supported']);
    }
}
