<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Student;

class ProfileController extends Controller
{
    public function show()
    {
        $student = Auth::guard('student')->user();
        return view('member.member-profile', compact('student'));
    }

    public function update(Request $request)
    {
        $student = Auth::guard('student')->user();
        if (!$student) {
            return redirect()->route('member.profile')->withErrors('Student not authenticated.');
        }

        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:Student,email,' . $student->user_id . ',user_id',
        ]);

        try {
            $student->first_name = $request->input('first_name');
            $student->last_name = $request->input('last_name');
            $student->email = $request->input('email');
            $student->save();

            Log::info('Student profile updated', ['user_id' => $student->user_id]);
            return redirect()->route('member.profile')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update student profile', ['error' => $e->getMessage(), 'user_id' => $student->user_id]);
            return redirect()->route('member.profile')->withErrors('Failed to update profile: ' . $e->getMessage());
        }
    }
}
