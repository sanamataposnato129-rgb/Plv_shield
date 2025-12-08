<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountApproved;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $students = Student::query()
            ->when($search, function ($q) use ($search) {
                $q->where('plv_student_id', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(25)
            ->withQueryString();

        return view('admin.students', compact('students', 'search'));
    }

    public function destroy($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return redirect()->route('admin.students.index')->withErrors('Student not found.');
        }

        try {
            $student->delete();
            Log::info('Student deleted by admin', ['user_id' => $id, 'plv_student_id' => $student->plv_student_id]);
            return redirect()->route('admin.students.index')->with('success', 'Student record deleted.');
        } catch (\Exception $e) {
            Log::error('Failed to delete student', ['error' => $e->getMessage(), 'user_id' => $id]);
            return redirect()->route('admin.students.index')->withErrors('Failed to delete student: ' . $e->getMessage());
        }
    }

    public function resendApprovalEmail($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return redirect()->route('admin.students.index')->withErrors('Student not found.');
        }

        try {
            Mail::to($student->email)->send(new AccountApproved($student));
            Log::info('Resent approval email', ['user_id' => $student->user_id, 'email' => $student->email]);
            return redirect()->route('admin.students.index')->with('success', 'Account approval email resent successfully to ' . $student->email);
        } catch (\Exception $e) {
            Log::error('Failed to resend approval email', ['error' => $e->getMessage(), 'user_id' => $id]);
            return redirect()->route('admin.students.index')->withErrors('Failed to resend email: ' . $e->getMessage());
        }
    }
}
