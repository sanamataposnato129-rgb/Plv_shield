@extends('layouts.admin')

@section('title', 'Students')

@section('styles')
<style>
    /* Content wrapper to adjust for layout */
    .content-area {
        flex: 1;
        padding: 30px;
    }

    .admin-container {
        background: transparent;
        border-radius: 0;
        padding: 0;
        box-shadow: none;
    }
    
    /* Professional styling */
    .admin-header {
        background: white;
        padding: 24px;
        border-radius: 8px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .admin-header h2 {
        font-size: 24px;
        font-weight: 700;
        color: #000066;
        margin: 0;
    }

    .search-container {
        background: white;
        padding: 16px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
    }

    .search-input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
    }

    .search-input:focus {
        outline: none;
        border-color: #000066;
        box-shadow: 0 0 0 3px rgba(0, 0, 102, 0.1);
    }

    .search-buttons {
        margin-top: 12px;
        display: flex;
        gap: 10px;
    }

    .btn-search {
        background: #000066;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .btn-search:hover {
        background: #000080;
        box-shadow: 0 4px 12px rgba(0, 0, 102, 0.3);
        transform: translateY(-2px);
    }

    .btn-reset {
        background: white;
        color: #000066;
        border: 1px solid #000066;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-reset:hover {
        background: #000066;
        color: white;
    }

    .students-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .students-table th {
        background: linear-gradient(135deg, #000066, #191970);
        color: #FFD700;
        padding: 16px;
        text-align: left;
        font-weight: 700;
        font-size: 14px;
        letter-spacing: 0.3px;
    }

    .students-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #f0f0f0;
        font-size: 14px;
    }

    .students-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .students-table tbody tr:hover {
        background-color: rgba(0, 0, 102, 0.04);
    }

    .no-students {
        text-align: center;
        padding: 24px;
        color: #666;
        font-size: 14px;
    }

    .btn-action {
        padding: 8px 14px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        font-size: 12px;
        transition: all 0.2s ease;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background: #c82333;
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
    }

    .btn-info {
        background: #17a2b8;
        color: white;
    }

    .btn-info:hover {
        background: #138496;
        box-shadow: 0 2px 8px rgba(23, 162, 184, 0.3);
    }

    .alert {
        padding: 12px 16px;
        border-radius: 6px;
        margin-bottom: 20px;
        border: none;
        font-weight: 500;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
    }

    /* MOBILE RESPONSIVE: Only enable horizontal scroll, keep desktop table layout and sizing */
    @media (max-width: 768px) {
        .sidebar {
            display: none !important;
        }
        .students-table {
            display: block !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
            white-space: nowrap !important;
        }
        .students-table table,
        .students-table thead,
        .students-table tbody {
            display: table !important;
            width: auto !important;
        }
        .students-table tr { display: table-row !important; }
        .students-table th,
        .students-table td { display: table-cell !important; white-space: nowrap !important; }
        .students-table thead { display: table-header-group !important; }
        .students-table td:before { content: none !important; display: none !important; }
        .students-table table { min-width: 700px !important; }
    }
    @media (max-width: 480px) {
        .students-table table { min-width: 600px !important; }
    }
</style>
@endsection

<style>
    /* Mobile-only adjustments and animations for Students view (no desktop layout changes) */
    @media (max-width: 768px) {
        /* reduce the vertical gap below header so title is closer */
        .admin-header { margin-bottom: 8px !important; padding: 16px !important; }

        /* center header text */
        .admin-header h2 { text-align: center !important; width: 100%; }

        /* center search and buttons */
        .search-container { text-align: center !important; padding: 12px !important; }
        .search-buttons { justify-content: center !important; }

        /* make table cells center-aligned for clarity on small screens */
        .students-table th, .students-table td { text-align: center !important; }

        /* Actions: stack buttons vertically and center */
        .students-table td[data-label="Actions"] { display:flex !important; flex-direction:column; gap:8px; align-items:center; justify-content:center; }
        .students-table td[data-label="Actions"] .btn-action { width: 92% !important; max-width: 320px; }

        /* tighten spacing above the table for mobile */
        .search-container { margin-bottom: 8px !important; }
    }

    /* Button animations (works on desktop too but doesn't change layout) */
    .btn-action { transition: transform .12s cubic-bezier(.2,.8,.2,1), box-shadow .12s ease, background-color .12s ease; }
    .btn-action:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(11,44,105,0.08); }
    .btn-action:active { transform: translateY(0); }

    /* Resend overlay styling + animation */
    #resendOverlay { display: none; position: fixed; inset: 0; align-items: center; justify-content: center; background: rgba(6,12,45,0.45); backdrop-filter: blur(3px); z-index: 1200; }
    #resendOverlay .resend-panel { background:#fff; border-radius:10px; padding:18px; max-width:420px; width:92%; box-shadow:0 18px 40px rgba(2,6,23,0.12); transform: translateY(10px) scale(.995); opacity:0; transition: transform .2s cubic-bezier(.2,.8,.2,1), opacity .2s ease; }
    #resendOverlay.open { display:flex; }
    #resendOverlay.open .resend-panel { transform: translateY(0) scale(1); opacity:1; }

    /* Small ripple on popup buttons for tactile feel */
    .btn-primary, .btn-secondary { transition: transform .12s ease, box-shadow .12s ease; }
    .btn-primary:active, .btn-secondary:active { transform: translateY(1px) scale(.995); }
