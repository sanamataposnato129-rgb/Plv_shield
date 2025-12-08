<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLV-SHIELD | Approvals</title>
    <link rel="stylesheet" href="{{ asset('css/admin/admin-dashboard.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Ensure hamburger only visible on small screens for this view */
        .hamburger { display: none !important; }
        @media (max-width: 768px) {
            .hamburger { display: flex !important; align-items: center !important; justify-content: center !important; }
        }
    </style>
    <style>
        /* Professional floating flash/modal */
        .flash-overlay {
            position: fixed;
            inset: 0; /* top/right/bottom/left: 0 */
            background: rgba(6,12,45,0.55);
            backdrop-filter: blur(4px);
            display: none; /* toggled by JS */
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 24px;
        }

        .flash-modal {
            background: #ffffff;
            border-radius: 12px;
            max-width: 720px;
            width: 100%;
            box-shadow: 0 24px 48px rgba(15,23,42,0.35);
            overflow: hidden;
            transform: translateY(-8px);
            opacity: 0;
            transition: transform .18s ease, opacity .18s ease;
            border-left: 8px solid #ffd200; /* accent color */
        }

        .flash-modal.open { transform: translateY(0); opacity: 1; }

        .flash-header {
            display:flex;
            align-items:center;
            gap:12px;
            padding:16px 20px;
            background: linear-gradient(90deg,#0d1b66,#15124a);
            color: #ffd200;
        }

        .flash-header .title { font-weight:700; font-size:18px; }

        .flash-body { padding:18px 20px 16px 20px; color:#111827; font-size:15px; }

        .flash-footer { padding:12px 20px 18px 20px; display:flex; justify-content:flex-end; gap:8px; }

        .btn-primary {
            background: #ffd200; color:#0b1a3a; border:none; padding:10px 14px; border-radius:8px; cursor:pointer; font-weight:600;
        }

        .btn-secondary { background:#6b1f1f; color:#fff; border:none; padding:10px 14px; border-radius:8px; cursor:pointer; }

        @media (max-width:640px) {
            .flash-modal { max-width: 92%; }
        }
        /* HEADER */
        .approvals-header {
            background: linear-gradient(to right, #000066, #191970);
            color: #FFD700;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            font-weight: bold;
            padding: 18px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Approval list cards */
        .approval-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            background: #fff;
            border: 1px solid #e6eef6;
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 12px;
            box-shadow: 0 6px 18px rgba(2,6,23,0.04);
        }

        .member-info { display:flex; gap:14px; align-items:center; }
        .member-avatar { width:64px; height:64px; border-radius:8px; object-fit:cover; background:#f8fafc; padding:8px; }
        .member-details h3 { margin:0; color:#0b2c69; font-size:16px; }
        .member-details p { margin:4px 0; color:#475569; font-size:13px; }

        .action-buttons { display:flex; gap:10px; align-items:center; width: 100%; }
        .approve-btn { background:#0b2c69; color:#fff; border:none; padding:10px 14px; border-radius:8px; cursor:pointer; font-weight:700; flex: 1; }
        .approve-btn:hover { background:#0d3a7a; }
        .reject-btn { background:transparent; color:#b91c1c; border:2px solid rgba(185,28,28,0.12); padding:8px 12px; border-radius:8px; cursor:pointer; font-weight:700; flex: 1; }

        .no-requests { text-align:center; padding:26px; color:#6b7280; background:#fff; border-radius:8px; border:1px solid #e6eef6; }

        .pending-title { color:#0b2c69; font-size:18px; font-weight:600; margin-bottom:16px; }

        /* Mobile responsive styles */
        @media (max-width: 768px) {
            .approval-card {
                padding: 0 !important;
            }
            /* Ensure grid of meta-info stacks on mobile for clearer alignment */
            .approval-card .member-meta-grid {
                grid-template-columns: 1fr !important;
                gap: 8px 8px !important;
            }
            /* Remove any inline min-width on actions column so buttons fill available width */
            .approval-card > div > div:nth-child(3) {
                min-width: unset !important;
                width: 100% !important;
                padding: 12px !important;
                box-sizing: border-box !important;
            }
            /* Make avatars clickable and aligned left on mobile */
            .approval-card .member-avatar { cursor: pointer; }
            .approval-card > div {
                flex-direction: column !important;
                align-items: stretch !important;
            }
            .approval-card .member-avatar {
                width: 56px !important;
                height: 56px !important;
            }
            .approval-card > div > div:nth-child(2) {
                padding: 14px 12px !important;
            }
            .approval-card > div > div:nth-child(3) {
                min-width: unset !important;
                padding: 14px 12px !important;
            }
            .approval-card .approve-btn,
            .approval-card .reject-btn {
                font-size: 14px !important;
                padding: 12px 14px !important;
            }
            .approval-card .approve-btn {
                margin-bottom: 6px !important;
            }
            .approval-card .member-details h3,
            .approval-card .member-details div {
                font-size: 15px !important;
            }
            .approvals-header {
                font-size: 20px;
                padding: 14px 16px;
                margin-bottom: 16px;
            }
        }

        @media (max-width: 480px) {
            .approval-card {
                padding: 12px 14px;
                margin-bottom: 10px;
            }

            .member-avatar {
                width: 48px;
                height: 48px;
                padding: 6px;
            }

            .member-details h3 {
                font-size: 14px;
            }

            .member-details p {
                font-size: 11px;
            }

            .approve-btn,
            .reject-btn {
                padding: 10px 12px;
                font-size: 13px;
                flex: 1;
            }

            .approvals-header {
                font-size: 18px;
                padding: 12px 14px;
            }

            .pending-title {
                font-size: 16px;
                margin-bottom: 12px;
            }
        }

        /* Animations for cards and modals - won't change desktop layout */
        .approval-card { animation: fadeInUp .36s ease both; }
        .approve-btn, .reject-btn { transition: transform .14s ease, box-shadow .14s ease; }
        .approve-btn:active, .reject-btn:active { transform: translateY(1px) scale(.997); }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Profile overlay (temporary student profile) */
        .profile-overlay { display: none; position: fixed; inset: 0; background: rgba(6,12,45,0.52); backdrop-filter: blur(3px); align-items: center; justify-content: center; z-index: 10000; padding: 20px; }
        .profile-panel { background:#fff; border-radius:12px; max-width:520px; width:100%; box-shadow:0 18px 40px rgba(2,6,23,0.18); transform: translateY(6px); opacity:0; transition: transform .18s ease, opacity .18s ease; }
        .profile-panel.open { transform: translateY(0); opacity:1; }
        .profile-body { padding:18px 20px; display:flex; gap:16px; align-items:flex-start; }
        .profile-body img { width:84px; height:84px; border-radius:10px; object-fit:cover; background:#f8fafc; }
        .profile-meta h4 { margin:0 0 6px 0; color:#0b2c69; }
        .profile-meta p { margin:4px 0; color:#475569; font-size:14px; }
        .profile-actions { padding:12px 18px; display:flex; gap:8px; justify-content:flex-end; }
        @media (max-width:480px) { .profile-body { flex-direction:column; align-items:stretch; } .profile-body img { width:64px; height:64px; } }

    </style>
</head>
<body>
    <div class="container">
        <!-- HAMBURGER BUTTON -->
        <button class="hamburger" id="hamburgerBtn" aria-label="Open Menu">
            <svg width="28" height="28" viewBox="0 0 100 100">
                <rect width="80" height="12" x="10" y="20" rx="6" fill="#FFD700"></rect>
                <rect width="80" height="12" x="10" y="44" rx="6" fill="#FFD700"></rect>
                <rect width="80" height="12" x="10" y="68" rx="6" fill="#FFD700"></rect>
            </svg>
        </button>

        <!-- MOBILE OVERLAY & SIDEBAR -->
        <div class="mobile-sidebar-overlay" id="mobileOverlay"></div>
        <div class="mobile-sidebar" id="mobileSidebar">
            <h3 class="sidebar-title">Dashboard</h3>
            <ul class="menu">
                <li><a href="{{ route('admin.dashboard') }}" class="menu-link"><img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon">Profile</a></li>
                <li class="active"><a href="{{ route('admin.approvals') }}" class="menu-link"><img src="{{ asset('ASSETS/checkreport-icon.png') }}" class="icon">Approvals</a></li>
                <li><a href="{{ route('admin.students.index') }}" class="menu-link"><img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon">Students</a></li>
                <li><a href="{{ route('admin.create-duties') }}" class="menu-link"><img src="{{ asset('ASSETS/createduty-icon.png') }}" class="icon">Duties</a></li>
                <li><a href="{{ route('admin.in-progress') }}" class="menu-link"><img src="{{ asset('ASSETS/in-progress-icon.png') }}" class="icon">In Progress</a></li>
                <li><a href="{{ route('admin.view-reports') }}" class="menu-link"><img src="{{ asset('ASSETS/viewreport-icon.png') }}" class="icon">View Reports</a></li>
                <li><a href="{{ route('admin.history') }}" class="menu-link"><img src="{{ asset('ASSETS/history-icon.png') }}" class="icon">History</a></li>
            </ul>
            <form method="POST" action="{{ route('admin.logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>

        <!-- HEADER -->
        <header>
            <div class="header-left">
                <img src="{{ asset('ASSETS/shield-logo.png') }}" alt="Logo" class="logo">
                <h1>PLV - SHIELD</h1>
            </div>
        </header>

        <div class="main-content">
            <!-- SIDEBAR -->
            <div class="sidebar">
        <h3 class="sidebar-title">Dashboard</h3>
          <ul class="menu">
          <li><a href="{{ route('admin.dashboard') }}" class="menu-link"><img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon">Profile</a></li>
          <li class="active"><a href="{{ route('admin.approvals') }}" class="menu-link"><img src="{{ asset('ASSETS/checkreport-icon.png') }}" class="icon">Approvals</a></li>
          <li><a href="{{ route('admin.students.index') }}" class="menu-link"><img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon">Students</a></li>
          <li><a href="{{ route('admin.create-duties') }}" class="menu-link"><img src="{{ asset('ASSETS/createduty-icon.png') }}" class="icon">Duties</a></li>
          <li><a href="{{ route('admin.in-progress') }}" class="menu-link"><img src="{{ asset('ASSETS/in-progress-icon.png') }}" class="icon">In Progress</a></li>
          <li><a href="{{ route('admin.view-reports') }}" class="menu-link"><img src="{{ asset('ASSETS/viewreport-icon.png') }}" class="icon">View Reports</a></li>
          <li><a href="{{ route('admin.history') }}" class="menu-link"><img src="{{ asset('ASSETS/history-icon.png') }}" class="icon">History</a></li>
        </ul>

        <form method="POST" action="{{ route('admin.logout') }}" class="logout-form">
          @csrf
          <button type="submit" class="logout-btn">Logout</button>
        </form>
      </div>

        <!-- MAIN CONTENT -->
        <div class="content">
            <!-- Floating flash modal (success / error) -->
            <div id="flashOverlay" class="flash-overlay" aria-hidden="true">
                <div id="flashModal" class="flash-modal" role="dialog" aria-modal="true" aria-labelledby="flashTitle">
                    <div class="flash-header">
                        <div class="title" id="flashTitle">{{ session('success') ? 'Success' : ($errors->any() ? 'Notice' : '') }}</div>
                        <div style="margin-left:auto; font-size:13px; opacity:.9; color:#fff">PLV-SHIELD</div>
                    </div>
                    <div class="flash-body">
                        @if(session('success'))
                            <p id="flashMessage">{{ session('success') }}</p>
                        @elseif($errors->any())
                            <p id="flashMessage">{{ $errors->first() }}</p>
                        @else
                            <p id="flashMessage"></p>
                        @endif
                    </div>
                    <div class="flash-footer">
                        <button id="flashClose" class="btn-primary">OK</button>
                    </div>
                </div>

                    <!-- Temporary Profile overlay (opened when tapping avatar or name) -->
                    <div id="profileOverlay" class="profile-overlay" aria-hidden="true">
                        <div id="profilePanel" class="profile-panel" role="dialog" aria-modal="true" aria-labelledby="profileTitle">
                            <div class="flash-header" style="display:flex;align-items:center;justify-content:space-between;">
                                <div class="title" id="profileTitle">Student Profile</div>
                                <div style="margin-left:auto;font-size:13px;opacity:.9;color:#fff">PLV-SHIELD</div>
                            </div>
                            <div class="profile-body">
                                <img id="profileAvatar" src="{{ asset('ASSETS/profile-icon.png') }}" alt="Avatar">
                                <div class="profile-meta">
                                    <h4 id="profileName">Name</h4>
                                    <p id="profileEmail"><strong>Email:</strong> —</p>
                                    <p id="profileStudentId"><strong>PLV Student ID:</strong> —</p>
                                    <p id="profileApplied"><strong>Date Applied:</strong> —</p>
                                </div>
                            </div>
                            <div class="profile-actions">
                                <button id="closeProfile" class="btn-secondary">Close</button>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="approvals-header">Approvals</div>

            <h3 class="pending-title">Pending Member Approvals</h3>

            <!-- DYNAMIC APPROVAL LIST CONTAINER -->
            <div id="approvalsContainer">
                @forelse($requests as $req)
                <div class="approval-card" style="padding: 0; overflow: hidden;">
                    <div style="display: flex; align-items: stretch; width: 100%;">
                        <div style="background: #f8fafc; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 18px 12px; min-width: 90px;">
                            <img src="{{ asset('ASSETS/profile-icon.png') }}" alt="User" class="member-avatar profile-trigger" style="width:64px; height:64px; border-radius:8px; object-fit:cover; background:#fff;"
                                 data-name="{{ $req->first_name }} {{ $req->last_name }}"
                                 data-email="{{ $req->email }}"
                                 data-id="{{ $req->plv_student_id }}"
                                 data-applied="{{ $req->created_at ? \Carbon\Carbon::parse($req->created_at)->format('M d, Y') : 'N/A' }}">
                        </div>
                        <div style="flex: 1; padding: 18px 24px; display: flex; flex-direction: column; justify-content: center;">
                            <div class="profile-trigger" style="font-size: 18px; font-weight: 700; color: #0b2c69; margin-bottom: 2px;"
                                 data-name="{{ $req->first_name }} {{ $req->last_name }}"
                                 data-email="{{ $req->email }}"
                                 data-id="{{ $req->plv_student_id }}"
                                 data-applied="{{ $req->created_at ? \Carbon\Carbon::parse($req->created_at)->format('M d, Y') : 'N/A' }}">
                                {{ $req->first_name }} {{ $req->last_name }}
                            </div>
                            <div class="member-meta-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px 24px; font-size: 14px; color: #475569; margin-bottom: 8px;">
                                <div><strong>Email:</strong> {{ $req->email }}</div>
                                <div><strong>PLV Student ID:</strong> {{ $req->plv_student_id }}</div>
                                <div><strong>Date Applied:</strong> {{ $req->created_at ? \Carbon\Carbon::parse($req->created_at)->format('M d, Y') : 'N/A' }}</div>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction: column; justify-content: center; align-items: stretch; gap: 8px; min-width: 180px; background: #f9fafb; padding: 18px 16px;">
                            <form method="POST" action="{{ route('admin.approvals.approve', $req->request_id) }}">
                                @csrf
                                <button type="submit" class="approve-btn" style="width: 100%; margin-bottom: 6px;">Grant Access</button>
                            </form>
                            <button class="reject-btn" data-request-id="{{ $req->request_id }}" style="width: 100%;">Reject</button>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="no-requests">There are no pending account requests at this time.</div>
                @endforelse
            </div>

            <!-- Reject modal (floating dialog) -->
            <div id="rejectOverlay" class="flash-overlay" style="display:none;" aria-hidden="true">
                <div id="rejectDialog" class="flash-modal" role="dialog" aria-modal="true" aria-labelledby="rejectTitle">
                    <div class="flash-header">
                        <div class="title" id="rejectTitle">Reject Account Request</div>
                    </div>
                    <div class="flash-body">
                        <p>Please select a reason for rejection (this will be emailed to the applicant):</p>
                        <form id="rejectForm" method="POST" action="">
                            @csrf
                            <input type="hidden" name="reason" id="reasonFinal" value="">
                            <div class="form-group">
                                <select id="rejectReason" required style="width:100%; padding:8px; border-radius:6px; border:1px solid #ddd;">
                                    <option value="">-- Select reason --</option>
                                    <option value="Invalid ID number">Invalid ID number</option>
                                    <option value="Student name does not exist">Student name does not exist</option>
                                    <option value="Email mismatch">Email mismatch</option>
                                    <option value="Other">Other (specify below)</option>
                                </select>
                            </div>
                            <div class="form-group" id="otherReasonGroup" style="display:none;margin-top:8px;">
                                <label>Other reason</label>
                                <textarea id="reasonCustom" rows="3" style="width:100%; padding:8px; border-radius:6px; border:1px solid #ddd;"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="flash-footer">
                        <button type="button" id="rejectCancel" class="btn-secondary">Cancel</button>
                        <button type="submit" form="rejectForm" class="btn-primary">Send Rejection</button>
                    </div>
                </div>
            </div>

            <script>
                // Temporary profile overlay handling (open when avatar or name clicked)
                (function () {
                    const triggers = document.querySelectorAll('.profile-trigger');
                    const overlay = document.getElementById('profileOverlay');
                    const panel = document.getElementById('profilePanel');
                    const closeBtn = document.getElementById('closeProfile');
                    const avatarEl = document.getElementById('profileAvatar');
                    const nameEl = document.getElementById('profileName');
                    const emailEl = document.getElementById('profileEmail');
                    const idEl = document.getElementById('profileStudentId');
                    const appliedEl = document.getElementById('profileApplied');

                    if (!triggers || !overlay) return;

                    function openProfile(data) {
                        if (avatarEl) avatarEl.src = '{{ asset("ASSETS/profile-icon.png") }}';
                        if (nameEl) nameEl.textContent = data.name || 'N/A';
                        if (emailEl) emailEl.innerHTML = '<strong>Email:</strong> ' + (data.email || 'N/A');
                        if (idEl) idEl.innerHTML = '<strong>PLV Student ID:</strong> ' + (data.id || 'N/A');
                        if (appliedEl) appliedEl.innerHTML = '<strong>Date Applied:</strong> ' + (data.applied || 'N/A');
                        overlay.style.display = 'flex';
                        setTimeout(() => panel.classList.add('open'), 20);
                        overlay.setAttribute('aria-hidden', 'false');
                    }

                    function closeProfile() {
                        panel.classList.remove('open');
                        overlay.setAttribute('aria-hidden', 'true');
                        setTimeout(() => { overlay.style.display = 'none'; }, 180);
                    }

                    triggers.forEach(t => {
                        t.addEventListener('click', function () {
                            openProfile({ name: this.dataset.name, email: this.dataset.email, id: this.dataset.id, applied: this.dataset.applied });
                        });
                    });

                    if (closeBtn) closeBtn.addEventListener('click', closeProfile);
                    overlay.addEventListener('click', (ev) => { if (ev.target === overlay) closeProfile(); });
                    document.addEventListener('keydown', (ev) => { if (ev.key === 'Escape' && overlay.style.display === 'flex') closeProfile(); });
                })();

                const rejectButtons = document.querySelectorAll('.reject-btn');
                const rejectOverlay = document.getElementById('rejectOverlay');
                const rejectDialog = document.getElementById('rejectDialog');
                const rejectForm = document.getElementById('rejectForm');
                const rejectReason = document.getElementById('rejectReason');
                const otherReasonGroup = document.getElementById('otherReasonGroup');
                const reasonCustom = document.getElementById('reasonCustom');
                const rejectCancel = document.getElementById('rejectCancel');

                rejectButtons.forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.dataset.requestId;
                        rejectForm.action = `{{ url('admin/approvals') }}/${id}/reject`;
                        // show centered overlay
                        if (rejectOverlay && rejectDialog) {
                            rejectOverlay.style.display = 'flex';
                            rejectDialog.classList.add('open');
                            rejectOverlay.setAttribute('aria-hidden', 'false');
                        }
                    });
                });

                rejectReason.addEventListener('change', () => {
                    if (rejectReason.value === 'Other') {
                        otherReasonGroup.style.display = 'block';
                        reasonCustom.required = true;
                    } else {
                        otherReasonGroup.style.display = 'none';
                        reasonCustom.required = false;
                    }
                });

                // Before submitting reject form, populate hidden 'reason' from select or custom
                rejectForm.addEventListener('submit', (e) => {
                    const selected = rejectReason.value;
                    let finalReason = selected;
                    if (selected === 'Other') {
                        finalReason = reasonCustom.value.trim();
                    }
                    if (!finalReason) {
                        e.preventDefault();
                        alert('Please provide a rejection reason.');
                        return false;
                    }
                    document.getElementById('reasonFinal').value = finalReason;
                });

                rejectCancel.addEventListener('click', () => {
                    if (rejectOverlay && rejectDialog) {
                        rejectDialog.classList.remove('open');
                        rejectOverlay.setAttribute('aria-hidden', 'true');
                        setTimeout(() => { rejectOverlay.style.display = 'none'; }, 180);
                    }
                    rejectForm.action = '';
                });

                // close when clicking outside dialog
                if (rejectOverlay) {
                    rejectOverlay.addEventListener('click', (ev) => {
                        if (ev.target === rejectOverlay) {
                            rejectCancel.click();
                        }
                    });
                }

                // close on ESC
                document.addEventListener('keydown', (ev) => {
                    if (ev.key === 'Escape' && rejectOverlay && rejectOverlay.style.display === 'flex') {
                        rejectCancel.click();
                    }
                });

                // Flash modal handling (floating window)
                (function () {
                    const flashOverlay = document.getElementById('flashOverlay');
                    const flashModal = document.getElementById('flashModal');
                    const flashClose = document.getElementById('flashClose');
                    if (!flashOverlay || !flashModal) return;

                    const msg = document.getElementById('flashMessage')?.textContent?.trim();
                    if (msg && msg.length > 0) {
                        // show
                        flashOverlay.style.display = 'flex';
                        // give modal open animation class after show for smoothness
                        setTimeout(() => flashModal.classList.add('open'), 20);
                        flashOverlay.setAttribute('aria-hidden', 'false');

                        // optional auto-dismiss after 6s (comment out if undesired)
                        // const autoDismiss = setTimeout(() => closeFlash(), 6000);

                        function closeFlash() {
                            flashModal.classList.remove('open');
                            flashOverlay.setAttribute('aria-hidden', 'true');
                            setTimeout(() => { flashOverlay.style.display = 'none'; }, 200);
                            // clearTimeout(autoDismiss);
                        }

                        flashClose?.addEventListener('click', closeFlash);
                        // close when clicking outside modal (but not when clicking inside)
                        flashOverlay.addEventListener('click', (ev) => {
                            if (ev.target === flashOverlay) closeFlash();
                        });
                        // close on ESC
                        document.addEventListener('keydown', (ev) => {
                            if (ev.key === 'Escape') closeFlash();
                        });
                    }
                })();
            </script>
        </div>
    </div>
    </div>

    <!-- HAMBURGER MENU SCRIPT -->
    <script>
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const mobileOverlay = document.getElementById('mobileOverlay');
        const mobileSidebar = document.getElementById('mobileSidebar');

        // Open menu
        hamburgerBtn.addEventListener('click', () => {
            mobileOverlay.classList.add('active');
            mobileSidebar.classList.add('active');
        });

        // Close menu when clicking overlay
        mobileOverlay.addEventListener('click', () => {
            mobileOverlay.classList.remove('active');
            mobileSidebar.classList.remove('active');
        });

        // Close menu when clicking a link
        const menuLinks = mobileSidebar.querySelectorAll('.menu-link');
        menuLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileOverlay.classList.remove('active');
                mobileSidebar.classList.remove('active');
            });
        });

        // Close menu on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                mobileOverlay.classList.remove('active');
                mobileSidebar.classList.remove('active');
            }
        });
    </script>
</body>
</html>
