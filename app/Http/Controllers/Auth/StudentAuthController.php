<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('student-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Find student by student ID or email
        $student = Student::where('plv_student_id', $request->username)
            ->orWhere('email', $request->username)
            ->first();

        // Add logs to help debug authentication issues
        if (!$student) {
            Log::warning('Student login failed - user not found', ['username' => $request->username]);
            return redirect()->back()
                ->withInput()
                ->withErrors(['username' => 'Invalid credentials or account not approved.']);
        }

        if (!Hash::check($request->password, $student->password_hash)) {
            Log::warning('Student login failed - incorrect password', ['username' => $request->username, 'student_id' => $student->plv_student_id]);
            return redirect()->back()
                ->withInput()
                ->withErrors(['username' => 'Invalid credentials or account not approved.']);
        }

        // Log in the student using student guard
        Auth::guard('student')->login($student, $request->remember);

        // Regenerate session to prevent fixation and ensure session is persisted
        $request->session()->regenerate();

        // Quick session write/read test to detect issues with the session driver
        try {
            $request->session()->put('student_test_logged_in', true);
            $sessionCheck = $request->session()->get('student_test_logged_in', false);
            if (!$sessionCheck) {
                Log::warning('Session write/read test failed after student login. SESSION_DRIVER may be misconfigured.', ['driver' => config('session.driver')]);
            } else {
                Log::info('Session write/read test passed after student login.', ['driver' => config('session.driver'), 'session_id' => $request->session()->getId()]);
            }
        } catch (\Exception $e) {
            Log::error('Exception during session write/read test after student login: ' . $e->getMessage());
        }

        // Update last login timestamp
        DB::table('Student')
            ->where('user_id', $student->user_id)
            ->update(['last_login' => now()]);

    Log::info('Student logged in successfully', ['user_id' => $student->user_id, 'plv_student_id' => $student->plv_student_id]);

    // After login, redirect students to their profile page
    return redirect()->route('member.profile');
    }

    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}