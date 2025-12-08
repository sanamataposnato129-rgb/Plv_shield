<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'username' => ['required', 'string', 'max:100', Rule::unique('Admin')->ignore($admin->admin_id, 'admin_id')],
            'email' => ['required', 'string', 'email', 'max:100', Rule::unique('Admin')->ignore($admin->admin_id, 'admin_id')],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $admin->first_name = $request->first_name;
        $admin->last_name = $request->last_name;
        $admin->username = $request->username;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password_hash = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('super-admin.dashboard')
            ->with('success', 'Profile updated successfully.');
    }
}