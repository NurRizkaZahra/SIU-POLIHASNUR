<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Notification;

class AdminExamController extends Controller
{
    /**
     * Tampilkan daftar exam request yang pending
     */
    public function notifications()
    {
        $pendingExams = Exam::pending()
            ->with(['user', 'examSchedule'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.notifications', compact('pendingExams'));
    }

    /**
     * Approve exam request
     */
    public function approve($id)
    {
        $exam = Exam::findOrFail($id);

        // Cek kuota jadwal
        if ($exam->examSchedule && $exam->examSchedule->isFull()) {
            return redirect()->back()->with('error', 'Exam schedule is already full!');
        }

        $exam->update(['status' => 'approved']);

        // Kirim notifikasi untuk camaba
        Notification::create([
            'user_id' => $exam->user_id,
            'exam_schedule_id' => $exam->exam_schedule_id, // ✅ DITAMBAHKAN
            'title'   => 'Exam Schedule Approved',
            'message' => 'Your exam request has been approved. Please check your exam schedule.',
            'type'    => 'exam_schedule',
            'is_read' => 0,
        ]);

        return redirect()->back()->with('success', 'Exam request has been approved!');
    }

    /**
     * Reject exam request
     */
    public function reject($id)
    {
        $exam = Exam::findOrFail($id);

        $exam->update(['status' => 'rejected']);

        // Kirim notifikasi ke camaba
        Notification::create([
            'user_id' => $exam->user_id,
            'exam_schedule_id' => $exam->exam_schedule_id, // ✅ DITAMBAHKAN
            'title'   => 'Exam Schedule Rejected',
            'message' => 'Your exam request has been rejected. Please submit a new schedule.',
            'type'    => 'exam_schedule',
            'is_read' => 0,
        ]);

        return redirect()->back()->with('success', 'Exam request has been rejected!');
    }

    /**
     * Bulk approve (persetujuan massal)
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'exam_ids' => 'required|array',
            'exam_ids.*' => 'exists:exams,id'
        ]);

        // Approve semua
        Exam::whereIn('id', $request->exam_ids)
            ->update(['status' => 'approved']);

        // Beri notifikasi per user
        foreach ($request->exam_ids as $examId) {
            $exam = Exam::find($examId);
            Notification::create([
                'user_id' => $exam->user_id,
                'exam_schedule_id' => $exam->exam_schedule_id, // ✅ DITAMBAHKAN
                'title'   => 'Exam Schedule Approved',
                'message' => 'Your exam request has been approved.',
                'type'    => 'exam_schedule',
                'is_read' => 0,
            ]);
        }

        return redirect()->back()->with('success', 'Selected exams have been approved!');
    }

    /**
     * Hitung jumlah pending untuk icon bell
     */
    public static function getPendingCount()
    {
        return Exam::where('status', 'pending')->count();
    }
}
