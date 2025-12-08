<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DutyReport;
use App\Models\Participant;

class ReportController extends Controller
{
    public function index($duty_id = null)
    {
        // Get the event duty with participants and team leader
        $duty = \App\Models\EventDuty::with(['participants.student'])
            ->where('event_id', $duty_id)
            ->first();

        if (!$duty) {
            return redirect()->route('member.duties')->with('error', 'Duty not found');
        }

        // Get the current user's report if it exists
        $student = Auth::guard('student')->user();
        $existingReport = DutyReport::where('event_id', $duty_id)
            ->where(function ($q) use ($student) {
                $q->where('user_id', $student->user_id)
                  ->orWhere('plv_student_id', $student->plv_student_id);
            })->first();

        return view('member.member-report', [
            'duty' => $duty,
            'participants' => $duty->participants,
            'teamLeader' => $duty->team_leader_name,
            'dutyTitle' => $duty->title,
            'existingReport' => $existingReport
        ]);
    }

    /**
     * History view for a report (read-only, no create/edit button)
     */
    public function history($duty_id = null)
    {
        $duty = \App\Models\EventDuty::with(['participants.student'])
            ->where('event_id', $duty_id)
            ->first();

        if (!$duty) {
            return redirect()->route('member.duties')->with('error', 'Duty not found');
        }

        $student = Auth::guard('student')->user();
        $existingReport = DutyReport::where('event_id', $duty_id)
            ->where(function ($q) use ($student) {
                $q->where('user_id', $student->user_id)
                  ->orWhere('plv_student_id', $student->plv_student_id);
            })->first();

        return view('member.member-report', [
            'duty' => $duty,
            'participants' => $duty->participants,
            'teamLeader' => $duty->team_leader_name,
            'dutyTitle' => $duty->title,
            'existingReport' => $existingReport,
            'historyMode' => true
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'summary' => 'required|string|max:255',
            'details' => 'required|string',
            'event_id' => 'required|integer',
        ]);

        $student = Auth::guard('student')->user();
        if (!$student) {
            return redirect()->route('student.login');
        }

        // The app stores participant registrations in the duty DB Participants table.
        $participant = Participant::where('event_id', $request->input('event_id'))
            ->where(function ($q) use ($student) {
                $q->where('user_id', $student->user_id)
                  ->orWhere('plv_student_id', $student->plv_student_id);
            })->first();

        // Log the participant lookup result
        \Log::info('Participant lookup result:', [
            'event_id' => $request->input('event_id'),
            'student_user_id' => $student->user_id,
            'student_plv_id' => $student->plv_student_id,
            'found_participant' => $participant ? true : false,
            'participant_id' => $participant ? $participant->participant_id : null
        ]);

        DB::beginTransaction();
        try {
            $attachments = null;
            if ($request->hasFile('attachments')) {
                $files = $request->file('attachments');
                $paths = [];
                foreach ($files as $file) {
                    $path = $file->store('reports', 'public');
                    \Log::info('File stored:', ['path' => $path]);
                    $paths[] = $path;
                }
                $attachments = $paths;
            }

            $now = now();
            // Check if report already exists
            $existingReport = DutyReport::where('event_id', $request->input('event_id'))
                ->where(function ($q) use ($student) {
                    $q->where('user_id', $student->user_id)
                      ->orWhere('plv_student_id', $student->plv_student_id);
                })->first();

            \Log::info('Report action:', [
                'type' => $existingReport ? 'update' : 'create',
                'report_id' => $existingReport ? $existingReport->id : null
            ]);

            if ($existingReport) {
                // Update existing report
                $existingReport->update([
                    'summary' => $validated['summary'],
                    'details' => $validated['details'],
                    'attachments' => $attachments ?? $existingReport->attachments,
                    'updated_at' => $now
                ]);
                $message = 'Report updated successfully';
            } else {
                // Create new report
                $report = DutyReport::create([
                    'participant_id' => $participant ? $participant->participant_id : null,
                    'event_id' => $request->input('event_id'),
                    'user_id' => $student->user_id,
                    'plv_student_id' => $student->plv_student_id,
                    'summary' => $validated['summary'],
                    'details' => $validated['details'],
                    'attachments' => $attachments,
                    'status' => 'completed', // Changed to match migration enum
                    'submitted_at' => $now,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
                \Log::info('New report created:', ['report_id' => $report->id]);
                $message = 'Report submitted successfully';
            }

            DB::commit();
            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Report store error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'student_data' => [
                    'user_id' => $student->user_id,
                    'plv_student_id' => $student->plv_student_id
                ]
            ]);
            return redirect()->back()->with('error', 'Could not submit report: ' . $e->getMessage());
        }
    }

    /**
     * Return a participant's report (if any) as JSON for viewing in a modal.
     *
     * @param  int  $participant_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showParticipant($participant_id)
    {
        try {
            $report = DutyReport::where('participant_id', $participant_id)->first();

            if (!$report) {
                return response()->json(['message' => 'Report not found'], 404);
            }

            // Prepare attachment URLs if present
            $attachments = [];
            if ($report->attachments && is_array($report->attachments)) {
                foreach ($report->attachments as $path) {
                    $attachments[] = asset('storage/' . ltrim($path, '/'));
                }
            }

            return response()->json([
                'id' => $report->id,
                'summary' => $report->summary,
                'details' => $report->details,
                'status' => $report->status,
                'submitted_at' => $report->submitted_at ? $report->submitted_at->toDateTimeString() : null,
                'attachments' => $attachments,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading participant report: ' . $e->getMessage());
            return response()->json(['message' => 'Error loading report'], 500);
        }
    }
}