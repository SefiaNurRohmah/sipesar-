<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(10); // Get all notifications, paginated

        // Mark all unread notifications as read when viewing the index page
        $user->unreadNotifications->markAsRead();

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(Request $request, $id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();

            if ($request->ajax()) {
                return response()->json(['success' => true]);
            }
            return back()->with('status', 'Notifikasi ditandai sudah dibaca.');
        }

        if ($request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Notification not found or not owned by user.'], 404);
        }
        return back()->with('error', 'Notifikasi tidak ditemukan.');
    }
}