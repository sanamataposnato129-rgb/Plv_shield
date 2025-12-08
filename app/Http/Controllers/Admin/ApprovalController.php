<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountRequest;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\AccountApproved;
use App\Mail\AccountRejected;

class ApprovalController extends Controller
{
    public function index()
    {
        try {
            $requests = AccountRequest::where('request_status', 'Pending')
                ->select('request_id', 'plv_student_id', 'email', 'first_name', 'last_name', 'created_at')
                ->orderBy('created_at', 'desc')
                ->get();

            return view('admin.approvals', ['requests' => $requests]);
        } catch (\Exception $e) {
            Log::error('Error fetching approval requests: ' . $e->getMessage());
            return view('admin.approvals', ['requests' => collect([])])
                ->withErrors('Unable to fetch requests. Please try again.');
        }
    }

    public function approve(Request $request, $id)
    {
        $acctReq = AccountRequest::findOrFail($id);

        DB::beginTransaction();
        try {
            // Prevent duplicates
            if (Student::where('plv_student_id', $acctReq->plv_student_id)->exists() || Student::where('email', $acctReq->email)->exists()) {
                return redirect()->route('admin.approvals')->withErrors('A student with this ID or email already exists.');
            }

            // Create student with original request timestamp
            $student = Student::create([
                'plv_student_id' => $acctReq->plv_student_id,
                'email' => $acctReq->email,
                'first_name' => $acctReq->first_name,
                'last_name' => $acctReq->last_name,
                'password_hash' => $acctReq->password_hash,
                'created_at' => $acctReq->created_at,
                'updated_at' => now()
            ]);

            // Delete the request since it's been approved and moved to Students
            $acctReq->delete();

            DB::commit();

            // Send approval email to the student
            try {
                Mail::to($student->email)->send(new AccountApproved($student));
                Log::info('Approval email sent successfully', [
                    'to' => $student->email,
                    'student_id' => $student->plv_student_id,
                    'name' => $student->first_name . ' ' . $student->last_name
                ]);
                return redirect()->route('admin.approvals')->with('success', 'Account approved and welcome email sent to student.');
            } catch (\Exception $emailError) {
                Log::error('Failed to send approval email', [
                    'error' => $emailError->getMessage(),
                    'student_id' => $student->plv_student_id,
                    'email' => $student->email
                ]);
                return redirect()->route('admin.approvals')
                    ->with('success', 'Account approved successfully.')
                    ->with('warning', 'Welcome email could not be sent. Please try resending it from the Students page.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Approval error: ' . $e->getMessage());
            return redirect()->route('admin.approvals')->withErrors('Failed to approve account: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        try {
            $request->validate([
                'reason' => 'required|string|max:500'
            ]);

            $acctReq = AccountRequest::findOrFail($id);
            
            if ($acctReq->request_status !== 'Pending') {
                return redirect()->route('admin.approvals')
                    ->withErrors('This request has already been processed.');
            }

            $acctReq->request_status = 'Rejected';
            $acctReq->reviewed_by = Auth::guard('admin')->id();
            $acctReq->reviewed_at = now();
            $acctReq->save();

            // Send rejection email to the applicant
            try {
                Mail::to($acctReq->email)->send(new AccountRejected($acctReq, $request->input('reason')));
                Log::info('Rejection email sent successfully', [
                    'to' => $acctReq->email,
                    'request_id' => $acctReq->request_id,
                    'name' => $acctReq->first_name . ' ' . $acctReq->last_name
                ]);
                return redirect()->route('admin.approvals')
                    ->with('success', 'Account rejected and notification email sent to applicant.');
            } catch (\Exception $emailError) {
                Log::error('Failed to send rejection email', [
                    'error' => $emailError->getMessage(),
                    'request_id' => $acctReq->request_id,
                    'email' => $acctReq->email
                ]);
                return redirect()->route('admin.approvals')
                    ->with('success', 'Account rejected successfully.')
                    ->with('warning', 'Notification email could not be sent to the applicant.');
            }

        } catch (\Exception $e) {
            Log::error('Rejection error: ' . $e->getMessage());
            return redirect()->route('admin.approvals')
                ->withErrors('Failed to reject account: ' . $e->getMessage());
        }
    }
}
