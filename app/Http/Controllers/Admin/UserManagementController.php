<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        if (! $request->user()->isAdmin()) {
            abort(403);
        }

        $query = User::query()
            ->when($request->input('search'), function ($q, $search) {
                $q->whereAny(['name', 'email'], 'LIKE', "%{$search}%");
            })
            ->orderBy('name');

        $users = $query->paginate(15)->through(function (User $user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_active' => $user->is_active,
            ];
        });

        return inertia('Admin/Users', [
            'users' => $users,
        ]);
    }

    public function toggle(Request $request, User $user)
    {
        if (! $request->user()->isAdmin()) {
            abort(403);
        }

        if ($user->id === $request->user()->id) {
            return back()->with('message', 'You cannot deactivate your own account.');
        }

        $user->is_active = ! $user->is_active;
        $user->save();

        return back()->with('message', 'User '.($user->is_active ? 'activated' : 'deactivated').' successfully');
    }

    public function activity(Request $request, User $user)
    {
        if (! $request->user()->isAdmin()) {
            abort(403);
        }

        // Pull recent session rows for this user
        $sessions = DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderByDesc('last_activity')
            ->limit(25)
            ->get(['id', 'ip_address', 'user_agent', 'last_activity'])
            ->map(function ($session) {
                return [
                    'id' => $session->id,
                    'ip_address' => $session->ip_address,
                    'user_agent' => $session->user_agent,
                    'last_activity' => $session->last_activity,
                    'location' => $this->getLocation($session->ip_address),
                ];
            });

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'sessions' => $sessions,
        ]);
    }

    protected function getLocation($ip)
    {
        if ($ip === '127.0.0.1' || $ip === '::1') {
            return 'Localhost';
        }

        try {
            // Using a free, no-key-needed API for basic location info
            // Note: In production, consider a more robust/paid service or a local database (GeoIP)
            $response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,country,city,regionName");
            if ($response) {
                $data = json_decode($response, true);
                if ($data && $data['status'] === 'success') {
                    return "{$data['city']}, {$data['regionName']}, {$data['country']}";
                }
            }
        } catch (\Exception $e) {
            // Silence errors to avoid breaking the activity view
        }

        return null;
    }
}
