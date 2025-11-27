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
     * Halaman daftar jadwal ujian camaba
     */
    public function index()
    {
        // Jika admin salah masuk ke halaman camaba
        if (auth()->check() && auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.exam-schedule-admin');
        }

        $examSchedules = ExamSchedule::active()
            ->available()
            ->with(['approvedExams', 'pendingExams'])
            ->orderBy('start_date', 'asc')
            ->get();

        $userId = auth()->id();

        foreach ($examSchedules as $schedule) {
            $schedule->userExamStatus = $schedule->getUserExamStatus($userId);
        }

        return view('camaba.exam-schedule', compact('examSchedules'));
    }

    /**
     * STORE PENGAJUAN UJIAN
     * User hanya boleh mengajukan 1 kali seumur hidup
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

            // =====================================================
            // 1️⃣ GLOBAL CHECK: User hanya boleh ajukan ujian 1x
            // =====================================================
            $alreadyApplied = Exam::where('user_id', auth()->id())->exists();

            if ($alreadyApplied) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda hanya dapat mengajukan jadwal ujian satu kali saja.'
                ], 400);
            }

            // Lock row jadwal ujian
            $examSchedule = ExamSchedule::lockForUpdate()->findOrFail($validated['exam_schedule_id']);

            // 2️⃣ Cek apakah pendaftaran gelombang dibuka
            if (!$examSchedule->isRegistrationOpen()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pendaftaran untuk gelombang ini sudah ditutup atau belum dibuka!'
                ], 400);
            }

            // 3️⃣ Cek apakah user sudah apply di gelombang yang sama
            if ($examSchedule->hasUserApplied(auth()->id())) {
                $existingExam = $examSchedule->getUserExamStatus(auth()->id());

                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah mengajukan jadwal ujian untuk gelombang ini dengan status: ' . $existingExam->getStatusText()
                ], 400);
            }

            // 4️⃣ Cek kuota
            if (!$examSchedule->hasAvailableQuota()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kuota ujian sudah penuh!'
                ], 400);
            }

            // =====================================================
            // 5️⃣ Buat pengajuan ujian
            // =====================================================
            $exam = Exam::create([
                'user_id' => auth()->id(),
                'exam_schedule_id' => $validated['exam_schedule_id'],
                'status' => Exam::STATUS_PENDING,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Jadwal ujian berhasil diajukan! Menunggu persetujuan admin.',
                'data' => [
                    'exam_id'        => $exam->id,
                    'status_text'    => $exam->getStatusText(),
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
     * Halaman daftar pengajuan user
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
     * Membatalkan pengajuan ujian
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
     * Detail jadwal ujian
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
     * Slot waktu dummy
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
     * Notifikasi camaba
     */
    public function notifications()
    {
        $userId = auth()->id();

        $exams = Exam::with('examSchedule')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // hitung unread jika kolom ada
        try {
            $unreadCount = Exam::where('user_id', $userId)
                ->whereNull('is_read')
                ->count();
        } catch (\Exception $e) {
            $unreadCount = 0;
        }

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

        return redirect()->route('camaba.notifications')
            ->with('success', 'Notifikasi berhasil dihapus.');
    }
}

