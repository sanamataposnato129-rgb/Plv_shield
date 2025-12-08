<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventDuty;
use App\Models\Participant;
use Illuminate\Support\Facades\DB;

class DutyRegistrationController extends Controller
{
    // Register student for duty
    public function register(Request $request, $event_id)
    {
        $student = auth('student')->user();
        if (!$student) {
            return redirect()->route('student.login');
        }

        DB::beginTransaction();
        try {
            $duty = EventDuty::findOrFail($event_id);

            // Check if already registered
            $exists = Participant::where('event_id', $duty->event_id)
                ->where('user_id', $student->user_id)
                ->exists();

            if ($exists) {
                return back()->with('info', 'You are already registered for this duty.');
            }

            // Create participant record in duty DB
            $participant = Participant::create([
                'event_id' => $duty->event_id,
                'user_id' => $student->user_id,
                'plv_student_id' => $student->plv_student_id,
                'email' => $student->email,
                'first_name' => $student->first_name,
                'last_name' => $student->last_name,
            ]);

            // After adding, count registered participants
            $current = Participant::where('event_id', $duty->event_id)->count();

            // If reached capacity, update duty status to IN_PROGRESS
            if ($duty->number_of_participants && $current >= $duty->number_of_participants) {
                $duty->status = 'IN_PROGRESS';
                $duty->save();
            }

            DB::commit();

            return back()->with('success', 'Registered successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Registration error: ' . $e->getMessage());
            return back()->with('error', 'Could not register: ' . $e->getMessage());
        }
    }

    // Cancel registration
    public function cancel(Request $request, $event_id)
    {
        $student = auth('student')->user();
        if (!$student) {
            return redirect()->route('student.login');
        }

        DB::beginTransaction();
        try {
            $duty = EventDuty::findOrFail($event_id);

            $participant = Participant::where('event_id', $duty->event_id)
                ->where('user_id', $student->user_id)
                ->first();

            if (!$participant) {
                return back()->with('info', 'You are not registered for this duty.');
            }

            $participant->delete();

            // After deletion, if duty was IN_PROGRESS and now below capacity, set back to OPEN
            $current = Participant::where('event_id', $duty->event_id)->count();
            if ($duty->status === 'IN_PROGRESS' && $duty->number_of_participants && $current < $duty->number_of_participants) {
                $duty->status = 'OPEN';
                $duty->save();
            }

            DB::commit();
            return back()->with('success', 'Registration cancelled.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Cancel registration error: ' . $e->getMessage());
            return back()->with('error', 'Could not cancel registration: ' . $e->getMessage());
        }
    }
}
