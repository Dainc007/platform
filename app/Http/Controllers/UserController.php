<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::whereAny(['name', 'email'], 'LIKE', '%' . $request->input('search', '') . '%')->paginate(5)->through(function ($item) {
        return  [
            'id'   => $item->id,
            'name' => $item->name,
            'email' => $item->email
        ];
    });

        return inertia('User/Index', [
            'users' => $users,
            'columns' => ['users.name', 'users.status']]
        );
    }

    public function edit(User $user)
    {
        return back()->with(['message' => 'Feature Not Supported']);
    }

    public function show()
    {
        return back()->with(['message' => 'Feature Not Supported']);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with(['message' => 'Deleted']);
    }
}
