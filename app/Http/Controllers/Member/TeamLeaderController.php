<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\EventDuty;
use App\Models\Participant;
use App\Models\DutyReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TeamLeaderController extends Controller
{
    public function index($dutyId)
    {
        // Get the duty with its participants
        $duty = EventDuty::with('participants')->findOrFail($dutyId);
        
        // Find team leader from participants
        $teamLeader = $duty->participants->firstWhere('is_team_leader', true);

        // Get the current user's report if it exists
        $student = Auth::guard('student')->user();
        $existingReport = DutyReport::where('event_id', $dutyId)
            ->where(function ($q) use ($student) {
                $q->where('user_id', $student->user_id)
                  ->orWhere('plv_student_id', $student->plv_student_id);
            })->first();

        // Which participants have submitted reports for this duty
        $reportedParticipantIds = DutyReport::where('event_id', $dutyId)
            ->pluck('participant_id')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        return view('member.member-teamleader', [
            'duty' => $duty,
            'teamLeader' => $teamLeader,
            'dutyTitle' => $duty->title ?? 'Duty Report',
            'existingReport' => $existingReport,
            'reportedParticipants' => $reportedParticipantIds,
        ]);
    }

    /**
     * History view for team leader (read-only, no submit/create buttons)
     */
    public function history($dutyId)
    {
        // Reuse index logic but return a read-only history view
        $duty = EventDuty::with('participants')->findOrFail($dutyId);
        $teamLeader = $duty->participants->firstWhere('is_team_leader', true);

        $student = Auth::guard('student')->user();
        $existingReport = DutyReport::where('event_id', $dutyId)
            ->where(function ($q) use ($student) {
                $q->where('user_id', $student->user_id)
                  ->orWhere('plv_student_id', $student->plv_student_id);
            })->first();

        $reportedParticipantIds = DutyReport::where('event_id', $dutyId)
            ->pluck('participant_id')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        return view('member.member-teamleader', [
            'duty' => $duty,
            'teamLeader' => $teamLeader,
            'dutyTitle' => $duty->title ?? 'Duty Report',
            'existingReport' => $existingReport,
            'reportedParticipants' => $reportedParticipantIds,
            'historyMode' => true,
            'backRoute' => route('member.duty-history')
        ]);
    }

    public function submitForReview($dutyId)
    {
        // Get the duty with all necessary relations
        $duty = EventDuty::with('participants')->findOrFail($dutyId);
        $student = Auth::guard('student')->user();
        
        // Check if current user matches team leader in multiple ways
        $isTeamLeader = false;
        
        // First check: Direct match with team_leader_name
        if ($duty->team_leader_name) {
            $studentFullName = trim($student->first_name . ' ' . $student->last_name);
            if (strtolower($duty->team_leader_name) === strtolower($studentFullName)) {
                $isTeamLeader = true;
            }
        }
        
        // Second check: Through participants table
        if (!$isTeamLeader) {
            $isTeamLeader = $duty->participants()
                ->where('plv_student_id', $student->plv_student_id)
                ->where('is_team_leader', true)
                ->exists();
        }

        // Third check: Match by name in participants
        if (!$isTeamLeader) {
            $studentFullName = trim($student->first_name . ' ' . $student->last_name);
            $isTeamLeader = $duty->participants()
                ->where(function($query) use ($studentFullName) {
                    $query->whereRaw("LOWER(CONCAT(first_name, ' ', last_name)) = ?", [strtolower($studentFullName)])
                        ->where('is_team_leader', true);
                })
                ->exists();
        }

        if (!$isTeamLeader) {
            return response()->json([
                'success' => false,
                'message' => 'Only the assigned team leader can submit this duty for review'
            ], 403);
        }

        // Update duty status to CERTIFIED when team leader submits
        $duty->status = 'CERTIFIED';
        $duty->save();

        return response()->json([
            'success' => true,
            'message' => 'Duty has been submitted for review'
        ]);
    }
}