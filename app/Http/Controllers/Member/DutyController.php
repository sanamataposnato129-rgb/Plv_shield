<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventDuty;
use App\Models\Participant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DutyController extends Controller
{
    public function index()
    {
        try {
            $student = Auth::guard('student')->user();

            // Get all IN_PROGRESS duties where the current student is registered
            $duties = EventDuty::where('status', 'IN_PROGRESS')
                ->whereExists(function ($query) use ($student) {
                    $query->select(DB::raw(1))
                        ->from('Participants')
                        ->whereColumn('Participants.event_id', 'Event_Duty.event_id')
                        ->where('Participants.user_id', $student->user_id);
                })
                ->orderBy('duty_date', 'asc')
                ->orderBy('start_time', 'asc')
                ->get();

            foreach ($duties as $duty) {
                $duty->registered_count = $duty->participants()->count();
                
                // Get team leader info and check if current user is team leader
                $teamLeader = Participant::where('event_id', $duty->event_id)
                    ->where('team_leader', 1)
                    ->first();

                if ($teamLeader) {
                    $duty->team_leader_name = $teamLeader->first_name . ' ' . $teamLeader->last_name;
                    // Consider both user_id and plv_student_id matches (some participants may have null user_id)
                    $isUserMatch = isset($teamLeader->user_id) && $teamLeader->user_id == $student->user_id;
                    $isPlvMatch = isset($teamLeader->plv_student_id) && isset($student->plv_student_id) && $teamLeader->plv_student_id == $student->plv_student_id;
                    $duty->is_team_leader = $isUserMatch || $isPlvMatch;
                } else {
                    $duty->is_team_leader = false;
                }

                // Fallback checks: match by duty.team_leader_name (some setups store TL on duty) or student flag
                if (empty($duty->is_team_leader)) {
                    // Check Event_Duty.team_leader_name if present and matches student's full name
                    $studentFull = trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? ''));
                    if (!empty($duty->team_leader_name) && strcasecmp(trim($duty->team_leader_name), $studentFull) === 0) {
                        $duty->is_team_leader = true;
                    }

                    // Some executions may set a flag on the student model (is_team_leader) — respect it
                    if (empty($duty->is_team_leader) && isset($student->is_team_leader) && $student->is_team_leader) {
                        $duty->is_team_leader = true;
                    }
                }
            }

            return view('member.member-duties', compact('duties'));
        } catch (\Exception $e) {
            \Log::error('Error fetching member duties: ' . $e->getMessage());
            return view('member.member-duties', [
                'duties' => collect([]),
                'error' => 'Unable to fetch duties at this time. Please try again later.'
            ]);
        }
    }

    /**
     * Show duty history for the current student (CERTIFIED or COMPLETED)
     */
    public function history()
    {
        try {
            $student = Auth::guard('student')->user();

            // Get duties with status CERTIFIED or COMPLETED where the current student is registered
            $duties = EventDuty::whereIn('status', ['CERTIFIED', 'COMPLETED'])
                ->whereExists(function ($query) use ($student) {
                    $query->select(DB::raw(1))
                        ->from('Participants')
                        ->whereColumn('Participants.event_id', 'Event_Duty.event_id')
                        ->where('Participants.user_id', $student->user_id);
                })
                ->orderBy('duty_date', 'asc')
                ->orderBy('start_time', 'asc')
                ->get();

            foreach ($duties as $duty) {
                $duty->registered_count = $duty->participants()->count();

                $teamLeader = Participant::where('event_id', $duty->event_id)
                    ->where('team_leader', 1)
                    ->first();

                if ($teamLeader) {
                    $duty->team_leader_name = $teamLeader->first_name . ' ' . $teamLeader->last_name;
                    $isUserMatch = isset($teamLeader->user_id) && $teamLeader->user_id == $student->user_id;
                    $isPlvMatch = isset($teamLeader->plv_student_id) && isset($student->plv_student_id) && $teamLeader->plv_student_id == $student->plv_student_id;
                    $duty->is_team_leader = $isUserMatch || $isPlvMatch;
                } else {
                    $duty->is_team_leader = false;
                }

                if (empty($duty->is_team_leader)) {
                    $studentFull = trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? ''));
                    if (!empty($duty->team_leader_name) && strcasecmp(trim($duty->team_leader_name), $studentFull) === 0) {
                        $duty->is_team_leader = true;
                    }

                    if (empty($duty->is_team_leader) && isset($student->is_team_leader) && $student->is_team_leader) {
                        $duty->is_team_leader = true;
                    }
                }
            }

            return view('member.member-duty-history', compact('duties'));
        } catch (\Exception $e) {
            \Log::error('Error fetching member duty history: ' . $e->getMessage());
            return view('member.member-duty-history', [
                'duties' => collect([]),
                'error' => 'Unable to fetch duty history at this time. Please try again later.'
            ]);
        }
    }
}