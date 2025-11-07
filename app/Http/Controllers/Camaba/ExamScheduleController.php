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

        // Untuk camaba, tampilkan jadwal yang tersedia
        $examSchedules = ExamSchedule::active()
            ->available()
            ->with(['approvedExams', 'pendingExams'])
            ->orderBy('start_date', 'asc')
            ->get();

        // Check status pengajuan user untuk setiap jadwal
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
            'start_time' => 'required|date_format:Y-m-d H:i',  // Format tanggal + jam
            'end_time' => 'required|date_format:Y-m-d H:i',
        ], [
            'exam_schedule_id.required' => 'Jadwal ujian harus dipilih.',
            'exam_schedule_id.exists' => 'Jadwal ujian tidak valid.',
            'start_time.required' => 'Waktu mulai harus diisi.',
            'start_time.date_format' => 'Format waktu mulai tidak valid (YYYY-MM-DD HH:mm).',
            'end_time.required' => 'Waktu selesai harus diisi.',
            'end_time.date_format' => 'Format waktu selesai tidak valid (YYYY-MM-DD HH:mm).',
        ]);

        try {
            DB::beginTransaction();

            // Ambil exam schedule dengan locking
            $examSchedule = ExamSchedule::lockForUpdate()->findOrFail($validated['exam_schedule_id']);

            // Cek registrasi
            if (!$examSchedule->isRegistrationOpen()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pendaftaran untuk gelombang ini sudah ditutup atau belum dibuka!'
                ], 400);
            }

            // Cek apakah user sudah mengajukan
            if ($examSchedule->hasUserApplied(auth()->id())) {
                $existingExam = $examSchedule->getUserExamStatus(auth()->id());

                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah mengajukan jadwal ujian untuk gelombang ini dengan status: ' . $existingExam->getStatusText()
                ], 400);
            }

            // Cek kuota tersisa
            if (!$examSchedule->hasAvailableQuota()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maaf, kuota ujian untuk gelombang ini sudah penuh!'
                ], 400);
            }

            // Validasi durasi ujian
            $duration = $this->calculateDuration($validated['start_time'], $validated['end_time']);
            if ($duration < 60) {
                return response()->json([
                    'success' => false,
                    'message' => 'Durasi ujian minimal 60 menit!'
                ], 400);
            }

            if ($duration > 240) {
                return response()->json([
                    'success' => false,
                    'message' => 'Durasi ujian maksimal 240 menit (4 jam)!'
                ], 400);
            }

            // Buat pengajuan ujian
            $exam = Exam::create([
                'user_id' => auth()->id(),
                'exam_schedule_id' => $validated['exam_schedule_id'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'status' => Exam::STATUS_PENDING,
            ]);

            DB::commit();

            Log::info('Exam application submitted', [
                'user_id' => auth()->id(),
                'exam_id' => $exam->id,
                'exam_schedule_id' => $validated['exam_schedule_id'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Jadwal ujian berhasil diajukan! Menunggu persetujuan admin.',
                'data' => [
                    'exam_id' => $exam->id,
                    'status' => $exam->status,
                    'status_text' => $exam->getStatusText(),
                    'formatted_time' => $exam->getFormattedTime(),
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error submitting exam application', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengajukan jadwal ujian. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Show user's exam applications
     */
    public function myExams()
    {
        $exams = Exam::with(['examSchedule'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        $groupedExams = [
            'pending' => $exams->where('status', Exam::STATUS_PENDING),
            'approved' => $exams->where('status', Exam::STATUS_APPROVED),
            'rejected' => $exams->where('status', Exam::STATUS_REJECTED),
        ];

        return view('camaba.my-exams', compact('exams', 'groupedExams'));
    }

    /**
     * Cancel exam application (only pending)
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
                    'message' => 'Pengajuan dengan status "' . $exam->getStatusText() . '" tidak dapat dibatalkan.'
                ], 400);
            }

            $exam->delete();
            DB::commit();

            Log::info('Exam application cancelled', [
                'user_id' => auth()->id(),
                'exam_id' => $id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pengajuan ujian berhasil dibatalkan.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error cancelling exam application', [
                'user_id' => auth()->id(),
                'exam_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membatalkan pengajuan.'
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
     * Calculate duration in minutes
     */
    private function calculateDuration($startTime, $endTime)
    {
        $start = Carbon::createFromFormat('Y-m-d H:i', $startTime);
        $end = Carbon::createFromFormat('Y-m-d H:i', $endTime);

        return $start->diffInMinutes($end);
    }

    /**
     * Get available time slots
     */
    public function getAvailableTimeSlots(Request $request)
    {
        $examScheduleId = $request->exam_schedule_id;
        $date = $request->date;

        if (!$examScheduleId || !$date) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter tidak lengkap'
            ], 400);
        }

        // Contoh slot
        $availableSlots = [
            ['start' => '08:00', 'end' => '10:00', 'available' => true],
            ['start' => '10:00', 'end' => '12:00', 'available' => true],
            ['start' => '13:00', 'end' => '15:00', 'available' => false],
            ['start' => '15:00', 'end' => '17:00', 'available' => true],
        ];

        return response()->json([
            'success' => true,
            'data' => $availableSlots
        ]);
    }
}
