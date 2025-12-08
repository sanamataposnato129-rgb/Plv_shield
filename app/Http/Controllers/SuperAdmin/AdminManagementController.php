<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Admin;

class AdminManagementController extends Controller
{
    // Show list handled by blade; controller handles actions

    public function store(Request $request)
    {
        $user = Auth::guard('admin')->user();
        if (!$user || strtolower($user->admin_type) !== 'superadmin' && $user->admin_type !== 'SuperAdmin') {
            abort(403);
        }

        // determine actual admin table name from model to avoid hard-coded pluralization issues
        $adminTable = (new Admin())->getTable();

        $data = $request->validate([
            'first_name' => [
                'required',
                'string',
                'max:50',
                function ($attribute, $value, $fail) {
                    if (!preg_match("/^[A-Za-z\\s\\-']+$/u", $value)) {
                        $fail('The ' . str_replace('_', ' ', $attribute) . ' may only contain letters, spaces, hyphens, and apostrophes.');
                    }
                }
            ],
            'last_name' => [
                'required',
                'string',
                'max:50',
                function ($attribute, $value, $fail) {
                    if (!preg_match("/^[A-Za-z\\s\\-']+$/u", $value)) {
                        $fail('The ' . str_replace('_', ' ', $attribute) . ' may only contain letters, spaces, hyphens, and apostrophes.');
                    }
                }
            ],
            'username' => 'required|string|max:100|unique:' . $adminTable . ',username',
            // Allow same email as a Student; only prevent duplicate Admin emails
            'email' => 'required|email|max:100|unique:' . $adminTable . ',email',
        ]);

        // Generate a 13-digit numeric password
        $plainPassword = '';
        for ($i = 0; $i < 13; $i++) {
            $plainPassword .= (string)random_int(0, 9);
        }

        $admin = Admin::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password_hash' => Hash::make($plainPassword),
            'admin_type' => 'Admin'
        ]);

        // Send email to the new admin with the generated password (if mail configured)
        try {
            Mail::to($admin->email)->send(new \App\Mail\AdminCreated($admin, $plainPassword));
        } catch (\Exception $e) {
            // If mail fails, proceed but add a flash message
            return redirect()->route('super-admin.manage-admins')
                ->with('success', 'Admin account created, but sending email failed: ' . $e->getMessage());
        }

        return redirect()->route('super-admin.manage-admins')->with('success', 'Admin account created successfully.');
    }

    /**
     * AJAX: check if an email is already used by Admin or Student
     */
    public function checkEmail(Request $request)
    {
        $email = $request->query('email');
        if (!$email) {
            return response()->json(['exists' => false]);
        }

        // Only consider Admin table for email existence — students may reuse emails
        $existsInAdmin = Admin::whereRaw('LOWER(email) = ?', [strtolower($email)])->exists();
        return response()->json(['exists' => $existsInAdmin]);
    }

    /**
     * AJAX: check if username already exists in Admin
     */
    public function checkUsername(Request $request)
    {
        $username = $request->query('username');
        if (!$username) {
            return response()->json(['exists' => false]);
        }
        $exists = Admin::whereRaw('LOWER(username) = ?', [strtolower($username)])->exists();
        return response()->json(['exists' => $exists]);
    }

    public function index()
    {
        $user = Auth::guard('admin')->user();
        if (!$user || strtolower($user->admin_type) !== 'superadmin' && $user->admin_type !== 'SuperAdmin') {
            abort(403);
        }

        // Exclude SuperAdmin accounts from the listing to avoid accidental deletion
        $admins = Admin::select('admin_id', 'last_name', 'first_name', 'username', 'email', 'created_at', 'admin_type')
            ->whereRaw("LOWER(COALESCE(admin_type, '')) NOT LIKE 'super%'")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('super-admin.manage-admins', compact('admins'));
    }

    public function destroy($id)
    {
        $user = Auth::guard('admin')->user();
        if (!$user || strtolower($user->admin_type) !== 'superadmin' && $user->admin_type !== 'SuperAdmin') {
            abort(403);
        }

        // prevent deleting self
        if ((int)$user->admin_id === (int)$id) {
            return redirect()->route('super-admin.manage-admins')->withErrors(['error' => 'You cannot delete your own account.']);
        }

        $admin = Admin::find($id);
        if (!$admin) {
            return redirect()->route('super-admin.manage-admins')->withErrors(['error' => 'Admin not found.']);
        }

        // prevent deleting other superadmins
        if (strtolower($admin->admin_type) === 'superadmin' || $admin->admin_type === 'SuperAdmin') {
            return redirect()->route('super-admin.manage-admins')->withErrors(['error' => 'Cannot delete SuperAdmin account.']);
        }

        $admin->delete();

        return redirect()->route('super-admin.manage-admins')->with('success', 'Admin deleted successfully.');
    }
}
