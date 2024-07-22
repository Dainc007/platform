<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereAny(['name', 'email'], 'LIKE', '%' . $_REQUEST['search'] . '%')->paginate(10);

        return inertia('User/Index', ['users' => $users]);
    }
}
