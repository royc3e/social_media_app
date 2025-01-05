<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Fetch unread notifications for the authenticated user
    public function getUnreadNotifications(Request $request)
    {
        $user = $request->user(); // Assuming the user is authenticated

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Fetch unread notifications for the user
        $unreadNotifications = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->get();

        if ($unreadNotifications->isEmpty()) {
            // Debugging: If no unread notifications, return a message
            return response()->json(['message' => 'No unread notifications found']);
        }

        return response()->json($unreadNotifications);
    }


    // Mark a notification as read
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->update(['is_read' => true]);

        return response()->json(['message' => 'Notification marked as read']);
    }

    // Delete a notification
    public function deleteNotification($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();

        return response()->json(['message' => 'Notification deleted']);
    }
}