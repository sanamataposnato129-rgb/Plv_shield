<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Allow login by username OR email
        $loginValue = $request->input('username');

        $admin = Admin::where(function ($q) use ($loginValue) {
            $q->where('username', $loginValue)
              ->orWhere('email', $loginValue);
        })->first();

        // Add debug logging to trace login issues without recording sensitive data
        Log::info('Admin login attempt', ['login' => $loginValue, 'admin_found' => (bool)$admin]);

        if (!$admin) {
            Log::warning('Admin not found for login', ['login' => $loginValue]);
            return redirect()->back()
                ->withInput()
                ->withErrors(['username' => 'Invalid credentials.']);
        }

        $passwordMatches = Hash::check($request->password, $admin->password_hash);
        Log::info('Admin password check', ['login' => $loginValue, 'password_matches' => $passwordMatches]);

        if (!$passwordMatches) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['username' => 'Invalid credentials.']);
        }

        // Regenerate session to prevent fixation before login
        $request->session()->regenerate();

        // Log in the admin using admin guard
        Auth::guard('admin')->login($admin, $request->remember);

        // Update last login
        DB::table('Admin')
            ->where('admin_id', $admin->admin_id)
            ->update(['last_login' => now()]);

        // Redirect based on admin type (be lenient to variations like 'Super Admin')
        $adminType = strtolower(str_replace([' ', '-', '_'], '', $admin->admin_type ?? ''));
        if (strpos($adminType, 'super') !== false) {
            return redirect()->route('super-admin.dashboard');
        }

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}