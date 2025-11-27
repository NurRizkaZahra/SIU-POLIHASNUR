<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamSchedule;
use App\Models\Exam;

class ExamScheduleAdminController extends Controller
{
    /**
     * Display all exam schedules (tampilkan semua)
     */
    public function index()
    {
        // Tampilkan SEMUA jadwal ujian, tidak harus punya pengajuan
        $examSchedules = ExamSchedule::withCount([
                'exams as total_applications',
                'pendingExams as pending_count',
                'approvedExams as approved_count',
                'rejectedExams as rejected_count'
            ])
            ->orderBy('start_date', 'desc')
            ->get();

        return view('admin.exam-schedule-admin', compact('examSchedules'));
    }

    /**
     * Show the form for creating a new exam schedule
     */
    public function create()
    {
        return view('admin.exam-schedule-create');
    }

    /**
     * Store a newly created exam schedule in the database
     */
    public function store(Request $request)
    {
        $request->validate([
            'wave_name' => 'required|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'participant_quota' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);
        
        ExamSchedule::create($request->only(
            'wave_name',
            'start_date',
            'end_date',
            'participant_quota',
            'status'
        ));

        return redirect()->route('admin.exam-schedule-admin')
            ->with('success', 'Jadwal ujian berhasil dibuat!');
    }

    /**
     * Show the form for editing an existing exam schedule
     */
    public function edit($id)
    {
        // Tidak perlu has('exams'), tetap boleh edit meski belum ada pengajuan
        $examSchedule = ExamSchedule::findOrFail($id);
        
        return view('admin.exam-schedule-edit', compact('examSchedule'));
    }

    /**
     * Update an existing exam schedule
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'wave_name' => 'required|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'participant_quota' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        $examSchedule = ExamSchedule::findOrFail($id);
        $examSchedule->update($request->only(
            'wave_name',
            'start_date',
            'end_date',
            'participant_quota',
            'status'
        ));

        return redirect()->route('admin.exam-schedule-admin')
            ->with('success', 'Jadwal ujian berhasil diupdate!');
    }

    /**
     * Delete an exam schedule
     * Tidak bisa hapus jika ada pengajuan yang sudah approved
     */
    public function destroy($id)
    {
        $examSchedule = ExamSchedule::findOrFail($id);
        
        if ($examSchedule->approvedExams()->exists()) {
            return redirect()->route('admin.exam-schedule-admin')
                ->with('error', 'Tidak dapat menghapus jadwal yang sudah memiliki pengajuan disetujui!');
        }
        
        $examSchedule->exams()->delete();
        
        $examSchedule->delete();

        return redirect()->route('admin.exam-schedule-admin')
            ->with('success', 'Jadwal ujian berhasil dihapus!');
    }
    
    /**
     * Lihat detail jadwal dengan daftar camaba yang mengajukan
     */
    public function show($id)
    {
        $examSchedule = ExamSchedule::with([
            'exams.user' => function($query) {
                $query->select('id', 'name', 'email');
            }
        ])
        ->withCount(['pendingExams', 'approvedExams', 'rejectedExams'])
        ->findOrFail($id);
        
        $groupedExams = [
            'pending' => $examSchedule->pendingExams,
            'approved' => $examSchedule->approvedExams,
            'rejected' => $examSchedule->rejectedExams,
        ];
        
        return view('admin.exam-schedule-detail', compact('examSchedule', 'groupedExams'));
    }
}