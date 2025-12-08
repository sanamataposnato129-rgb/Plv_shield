<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\StudentAuthController;
use App\Http\Controllers\Auth\AdminAuthController;

use App\Http\Controllers\Admin\DutyController;

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// Provide a generic 'login' route used by some views (redirects to login choice)
Route::get('/login', function () {
    return redirect()->route('login.choice');
})->name('login');

// Temporary DB test route
Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        $result = DB::select('SELECT COUNT(*) as count FROM Account_Request');
        return "Database connected successfully. Account_Request count: " . $result[0]->count;
    } catch (\Exception $e) {
        return "Database error: " . $e->getMessage();
    }
});

// Temporary development-only route to trigger certificate send without admin auth.
// Only enabled when APP_ENV=local. REMOVE this in production.
if (app()->environment('local')) {
    Route::get('/dev/release-certificate/{duty}/{participant}', function ($duty, $participant) {
        // Use the controller method to keep behavior identical
        $controller = app(\App\Http\Controllers\Admin\ViewReportsController::class);
        // Call the releaseCertificate method; it will attempt to send the email and return a redirect.
        return $controller->releaseCertificate($duty, $participant);
    })->name('dev.release-certificate');
}

// Login choice page
Route::get('/login-choice', function () {
    return view('login-choice');
})->name('login.choice');

// Student Routes
Route::get('/student/login', [StudentAuthController::class, 'showLoginForm'])->name('student.login');
Route::post('/student/login', [StudentAuthController::class, 'login'])->name('student.login.submit');
Route::post('/student/logout', [StudentAuthController::class, 'logout'])->name('student.logout');

// Admin Routes
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');


// Member Announcement Routes
Route::get('/member/announcements', [DutyController::class, 'memberAnnouncements'])
    ->name('member.announcements')
    ->middleware('auth:student');

// Duty Application Route
Route::post('/duties/{duty}/apply', [DutyController::class, 'apply'])
    ->name('duties.apply')
    ->middleware('auth:student');

// Member Team Leader Route
Route::get('/member/teamleader/{duty_id?}', [App\Http\Controllers\Member\TeamLeaderController::class, 'index'])
    ->name('member.teamleader')
    ->middleware('auth:student');
// Member Team Leader - History (read-only)
Route::get('/member/teamleader-history/{duty_id?}', [App\Http\Controllers\Member\TeamLeaderController::class, 'history'])
    ->name('member.teamleader.history')
    ->middleware('auth:student');

// Member Report Route
Route::get('/member/report/{duty_id?}', [App\Http\Controllers\Member\ReportController::class, 'index'])
    ->name('member.report')
    ->middleware('auth:student');
// Member Report - History (read-only)
Route::get('/member/report-history/{duty_id?}', [App\Http\Controllers\Member\ReportController::class, 'history'])
    ->name('member.report.history')
    ->middleware('auth:student');

// Registration Routes
Route::get('/signup', [RegistrationController::class, 'showSignupForm'])->name('signup');
Route::post('/register', [RegistrationController::class, 'register'])->name('register');

// Pending Approval Page
Route::get('/pending-approval', function () {
    if (!session('success')) {
        return redirect('/');
    }
    return view('pending-approval');
})->name('pending.approval');

// Pending Approval Page
Route::get('/pending-approval', function () {
    if (!session('success')) {
        return redirect('/');
    }
    return view('pending-approval');
})->name('pending.approval');

// Pending Approval Page
Route::get('/pending-approval', function () {
    if (!session('success')) {
        return redirect('/signup');
    }
    return view('pending-approval');
})->name('pending.approval');

// Dashboard Routes (Protected - handled inside admin group)

