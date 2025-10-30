<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamSchedule;

class ExamScheduleAdminController extends Controller
{
    /**
     * Display all exam schedules
     */
    public function index()
    {
        // Retrieve all schedules, sorted by latest start date
        $examSchedules = ExamSchedule::orderBy('start_date', 'desc')->get();

        // Send to the view
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
        ($request->all());
        $request->validate([
            'wave_name' => 'required|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'participant_quota' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);
        ExamSchedule::create([
            'wave_name' => $request->wave_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'participant_quota' => $request->participant_quota,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.exam-schedule')->with('success', 'Exam schedule created successfully!');

    }

    /**
     * Show the form for editing an existing exam schedule
     */
    public function edit($id)
    {
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
        $examSchedule->update($request->only('wave_name', 'start_date', 'end_date', 'participant_quota', 'status'));

        return redirect()->route('admin.exam-schedule')->with('success', 'Exam schedule deleted successfully!');

    }

    /**
     * Delete an exam schedule
     */
    public function destroy($id)
    {
        $examSchedule = ExamSchedule::findOrFail($id);
        $examSchedule->delete();

       return redirect()->route('admin.exam-schedule')->with('success', 'Exam schedule deleted successfully!');

    }
}
