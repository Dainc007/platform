<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;


class NotificationController extends Controller
{
    public function update(Request $request, DatabaseNotification $notification)
    {
        dd($request->all(), $notification);
        $notification->markAsRead();

        return response()->json(['message' => 'Notification marked as read.']);
    }
}