// Admin pages (converted from static HTML) - protected by admin guard
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    // Role-aware dashboard: admins -> admin dashboard, superadmins -> super-admin dashboard
    Route::get('/dashboard', function () {
        $admin = auth('admin')->user();
        if (!$admin) {
            return redirect()->route('admin.login');
        }

        // Normalize admin_type and check for 'super' to handle variations like 'Super Admin'
        $adminType = strtolower(str_replace([' ', '-', '_'], '', $admin->admin_type ?? ''));
        if (strpos($adminType, 'super') !== false) {
            return redirect()->route('super-admin.dashboard');
        }

        return view('admin.admin-dashboard');
    })->name('dashboard');

    Route::get('/approvals', [App\Http\Controllers\Admin\ApprovalController::class, 'index'])->name('approvals');
    Route::post('/approvals/{id}/approve', [App\Http\Controllers\Admin\ApprovalController::class, 'approve'])->name('approvals.approve');
    Route::post('/approvals/{id}/reject', [App\Http\Controllers\Admin\ApprovalController::class, 'reject'])->name('approvals.reject');
    
    // Student management
    Route::get('/students', [App\Http\Controllers\Admin\StudentController::class, 'index'])->name('students.index');
    Route::delete('/students/{id}', [App\Http\Controllers\Admin\StudentController::class, 'destroy'])->name('students.destroy');
    Route::post('/students/{id}/resend', [App\Http\Controllers\Admin\StudentController::class, 'resendApprovalEmail'])->name('students.resend');
    // Admin profile update (own profile)
    Route::put('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    // Admin duties management (uses DutyController)
    Route::get('/create-duties', [App\Http\Controllers\Admin\DutyController::class, 'index'])->name('create-duties');
    Route::post('/duties', [App\Http\Controllers\Admin\DutyController::class, 'store'])->name('duties.store');
    Route::get('/duties/{id}/edit', [App\Http\Controllers\Admin\DutyController::class, 'edit'])->name('duties.edit');
    Route::put('/duties/{id}', [App\Http\Controllers\Admin\DutyController::class, 'update'])->name('duties.update');
    Route::delete('/duties/{id}', [App\Http\Controllers\Admin\DutyController::class, 'destroy'])->name('duties.destroy');
    Route::get('/in-progress', [App\Http\Controllers\Admin\DutyController::class, 'inProgress'])->name('in-progress');
    // Participants page for a duty (new full page view, keeps existing modal intact)
    Route::get('/duties/{id}/participants', [App\Http\Controllers\Admin\DutyController::class, 'participants'])->name('duties.participants');
    // Add/update participant in a duty
    Route::post('/duties/{id}/participants', [App\Http\Controllers\Admin\DutyController::class, 'addOrUpdateParticipant'])->name('duties.participants.add');
    // Set team leader action (POST)
    Route::post('/duties/{id}/set-team-leader', [App\Http\Controllers\Admin\DutyController::class, 'setTeamLeader'])->name('duties.set_tl');
    // Remove participant from a duty
    Route::delete('/duties/{duty}/participants/{participant}', [App\Http\Controllers\Admin\DutyController::class, 'removeParticipant'])->name('duties.participants.remove');
    // Reports routes
    Route::get('/view-reports', [App\Http\Controllers\Admin\ViewReportsController::class, 'index'])->name('view-reports');
    Route::post('/reports/{id}/approve', [App\Http\Controllers\Admin\ViewReportsController::class, 'approve'])->name('reports.approve');
    Route::post('/reports/{id}/reject', [App\Http\Controllers\Admin\ViewReportsController::class, 'reject'])->name('reports.reject');
    Route::get('/reports/{id}', [App\Http\Controllers\Admin\ViewReportsController::class, 'show'])->name('reports.show');
    Route::post('/reports/{id}/complete', [App\Http\Controllers\Admin\ViewReportsController::class, 'markComplete'])->name('reports.complete');
    Route::get('/reports/{duty}/participants/{participant}', [App\Http\Controllers\Admin\ViewReportsController::class, 'participantReport'])->name('reports.participant.report');
    Route::post('/reports/{duty}/participants/{participant}/certificate', [App\Http\Controllers\Admin\ViewReportsController::class, 'releaseCertificate'])->name('reports.certificate');
    // Secure download route for generated certificates (serves file through Laravel)
    Route::get('/reports/{duty}/participants/{participant}/certificate/download', [App\Http\Controllers\Admin\ViewReportsController::class, 'downloadCertificate'])->name('reports.certificate.download');
    Route::get('/history', [App\Http\Controllers\Admin\ViewReportsController::class, 'history'])->name('history');
    Route::get('/history/{id}', [App\Http\Controllers\Admin\ViewReportsController::class, 'historyShow'])->name('history.show');
});

// Super admin routes (views under resources/views/super-admin)
Route::prefix('super-admin')->name('super-admin.')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('super-admin.dashboard');
    })->name('dashboard');

    // Profile management
    Route::put('/profile', [App\Http\Controllers\SuperAdmin\ProfileController::class, 'update'])->name('profile.update');

    // Manage admins UI
    Route::get('/manage-admins', [App\Http\Controllers\SuperAdmin\AdminManagementController::class, 'index'])->name('manage-admins');

    // Manage admins actions
    Route::post('/manage-admins', [App\Http\Controllers\SuperAdmin\AdminManagementController::class, 'store'])->name('manage-admins.store');
    Route::delete('/manage-admins/{id}', [App\Http\Controllers\SuperAdmin\AdminManagementController::class, 'destroy'])->name('manage-admins.destroy');
    // AJAX checks for availability
    Route::get('/manage-admins/check-email', [App\Http\Controllers\SuperAdmin\AdminManagementController::class, 'checkEmail'])->name('manage-admins.checkEmail');
    Route::get('/manage-admins/check-username', [App\Http\Controllers\SuperAdmin\AdminManagementController::class, 'checkUsername'])->name('manage-admins.checkUsername');
});

// Member pages (protected by student guard)
Route::prefix('member')->name('member.')->middleware('auth:student')->group(function () {
    // Dashboard route removed — redirect to profile instead
    Route::get('/dashboard', function () { return redirect()->route('member.profile'); })->name('dashboard');
    Route::get('/duties', [App\Http\Controllers\Member\DutyController::class, 'index'])->name('duties');
    Route::get('/announcement', [App\Http\Controllers\Admin\DutyController::class, 'memberAnnouncements'])->name('announcement');
    // Registration actions (register / cancel)
    Route::post('/duties/{duty}/register', [App\Http\Controllers\Member\DutyRegistrationController::class, 'register'])->name('duties.register');
    Route::post('/duties/{duty}/cancel', [App\Http\Controllers\Member\DutyRegistrationController::class, 'cancel'])->name('duties.cancel');
    Route::get('/duty-history', [App\Http\Controllers\Member\DutyController::class, 'history'])->name('duty-history');
    Route::get('/profile', [App\Http\Controllers\Member\ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\Member\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/team-leader', function () { return view('member.team-leader'); })->name('team-leader');
    // Submit duty for review (AJAX)
    Route::post('/teamleader/{dutyId}/submit', [App\Http\Controllers\Member\TeamLeaderController::class, 'submitForReview'])->name('teamleader.submit');
    // View a single participant's report (AJAX for team leader to view member reports)
    Route::get('/report/participant/{participant}', [App\Http\Controllers\Member\ReportController::class, 'showParticipant'])->name('report.participant.show');
    Route::post('/report/store', [App\Http\Controllers\Member\ReportController::class, 'store'])->name('report.store');
});