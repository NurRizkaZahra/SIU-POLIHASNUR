<?php

namespace App\Http\Controllers\Camaba;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamSchedule;
use App\Models\Exam;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ExamScheduleController extends Controller
{
    /**
     * Display exam schedules
     */
    public function index()
    {
        // Redirect admin ke halaman admin
        if (auth()->check() && auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.exam-schedule-admin');
        }

        // Ambil jadwal ujian aktif dan tersedia
        $examSchedules = ExamSchedule::active()
            ->available()
            ->with(['approvedExams', 'pendingExams'])
            ->orderBy('start_date', 'asc')
            ->get();

        // Tambahkan status user
        $userId = auth()->id();
        foreach ($examSchedules as $schedule) {
            $schedule->userExamStatus = $schedule->getUserExamStatus($userId);
        }

        return view('camaba.exam-schedule', compact('examSchedules'));
    }

    /**
     * Store exam application
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_schedule_id' => 'required|exists:exam_schedules,id',
        ],[
            'exam_schedule_id.required' => 'Jadwal ujian harus dipilih.',
            'exam_schedule_id.exists' => 'Jadwal ujian tidak valid.',
        ]);

        try {
            DB::beginTransaction();

            $examSchedule = ExamSchedule::lockForUpdate()->findOrFail($validated['exam_schedule_id']);

            // Cek status registrasi
            if (!$examSchedule->isRegistrationOpen()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pendaftaran untuk gelombang ini sudah ditutup atau belum dibuka!'
                ], 400);
            }

            // Cek apakah user sudah apply
            if ($examSchedule->hasUserApplied(auth()->id())) {
                $existingExam = $examSchedule->getUserExamStatus(auth()->id());

                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah mengajukan jadwal ujian untuk gelombang ini dengan status: ' . $existingExam->getStatusText()
                ], 400);
            }

            // Cek kuota
            if (!$examSchedule->hasAvailableQuota()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kuota ujian sudah penuh!'
                ], 400);
            }

            // Buat pengajuan ujian
            $exam = Exam::create([
                'user_id' => auth()->id(),
                'exam_schedule_id' => $validated['exam_schedule_id'],
                'status' => Exam::STATUS_PENDING,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Jadwal ujian berhasil diajukan!',
                'data'    => [
                    'exam_id' => $exam->id,
                    'status_text' => $exam->getStatusText(),
                    'formatted_time' => $exam->getFormattedTime(),
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error submitting exam application: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * List of user's exam applications
     */
    public function myExams()
    {
        $exams = Exam::with(['examSchedule'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        $groupedExams = [
            'pending'  => $exams->where('status', Exam::STATUS_PENDING),
            'approved' => $exams->where('status', Exam::STATUS_APPROVED),
            'rejected' => $exams->where('status', Exam::STATUS_REJECTED),
        ];

        return view('camaba.my-exams', compact('exams', 'groupedExams'));
    }

    /**
     * Cancel exam application
     */
    public function cancel($id)
    {
        try {
            DB::beginTransaction();

            $exam = Exam::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            if (!$exam->canBeCancelled()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengajuan tidak dapat dibatalkan.'
                ], 400);
            }

            $exam->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pengajuan berhasil dibatalkan.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error cancelling exam: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membatalkan.'
            ], 500);
        }
    }

    /**
     * Show exam schedule detail
     */
    public function show($id)
    {
        $examSchedule = ExamSchedule::with([
            'approvedExams.user',
            'pendingExams'
        ])->findOrFail($id);

        $userExamStatus = $examSchedule->getUserExamStatus(auth()->id());

        return view('camaba.exam-schedule-detail', compact('examSchedule', 'userExamStatus'));
    }

    /**
     * Dummy time slots
     */
    public function getAvailableTimeSlots(Request $request)
    {
        if (!$request->exam_schedule_id || !$request->date) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter tidak lengkap'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => [
                ['start' => '08:00', 'end' => '10:00', 'available' => true],
                ['start' => '10:00', 'end' => '12:00', 'available' => true],
                ['start' => '13:00', 'end' => '15:00', 'available' => false],
                ['start' => '15:00', 'end' => '17:00', 'available' => true],
            ]
        ]);
    }

    /**
     * ✅ Notifications for Camaba
     */
    public function notifications()
    {
        $userId = auth()->id();

        // Ambil semua pengajuan
        $exams = Exam::with('examSchedule')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung unread jika kolom tersedia
        $unreadCount = 0;
        try {
            $unreadCount = Exam::where('user_id', $userId)
                ->whereNull('is_read')
                ->count();
        } catch (\Exception $e) {
            $unreadCount = 0;
        }

        // Kelompokkan status
        $grouped = [
            'pending'  => $exams->where('status', Exam::STATUS_PENDING),
            'approved' => $exams->where('status', Exam::STATUS_APPROVED),
            'rejected' => $exams->where('status', Exam::STATUS_REJECTED),
        ];

        return view('camaba.notifications', [
    'notifications' => $exams,
    'grouped' => $grouped,
    'unreadCount' => $unreadCount
]);
    }
    public function deleteNotification($id)
{
    Exam::where('id', $id)
       ->where('user_id', auth()->id())
       ->delete();

    return redirect()->route('camaba.notifications')->with('success', 'Notifikasi berhasil dihapus.');
}

}
