<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;

class AdminExamController extends Controller
{
    /**
     * Tampilkan notifikasi exam requests yang pending
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
        
        // Check apakah jadwal masih ada quota
        if ($exam->examSchedule && $exam->examSchedule->isFull()) {
            return redirect()->back()->with('error', 'Exam schedule is already full!');
        }
        
        $exam->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Exam request has been approved!');
    }

    /**
     * Reject exam request
     */
    public function reject($id)
    {
        $exam = Exam::findOrFail($id);
        $exam->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Exam request has been rejected!');
    }

    /**
     * Bulk approve multiple exams
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'exam_ids' => 'required|array',
            'exam_ids.*' => 'exists:exam,id'
        ]);

        Exam::whereIn('id', $request->exam_ids)
            ->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Selected exams have been approved!');
    }

    /**
     * Get pending count for bell icon
     */
    public static function getPendingCount()
    {
        return Exam::where('status', 'pending')->count();
    }
}
