<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Fetch unread notifications for the authenticated user
    public function unread()
    {
        $notifications = Notification::where('user_id', Auth::id())
                                      ->where('is_read', false)
                                      ->get();

        return response()->json($notifications);
    }

    // Mark a notification as read
    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
                                    ->where('user_id', Auth::id())
                                    ->first();

        if ($notification) {
            $notification->is_read = true;
            $notification->save();
        }

        return response()->json(['status' => 'success']);
    }

    // Delete a notification
    public function destroy($id)
    {
        $notification = Notification::where('id', $id)
                                    ->where('user_id', Auth::id())
                                    ->first();

        if ($notification) {
            $notification->delete();
        }

        return response()->json(['status' => 'deleted']);
    }
}
