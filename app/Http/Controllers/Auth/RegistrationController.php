<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AccountRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function showSignupForm()
    {
        return view('signup');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'studentId' => 'required|string|max:20',
            'firstName' => 'required|string|max:50',
            'lastName' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'password' => 'required|string|min:8',
            'confirmPassword' => 'required|same:password'
        ], [
            'confirmPassword.same' => 'The password confirmation does not match.'
        ]);

        // Custom validation for unique student ID and email
        $validator->after(function ($validator) use ($request) {
            $formattedStudentId = $this->formatStudentId($request->studentId);

            // Check if student ID exists in Student table
            $existingStudent = Student::where('plv_student_id', $formattedStudentId)->first();
            // Check if student ID exists in Account_Request table
            $existingRequest = AccountRequest::where('plv_student_id', $formattedStudentId)->first();
            if ($existingStudent || $existingRequest) {
                $validator->errors()->add('studentId', 'An account with this student number already exists or is pending approval.');
            }

            // Check if email exists in Student table
            $existingEmailStudent = Student::where('email', $request->email)->first();
            // Check if email exists in Account_Request table
            $existingEmailRequest = AccountRequest::where('email', $request->email)->first();
            if ($existingEmailStudent || $existingEmailRequest) {
                $validator->errors()->add('email', 'An account with this email already exists or is pending approval.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $formattedStudentId = $this->formatStudentId($request->studentId);

            // Debug: log input and formatted student ID
            \Log::info('Signup attempt', [
                'studentId' => $request->studentId,
                'formattedStudentId' => $formattedStudentId,
                'email' => $request->email,
                'firstName' => $request->firstName,
                'lastName' => $request->lastName
            ]);

            // Create account request
            $created = AccountRequest::create([
                'plv_student_id' => $formattedStudentId,
                'email' => $request->email,
                'first_name' => $request->firstName,
                'last_name' => $request->lastName,
                'password_hash' => Hash::make($request->password)
            ]);

            if (!$created) {
                throw new \Exception('Failed to create account request');
            }

            \Log::info('AccountRequest created', ['id' => $created->id]);

            DB::commit();

            return redirect()->route('pending.approval')
                ->with('success', 'Your account registration is in progress. Please wait for admin approval.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Registration error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['password', 'confirmPassword'])
            ]);
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }

    private function formatStudentId($studentId)
    {
        // Remove any existing dashes or spaces
        $cleanId = preg_replace('/[-\s]/', '', $studentId);
        
        // Format as 2X-XXXX (ensure it's exactly 7 characters: 2X-XXXX)
        if (strlen($cleanId) >= 2) {
            $part1 = substr($cleanId, 0, 2);
            $part2 = substr($cleanId, 2, 4); // Take only 4 digits for the second part
            return $part1 . '-' . $part2;
        }
        
        return $studentId;
    }
}