</style>

<style>
    /* Mobile-only: keep desktop layout unchanged. Prevent stacked labels and enable horizontal scroll. */
    @media (max-width: 768px) {
        .students-table {
            display: block !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
            white-space: nowrap !important;
        }

        .students-table table,
        .students-table thead,
        .students-table tbody {
            display: table !important;
            width: auto !important;
        }

        .students-table tr { display: table-row !important; }
        .students-table th,
        .students-table td { display: table-cell !important; white-space: nowrap !important; }

        /* Remove per-cell label pseudo-elements that add extra text in stacked mobile mode */
        .students-table td:before { content: none !important; display: none !important; }
        .students-table thead { display: table-header-group !important; }

        /* Ensure a minimum width so horizontal scrolling is enabled instead of squeezing columns */
        .students-table table { min-width: 700px !important; }
    }

    @media (max-width: 480px) {
        .students-table table { min-width: 600px !important; }
    }
</style>

<!-- Page-load entrance animation and popup for Students view -->
<style>
    /* small entrance animation for header and table */
    .admin-header { transform: translateY(6px); opacity: 0; transition: transform .28s cubic-bezier(.2,.8,.2,1), opacity .28s ease; }
    .admin-header.page-loaded { transform: translateY(0); opacity: 1; }

    .students-table { transform: translateY(6px); opacity: 0; transition: transform .36s cubic-bezier(.2,.8,.2,1), opacity .36s ease; }
    .students-table.page-loaded { transform: translateY(0); opacity: 1; }

    /* keyframe used by multiple entrance effects */
    @keyframes fadeInUpSmall { from { transform: translateY(8px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

    /* utility class for fade-in-up with preserved layout (used by rows and small panels) */
    .fade-in-up { opacity: 0; transform: translateY(8px); will-change: transform, opacity; animation: fadeInUpSmall .36s cubic-bezier(.2,.8,.2,1) both; }

    /* rows get an inline animation-delay to create a staggered entrance */
    .staggered-row { display: table-row; }

    /* small page popup */
    .students-page-popup { position: fixed; inset: auto 16px 16px auto; z-index: 1200; display:none; }
    .students-page-popup .panel { background:#fff;padding:12px 14px;border-radius:10px;box-shadow:0 18px 40px rgba(2,6,23,0.12);transform:translateY(8px);opacity:0;transition:transform .22s ease,opacity .22s ease; }
    .students-page-popup.show { display:block; }
    .students-page-popup.show .panel { transform:translateY(0); opacity:1; }

    /* search container and pagination subtle fade */
    .search-container.fade-in { animation: fadeInUpSmall .28s cubic-bezier(.2,.8,.2,1) both; }
    .pagination.fade-in { animation: fadeInUpSmall .28s cubic-bezier(.2,.8,.2,1) both; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hdr = document.querySelector('.admin-header');
        const table = document.querySelector('.students-table');
        if (hdr) setTimeout(() => hdr.classList.add('page-loaded'), 60);
        if (table) setTimeout(() => table.classList.add('page-loaded'), 120);

        // animate search container
        const search = document.querySelector('.search-container');
        if (search) setTimeout(() => search.classList.add('fade-in'), 90);

        // stagger in table rows for a pleasant entrance (non-destructive: only adds classes)
        const rows = document.querySelectorAll('.students-table tbody tr');
        rows.forEach((row, i) => {
            row.classList.add('fade-in-up', 'staggered-row');
            row.style.animationDelay = (120 + i * 45) + 'ms';
        });

        // small, non-blocking page popup that auto-dismisses
        const popup = document.createElement('div');
        popup.className = 'students-page-popup';
        popup.innerHTML = '<div class="panel">Students — quick actions available.</div>';
        document.body.appendChild(popup);
        setTimeout(() => popup.classList.add('show'), 140);
        setTimeout(() => { popup.classList.remove('show'); setTimeout(() => popup.remove(), 220); }, 3000);

        // animate pagination if present
        const pag = document.querySelector('.pagination');
        if (pag) setTimeout(() => pag.classList.add('fade-in'), 400);
    });
</script>

<style>
    /* Mobile-only: align each table column clearly on small screens without affecting desktop */
    @media (max-width: 768px) {
        .students-table th,
        .students-table td { vertical-align: middle !important; }

        /* Student ID: left */
        .students-table th:nth-child(1),
        .students-table td:nth-child(1) { text-align: left !important; padding-left: 12px !important; }

        /* Name: left */
        .students-table th:nth-child(2),
        .students-table td:nth-child(2) { text-align: left !important; }

        /* Email: left and allow wrapping within cell width if needed */
        .students-table th:nth-child(3),
        .students-table td:nth-child(3) { text-align: left !important; max-width: 220px; overflow-wrap: anywhere; }

        /* Created At: center */
        .students-table th:nth-child(4),
        .students-table td:nth-child(4) { text-align: center !important; }

        /* Actions: right (keeps buttons grouped) */
        .students-table th:nth-child(5),
        .students-table td:nth-child(5) { text-align: right !important; padding-right: 12px !important; }
    }

    @media (max-width: 480px) {
        .students-table th:nth-child(1), .students-table td:nth-child(1) { padding-left: 8px !important; }
        .students-table th:nth-child(5), .students-table td:nth-child(5) { padding-right: 8px !important; }
    }
</style>

<style>
    /* Stronger mobile-only alignment rules targeting tbody cells to ensure content aligns with headers */
    @media (max-width: 768px) {
        .students-table tbody td:nth-child(2),
        .students-table td:nth-child(2) {
            text-align: left !important;
            padding-left: 12px !important;
        }

        .students-table tbody td:nth-child(3),
        .students-table td:nth-child(3) {
            text-align: left !important;
            max-width: 240px !important;
            overflow-wrap: anywhere !important;
        }

        .students-table tbody td:nth-child(4),
        .students-table td:nth-child(4) {
            text-align: center !important;
        }

        .students-table tbody td:nth-child(5),
        .students-table td:nth-child(5) {
            text-align: right !important;
            padding-right: 12px !important;
        }

        /* Ensure action buttons stay grouped on the right */
        .students-table tbody td:nth-child(5) .btn-action {
            float: right !important;
            display: inline-block !important;
        }
    }

    @media (max-width: 480px) {
        .students-table tbody td:nth-child(3) { max-width: 200px !important; }
        .students-table tbody td:nth-child(5) .btn-action { float: right !important; }
    }
</style>

    <!-- Mobile: force real table layout and enable horizontal scrolling only; keeps desktop unchanged -->
    <style>
        @media (max-width: 768px) {
            .students-table {
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch;
                white-space: nowrap !important;
            }

            .students-table table { width: auto !important; }
            .students-table thead { display: table-header-group !important; }
            .students-table tbody { display: table-row-group !important; }
            .students-table tr { display: table-row !important; }
            .students-table th,
            .students-table td { display: table-cell !important; white-space: nowrap !important; }
        }
    </style>

@section('content')
<style>
    /* Mobile alignment: ensure th and td paddings and widths match so headers align with data */
    @media (max-width: 768px) {
        .students-table th,
        .students-table td {
            padding: 10px 12px !important;
            box-sizing: border-box !important;
            vertical-align: middle !important;
        }

        /* Explicit column widths on small screens to keep header/data alignment stable */
        .students-table th:nth-child(1), .students-table td:nth-child(1) { width: 120px !important; min-width: 120px !important; }
        .students-table th:nth-child(2), .students-table td:nth-child(2) { width: 260px !important; min-width: 260px !important; }
        .students-table th:nth-child(3), .students-table td:nth-child(3) { width: 320px !important; min-width: 320px !important; }
        .students-table th:nth-child(4), .students-table td:nth-child(4) { width: 150px !important; min-width: 150px !important; }
        .students-table th:nth-child(5), .students-table td:nth-child(5) { width: 180px !important; min-width: 180px !important; }

        /* Make sure the overall table doesn't collapse; allow horizontal scrolling */
        .students-table { white-space: nowrap !important; }
        .students-table table { min-width: calc(120px + 260px + 320px + 150px + 180px) !important; }
    }
</style>
<div class="admin-header">
    <h2>Students</h2>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<div class="search-container">
    <form method="GET" action="{{ route('admin.students.index') }}">
        <input class="search-input" type="text" name="search" value="{{ request('search', $search ?? '') }}" placeholder="Search by name, student ID or email">
        <div class="search-buttons">
            <button type="submit" class="btn-search">Search</button>
            <a href="{{ route('admin.students.index') }}" class="btn-reset">Reset</a>
        </div>
    </form>
</div>

<table class="students-table">
    <thead>
        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($students as $student)
            <tr>
                <td data-label="Student ID">{{ $student->plv_student_id }}</td>
                <td data-label="Name">{{ $student->first_name }} {{ $student->last_name }}</td>
                <td data-label="Email">{{ $student->email }}</td>
                <td data-label="Created At">{{ $student->created_at->format('M d, Y') }}</td>
                <td data-label="Actions">
                    <form method="POST" action="{{ route('admin.students.resend', $student->user_id) }}" style="display:inline-block;">
                        @csrf
                        <button type="submit" class="btn-action btn-info" onclick="return confirm('Resend account approval email to {{ $student->email }}?')">
                            <i class="fas fa-paper-plane me-1"></i> Resend Email
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.students.destroy', $student->user_id) }}" style="display:inline-block; margin-left:8px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-danger" onclick="return confirm('Delete student {{ addslashes($student->plv_student_id) }} - this action cannot be undone.')">
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="no-students">No students found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

@if($students->hasPages())
    <div class="pagination">
        {{ $students->links() }}
    </div>
@endif

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const resendBtns = document.querySelectorAll('.resend-btn');
    const overlay = document.createElement('div');
    overlay.id = 'resendOverlay';
    overlay.style.position = 'fixed';
    overlay.style.inset = '0';
    overlay.style.display = 'none';
    overlay.style.alignItems = 'center';
    overlay.style.justifyContent = 'center';
    overlay.style.background = 'rgba(0,0,0,0.35)';
    overlay.style.backdropFilter = 'blur(4px)';
    overlay.style.zIndex = '1100';

    overlay.innerHTML = `
        <div class="resend-panel" style="background:#fff;padding:20px;border-radius:8px;max-width:420px;width:90%;box-shadow:0 10px 30px rgba(0,0,0,0.25);">
            <h3 style="margin-top:0;margin-bottom:8px;">Confirm resend</h3>
            <p style="margin-bottom:12px;">Send approval email to <strong id="resendEmailText"></strong>?</p>
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button id="cancelResend" style="background:#6c757d;color:#fff;border:none;padding:8px 12px;border-radius:6px;">Cancel</button>
                <button id="confirmResend" style="background:#1a4d2e;color:#fff;border:none;padding:8px 12px;border-radius:6px;">Send</button>
            </div>
        </div>`;

    document.body.appendChild(overlay);

    // hidden form used to POST resend (contains CSRF token)
    const hiddenForm = document.createElement('form');
    hiddenForm.id = 'resendForm';
    hiddenForm.method = 'POST';
    hiddenForm.style.display = 'none';
    hiddenForm.innerHTML = `@csrf`;
    document.body.appendChild(hiddenForm);

    let currentAction = null;

    resendBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const email = this.dataset.email;
            document.getElementById('resendEmailText').textContent = email;
            // build action: /admin/students/{id}/resend
            currentAction = "{{ url('admin/students') }}" + '/' + id + '/resend';
            overlay.style.display = 'flex';
            overlay.classList.add('open');
        });
    });

    const cancel = document.getElementById('cancelResend');
    const confirm = document.getElementById('confirmResend');

    if (cancel) cancel.addEventListener('click', function () {
        const el = document.getElementById('resendOverlay');
        if (el) el.classList.remove('open');
        setTimeout(() => { const e = document.getElementById('resendOverlay'); if (e) e.style.display = 'none'; }, 180);
    });

    if (confirm) confirm.addEventListener('click', function () {
        if (!currentAction) return;
        const f = document.getElementById('resendForm');
        f.action = currentAction;
        f.submit();
    });
});
</script>
@endsection

<!-- Final small overrides to ensure mobile centering wins over earlier column-specific rules -->
<style>
    @media (max-width: 768px) {
        .admin-header { margin-bottom: 8px !important; }
        .admin-header h2 { text-align:center !important; }
        .search-container { margin-bottom: 8px !important; }
        .students-table th, .students-table td { text-align: center !important; }
        .students-table td[data-label="Actions"] { text-align: center !important; display:flex !important; flex-direction:column !important; gap:8px !important; align-items:center !important; }
        .students-table td[data-label="Actions"] .btn-action { width:92% !important; height:44px !important; font-size:14px !important; display:inline-flex !important; align-items:center !important; justify-content:center !important; }
        /* Ensure icon + text spacing is consistent */
        .students-table td[data-label="Actions"] .btn-action i { margin-right: 8px; }
        /* Slightly larger tappable area on very small screens */
        @media (max-width: 420px) {
            .students-table td[data-label="Actions"] .btn-action { width:96% !important; }
        }
    }
</style>
