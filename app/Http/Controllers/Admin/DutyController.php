<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventDuty;

class DutyController extends Controller
{
    // List and search duties
    public function index(Request $request)
    {
        try {
            $query = EventDuty::query();

            $search = $request->get('search');
            $status = $request->get('status');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('event_id', $search);
                });
            }

            if ($status) {
                $query->where('status', strtoupper($status));
            }

            $duties = $query->orderBy('duty_date', 'desc')->paginate(25)->withQueryString();

            // Attach registered participant counts to each duty for display (registered/required)
            try {
                $dutyIds = $duties->pluck('event_id')->toArray();
                $counts = [];
                if (!empty($dutyIds)) {
                    $countsRaw = \App\Models\Participant::whereIn('event_id', $dutyIds)
                        ->select('event_id', \DB::raw('COUNT(*) as cnt'))
                        ->groupBy('event_id')
                        ->get();
                    foreach ($countsRaw as $c) {
                        $counts[$c->event_id] = $c->cnt;
                    }
                }

                foreach ($duties as $d) {
                    $d->registered_count = $counts[$d->event_id] ?? 0;
                }
            } catch (\Exception $ex) {
                \Log::debug('Could not attach registered participant counts: ' . $ex->getMessage());
                foreach ($duties as $d) { $d->registered_count = 0; }
            }

            return view('admin.create-duties', compact('duties', 'search', 'status'));
        } catch (\Exception $e) {
            // Catch any exception when querying the duty database (connection issues, missing table, etc.)
            \Log::error('DutyController@index error: ' . $e->getMessage());

            // Build an empty LengthAwarePaginator fallback so the view can render safely
            $emptyPaginator = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 25, 1, [
                'path' => \Illuminate\Support\Facades\URL::current(),
                'query' => $request->query(),
            ]);

            return view('admin.create-duties', [
                'duties' => $emptyPaginator,
                'search' => $request->get('search'),
                'status' => $request->get('status'),
                'error' => 'Duty database unavailable: ' . $e->getMessage(),
            ]);
        }
    }

    // Store new duty
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'title' => 'required|string|max:100',
                'description' => 'required|string',
                'duty_date' => 'required|date|after_or_equal:today',
                'start_time' => 'required',
                'end_time' => 'required',
                'number_of_participants' => 'nullable|integer|min:0',
                'status' => 'nullable|in:OPEN,IN_PROGRESS,UNDER_REVIEW,CERTIFIED,COMPLETED,CANCELLED',
            ]);

            // default status OPEN if not provided
            $data['status'] = $data['status'] ?? 'OPEN';

            // Test connection before trying to create
            if (!\DB::connection('duty')->getPdo()) {
                throw new \Exception('Could not connect to duty database');
            }

            // Create the duty record
            $duty = new EventDuty();
            $duty->title = $data['title'];
            $duty->description = $data['description'];
            $duty->duty_date = $data['duty_date'];
            $duty->start_time = $data['start_time'];
            $duty->end_time = $data['end_time'];
            $duty->number_of_participants = $data['number_of_participants'];
            $duty->status = $data['status'];
            $duty->save();

            return redirect()->route('admin.create-duties')
                           ->with('success', 'Duty created successfully.');
        } catch (\Exception $e) {
            \Log::error('Error creating duty: ' . $e->getMessage());
            return redirect()->route('admin.create-duties')
                           ->with('error', 'Could not create duty. Error: ' . $e->getMessage())
                           ->withInput();
        }
    }

    // Edit form
    public function edit($id)
    {
        $duty = EventDuty::findOrFail($id);
        // Ensure duty_date is formatted as Y-m-d for the date input
        if ($duty->duty_date) {
            $duty->duty_date = \Carbon\Carbon::parse($duty->duty_date)->format('Y-m-d');
        }
        return view('admin.edit-duty', compact('duty'));
    }

    // Update duty
    public function update(Request $request, $id)
    {
        try {
            $duty = EventDuty::findOrFail($id);

            $data = $request->validate([
                'title' => 'required|string|max:100',
                'description' => 'required|string',
                'duty_date' => 'required|date|after_or_equal:today',
                'start_time' => 'required',
                'end_time' => 'required',
                'number_of_participants' => 'nullable|integer|min:0',
                'status' => 'required|in:OPEN,IN_PROGRESS,UNDER_REVIEW,CERTIFIED,COMPLETED,CANCELLED'
            ]);

            $duty->update($data);

            return redirect()->route('admin.create-duties')
                         ->with('success', 'Duty updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Error updating duty: ' . $e->getMessage());
            return back()->with('error', 'Could not update duty: ' . $e->getMessage())->withInput();
        }
    }
    
        // Delete duty
        public function destroy($id)
        {
            $duty = EventDuty::findOrFail($id);
            $duty->delete();
            return redirect()->route('admin.create-duties')->with('success', 'Duty deleted.');
        }

    /**
     * Display duties available for members
     */
    public function memberAnnouncements()
    {
        try {
            // Auto-update duties that have ended: IN_PROGRESS -> UNDER_REVIEW when end datetime passed
            try {
                $now = now()->format('Y-m-d H:i:s');
                EventDuty::where('status', 'IN_PROGRESS')
                    ->whereRaw("CONCAT(duty_date, ' ', end_time) < ?", [$now])
                    ->update(['status' => 'UNDER_REVIEW', 'completed_at' => $now]);
            } catch (\Exception $ex) {
                \Log::debug('Could not auto-update ended duties: ' . $ex->getMessage());
            }
                        // Only show duties that are OPEN for registration on member announcements
                        $duties = EventDuty::where('status', 'OPEN')
                ->orderBy('duty_date', 'asc')
                ->orderBy('start_time', 'asc')
                ->paginate(10);

            // Attach current registration counts and whether the authenticated student is registered
            $userId = auth('student')->id();
            $dutyIds = $duties->pluck('event_id')->toArray();
            $counts = [];
            $registered = [];
            if (!empty($dutyIds)) {
                // Use the duty DB connection to count participants
                $countsRaw = \App\Models\Participant::whereIn('event_id', $dutyIds)
                    ->select('event_id', \DB::raw('COUNT(*) as cnt'))
                    ->groupBy('event_id')
                    ->get();
                foreach ($countsRaw as $c) {
                    $counts[$c->event_id] = $c->cnt;
                }

                if ($userId) {
                    $registeredRaw = \App\Models\Participant::whereIn('event_id', $dutyIds)
                        ->where('user_id', $userId)
                        ->pluck('event_id')
                        ->toArray();
                    foreach ($registeredRaw as $eid) { $registered[$eid] = true; }
                }
            }

            // Attach counts and registered status to each duty (for view convenience)
            foreach ($duties as $d) {
                $d->registered_count = $counts[$d->event_id] ?? 0;
                $d->is_registered = ($registered[$d->event_id] ?? false);
            }

            return view('member.member-announcement', compact('duties'));
        } catch (\Exception $e) {
            \Log::error('Error fetching member announcements: ' . $e->getMessage());
            return view('member.member-announcement', [
                'duties' => collect([]),
                'error' => 'Unable to fetch duties at this time. Please try again later.'
            ]);
        }
    }

    /**
     * Apply for a duty
     */
    public function apply(EventDuty $duty)
    {
        try {
            if ($duty->status !== 'OPEN') {
                return back()->with('error', 'This duty is no longer open for applications.');
            }

            // Add your application logic here
            // For example, create a DutyApplication record

            return back()->with('success', 'Successfully applied for duty.');
        } catch (\Exception $e) {
            \Log::error('Error applying for duty: ' . $e->getMessage());
            return back()->with('error', 'Unable to process your application. Please try again later.');
        }
    }

    /**
     * Show duties that are currently in progress for admin view.
     * This returns a paginator of duties with status IN_PROGRESS and passes to admin.in-progress view.
     */
    public function inProgress(Request $request)
    {
        try {
            // Match variations like 'In Progress', 'IN PROGRESS', or 'IN_PROGRESS'
            $duties = EventDuty::whereRaw("UPPER(REPLACE(status, ' ', '_')) = ?", ['IN_PROGRESS'])
                ->with('participants')
                ->orderBy('duty_date', 'desc')
                ->paginate(25)
                ->withQueryString();

            return view('admin.in-progress', compact('duties'));
        } catch (\Exception $e) {
            \Log::error('DutyController@inProgress error: ' . $e->getMessage());

            $emptyPaginator = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 25, 1, [
                'path' => \Illuminate\Support\Facades\URL::current(),
                'query' => $request->query(),
            ]);

            return view('admin.in-progress', [
                'duties' => $emptyPaginator,
                'error' => 'Unable to fetch in-progress duties: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Show participants for a specific duty as a full page (keeps modal intact on the in-progress view).
     */
    public function participants($id)
    {
        $duty = EventDuty::with('participants')->findOrFail($id);

        // Load registered student accounts to allow immediate client-side search/add,
        // but exclude students already registered for this duty to prevent duplicates.
        try {
            // collect plv ids already registered for this duty
            $existingPlvs = $duty->participants->pluck('plv_student_id')->filter()->unique()->values()->all();

            $query = \App\Models\Student::select('user_id as id', 'plv_student_id', 'first_name', 'last_name', 'email')
                ->orderBy('last_name');

            if (!empty($existingPlvs)) {
                $query->whereNotIn('plv_student_id', $existingPlvs);
            }

            $registeredMembers = $query->get();
        } catch (\Exception $e) {
            \Log::debug('Could not load registered members for participants view: ' . $e->getMessage());
            $registeredMembers = collect([]);
        }

        return view('admin.participants', compact('duty', 'registeredMembers'));
    }

    /**
     * Add a participant to a duty or update participant details.
     * This handles POST requests to the participants page.
     */
    public function addOrUpdateParticipant(Request $request, $id)
    {
        try {
            $duty = EventDuty::findOrFail($id);
            
            // Validate participant data
            $validated = $request->validate([
                'plv_student_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email'
            ]);

            // Find the corresponding student record to get user_id
            $student = \App\Models\Student::where('plv_student_id', $validated['plv_student_id'])->first();
            if (!$student) {
                return back()->with('error', 'Student record not found for PLV ID: ' . $validated['plv_student_id']);
            }

            // Check if participant already exists
            $exists = \App\Models\Participant::where('event_id', $duty->event_id)
                ->where(function($query) use ($student) {
                    $query->where('user_id', $student->user_id)
                        ->orWhere('plv_student_id', $student->plv_student_id);
                })
                ->exists();

            if ($exists) {
                return back()->with('info', 'Student is already registered for this duty.');
            }

            // Create new participant with user_id
            $participant = new \App\Models\Participant;
            $participant->event_id = $duty->event_id; // Use duty's event_id
            $participant->user_id = $student->user_id; // Use student's user_id from Student table
            $participant->plv_student_id = $student->plv_student_id;
            $participant->first_name = $student->first_name;
            $participant->last_name = $student->last_name;
            $participant->email = $student->email;
            $participant->save();

            // Log participant creation for debugging
            \Log::info("Created participant for duty {$duty->event_id}", [
                'duty_id' => $duty->event_id,
                'user_id' => $student->user_id,
                'plv_student_id' => $student->plv_student_id
            ]);

            // Check if we need to update duty status
            $currentCount = \App\Models\Participant::where('event_id', $duty->event_id)->count();
            if ($duty->status === 'OPEN' && $currentCount >= $duty->number_of_participants) {
                $duty->status = 'IN_PROGRESS';
                $duty->save();
            }

            return back()->with('success', 'Participant added successfully.');
        } catch (\Exception $e) {
            \Log::error("Error adding participant to duty {$id}: " . $e->getMessage());
            return back()->with('error', 'Could not add participant: ' . $e->getMessage())
                        ->withInput();
        }
    }

    /**
     * Persist the selected participant as team leader for the duty.
     * This method is defensive: it catches DB errors and returns a friendly message
     * so missing duty DB tables or connection issues do not surface as uncaught exceptions.
     */
    public function setTeamLeader(Request $request, $id)
    {
        $request->validate([
            'selected_participant' => 'required'
        ]);

        try {
            $duty = EventDuty::findOrFail($id);

            // Try to resolve the participant from the duty DB
            $participantId = $request->input('selected_participant');
            $participant = \App\Models\Participant::where('participant_id', $participantId)
                ->orWhere('plv_student_id', $participantId)
                ->first();

            if (!$participant) {
                return back()->with('error', 'Selected participant not found.');
            }

            $tlName = trim(($participant->first_name ?? '') . ' ' . ($participant->last_name ?? '')) ?: ($participant->name ?? $participant->email ?? '');

            // Attempt to set a team leader field on the duty. Wrap in try/catch because
            // the Event_Duty schema may differ between environments.
            try {
                // Prefer an explicit column if available
                if (array_key_exists('team_leader_name', $duty->getAttributes()) || property_exists($duty, 'team_leader_name')) {
                    $duty->team_leader_name = $tlName;
                } else {
                    // Fallback: attempt to set attribute anyway (may fail on save)
                    $duty->team_leader_name = $tlName;
                }
                $duty->save();

                // Optionally mark the participant as team_leader in Duty_Registrations if exists
                try {
                    \DB::connection('duty')->table('Duty_Registrations')
                        ->where('event_id', $duty->{$duty->getKeyName()} ?? $duty->event_id)
                        ->update(['team_leader' => 0]);
                    \DB::connection('duty')->table('Duty_Registrations')
                        ->where('event_id', $duty->{$duty->getKeyName()} ?? $duty->event_id)
                        ->where(function($q) use ($participant, $participantId) {
                            $q->where('student_id', $participant->participant_id ?? 0)
                              ->orWhere('student_id', $participant->plv_student_id ?? 0);
                        })
                        ->update(['team_leader' => 1]);
                } catch (\Exception $ex) {
                    // Log and continue — the Duty_Registrations table may not exist in some dev DBs
                    \Log::debug('Could not update Duty_Registrations: ' . $ex->getMessage());
                }

                // Also set team_leader on Participants table if column exists
                try {
                    if (\Schema::connection('duty')->hasTable('Participants')) {
                        if (\Schema::connection('duty')->hasColumn('Participants', 'team_leader')) {
                            \App\Models\Participant::where('event_id', $duty->{$duty->getKeyName()} ?? $duty->event_id)->update(['team_leader' => 0]);
                            $p = \App\Models\Participant::where(function($q) use ($participant, $participantId){
                                $q->where('participant_id', $participant->participant_id ?? 0)
                                  ->orWhere('plv_student_id', $participant->plv_student_id ?? 0);
                            })->first();
                            if ($p) { $p->team_leader = 1; $p->save(); }
                        }
                    }
                } catch (\Exception $ex) {
                    \Log::debug('Could not update Participants.team_leader: ' . $ex->getMessage());
                }

                return back()->with('success', 'Team leader updated successfully.');
            } catch (\Exception $e) {
                \Log::error('Error saving duty team leader: ' . $e->getMessage());
                return back()->with('error', 'Could not save team leader: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            \Log::error('setTeamLeader error: ' . $e->getMessage());
            return back()->with('error', 'Unable to set team leader at this time.');
        }
    }

    /**
     * Remove a participant from a duty (DELETE).
     */
    public function removeParticipant(Request $request, $dutyId, $participantId)
    {
        try {
            // Find the participant record in the duty DB by participant_id or plv_student_id
            $participant = \App\Models\Participant::where('participant_id', $participantId)
                ->orWhere('plv_student_id', $participantId)
                ->first();

            if (!$participant) {
                return back()->with('error', 'Participant not found.');
            }

            // Only delete if belongs to the duty requested
            if (($participant->event_id ?? null) != $dutyId) {
                return back()->with('error', 'Participant does not belong to this duty.');
            }

            try {
                $participant->delete();
            } catch (\Exception $ex) {
                // If delete fails, try direct DB delete
                try {
                    \DB::connection('duty')->table('Participants')
                        ->where('participant_id', $participant->participant_id ?? 0)
                        ->orWhere('plv_student_id', $participant->plv_student_id ?? '')
                        ->delete();
                } catch (\Exception $e) {
                    \Log::error('Could not delete participant: ' . $e->getMessage());
                    return back()->with('error', 'Could not remove participant.');
                }
            }

            // Also clear any Duty_Registrations entries for this participant
            try {
                \DB::connection('duty')->table('Duty_Registrations')
                    ->where('event_id', $dutyId)
                    ->where(function($q) use ($participant){
                        $q->where('student_id', $participant->participant_id ?? 0)
                          ->orWhere('student_id', $participant->plv_student_id ?? 0);
                    })
                    ->delete();
            } catch (\Exception $ex) {
                \Log::debug('Could not delete Duty_Registrations row: ' . $ex->getMessage());
            }

            // If the removed participant was the team leader, clear the team's leader on the duty
            try {
                $duty = EventDuty::find($dutyId);
                if ($duty) {
                    $participantFull = trim(($participant->first_name ?? '') . ' ' . ($participant->last_name ?? '')) ?: ($participant->name ?? '');
                    $isTl = false;
                    if (!empty($duty->team_leader_name) && strcasecmp(trim($duty->team_leader_name), $participantFull) === 0) {
                        $isTl = true;
                    }
                    if (!$isTl && isset($participant->team_leader) && $participant->team_leader) {
                        $isTl = true;
                    }

                    if ($isTl) {
                        // Clear the duty's team leader name
                        try {
                            $duty->team_leader_name = null;
                            $duty->save();
                        } catch (\Exception $ex) {
                            \Log::debug('Could not clear duty team_leader_name: ' . $ex->getMessage());
                        }

                        // Also clear Duty_Registrations.team_leader flags and Participants.team_leader if present
                        try {
                            \DB::connection('duty')->table('Duty_Registrations')
                                ->where('event_id', $dutyId)
                                ->update(['team_leader' => 0]);
                        } catch (\Exception $ex) {
                            \Log::debug('Could not clear Duty_Registrations.team_leader: ' . $ex->getMessage());
                        }

                        try {
                            if (\Schema::connection('duty')->hasTable('Participants') && \Schema::connection('duty')->hasColumn('Participants', 'team_leader')) {
                                \DB::connection('duty')->table('Participants')
                                    ->where('event_id', $dutyId)
                                    ->update(['team_leader' => 0]);
                            }
                        } catch (\Exception $ex) {
                            \Log::debug('Could not clear Participants.team_leader: ' . $ex->getMessage());
                        }
                    }
                }
            } catch (\Exception $ex) {
                \Log::debug('Error while checking/clearing team leader on participant removal: ' . $ex->getMessage());
            }

            return back()->with('success', 'Participant removed.');
        } catch (\Exception $e) {
            \Log::error('removeParticipant error: ' . $e->getMessage());
            return back()->with('error', 'Could not remove participant at this time.');
        }
    }
}
