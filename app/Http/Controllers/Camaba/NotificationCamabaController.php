<?php

namespace App\Http\Controllers\Camaba;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationCamabaController extends Controller
{
    /**
     * Display a listing of notifications for the authenticated camaba user.
     */
    public function index()
    {
        // Ambil notifikasi user yang login dengan relasi jadwalUjian
        $notifications = Notification::with('jadwalUjian')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($notif) {
                // Format timestamp untuk tampilan human readable
                $notif->timestamp = $notif->created_at->diffForHumans();
                return $notif;
            });
        
        // Hitung jumlah notifikasi yang belum dibaca
        $unreadCount = $notifications->where('is_read', false)->count();
        
        return view('camaba.notifikasi', compact('notifications', 'unreadCount'));
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead($id)
    {
        try {
            // Cari notifikasi berdasarkan ID dan pastikan milik user yang login
            $notification = Notification::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
            
            // Update status menjadi sudah dibaca
            $notification->update(['is_read' => true]);
            
            return response()->json([
                'success' => true,
                'message' => 'Notifikasi berhasil ditandai sebagai dibaca'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menandai notifikasi'
            ], 500);
        }
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        try {
            Notification::where('user_id', Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true]);
            
            return response()->json([
                'success' => true,
                'message' => 'Semua notifikasi berhasil ditandai sebagai dibaca'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menandai semua notifikasi'
            ], 500);
        }
    }

    /**
     * Delete a specific notification.
     */
    public function delete($id)
    {
        try {
            $notification = Notification::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
            
            $notification->delete();
            
            return redirect()->back()->with('success', 'Notifikasi berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus notifikasi');
        }
    }

    /**
     * Delete all notifications for the authenticated user.
     */
    public function deleteAll()
    {
        try {
            Notification::where('user_id', Auth::id())->delete();
            
            return redirect()->back()->with('success', 'Semua notifikasi berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus notifikasi');
        }
    }

    /**
     * Get unread notification count (for badge/counter).
     */
    public function getUnreadCount()
    {
        $count = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();
        
        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }
}