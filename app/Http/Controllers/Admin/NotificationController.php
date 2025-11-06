<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    /**
     * Show pending exam applications (notifications)
     */
    public function index()
    {
        $pendingExams = Exam::with(['user', 'examSchedule'])
            ->pending()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.notifications.index', compact('pendingExams'));
    }

    /**
     * Approve exam application
     */
    public function approve($id)
    {
        try {
            DB::beginTransaction();

            $exam = Exam::with('examSchedule')->lockForUpdate()->findOrFail($id);

            // Check apakah masih pending
            if (!$exam->canBeProcessed()) {
                return redirect()->back()->with('error', 'Pengajuan ini sudah diproses sebelumnya!');
            }

            // Check kuota sebelum approve
            if (!$exam->examSchedule->hasAvailableQuota()) {
                return redirect()->back()->with('error', 'Kuota ujian sudah penuh!');
            }

            // Check apakah waktu ujian bentrok dengan jadwal lain yang sudah approved
            $conflict = Exam::where('exam_schedule_id', $exam->exam_schedule_id)
                ->where('status', Exam::STATUS_APPROVED)
                ->where('id', '!=', $exam->id)
                ->where(function($query) use ($exam) {
                    $query->whereBetween('start_time', [$exam->start_time, $exam->end_time])
                        ->orWhereBetween('end_time', [$exam->start_time, $exam->end_time])
                        ->orWhere(function($q) use ($exam) {
                            $q->where('start_time', '<=', $exam->start_time)
                              ->where('end_time', '>=', $exam->end_time);
                        });
                })
                ->exists();

            if ($conflict) {
                return redirect()->back()->with('error', 'Waktu ujian bentrok dengan jadwal yang sudah disetujui!');
            }

            // Approve exam
            $exam->update(['status' => Exam::STATUS_APPROVED]);

            DB::commit();

            // Log activity
            Log::info('Exam application approved', [
                'admin_id' => auth()->id(),
                'exam_id' => $exam->id,
                'user_id' => $exam->user_id,
            ]);

            // TODO: Kirim notifikasi ke user (email, push notification, dll)

            return redirect()->back()->with('success', 'Pengajuan ujian berhasil diterima!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error approving exam', [
                'admin_id' => auth()->id(),
                'exam_id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pengajuan.');
        }
    }

    /**
     * Reject exam application
     */
    public function reject($id)
    {
        try {
            DB::beginTransaction();

            $exam = Exam::lockForUpdate()->findOrFail($id);

            // Check apakah masih pending
            if (!$exam->canBeProcessed()) {
                return redirect()->back()->with('error', 'Pengajuan ini sudah diproses sebelumnya!');
            }

            // Reject exam
            $exam->update(['status' => Exam::STATUS_REJECTED]);

            DB::commit();

            // Log activity
            Log::info('Exam application rejected', [
                'admin_id' => auth()->id(),
                'exam_id' => $exam->id,
                'user_id' => $exam->user_id,
            ]);

            // TODO: Kirim notifikasi ke user (email, push notification, dll)

            return redirect()->back()->with('success', 'Pengajuan ujian ditolak.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error rejecting exam', [
                'admin_id' => auth()->id(),
                'exam_id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pengajuan.');
        }
    }

    /**
     * Show exam history (approved & rejected)
     */
    public function history()
    {
        $exams = Exam::with(['user', 'examSchedule'])
            ->whereIn('status', [Exam::STATUS_APPROVED, Exam::STATUS_REJECTED])
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        return view('admin.notifications.history', compact('exams'));
    }

    /**
     * Bulk approve (opsional)
     */
    public function bulkApprove(Request $request)
    {
        $validated = $request->validate([
            'exam_ids' => 'required|array',
            'exam_ids.*' => 'exists:exams,id'
        ]);

        try {
            DB::beginTransaction();

            $approvedCount = 0;
            $errors = [];

            foreach ($validated['exam_ids'] as $examId) {
                $exam = Exam::with('examSchedule')->lockForUpdate()->find($examId);

                if (!$exam || !$exam->canBeProcessed()) {
                    $errors[] = "Exam ID {$examId}: Sudah diproses";
                    continue;
                }

                if (!$exam->examSchedule->hasAvailableQuota()) {
                    $errors[] = "Exam ID {$examId}: Kuota penuh";
                    continue;
                }

                $exam->update(['status' => Exam::STATUS_APPROVED]);
                $approvedCount++;
            }

            DB::commit();

            $message = "{$approvedCount} pengajuan berhasil disetujui.";
            if (!empty($errors)) {
                $message .= " Gagal: " . implode(', ', $errors);
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error bulk approving exams', [
                'admin_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pengajuan.');
        }
    }
}