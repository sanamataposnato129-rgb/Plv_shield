@extends('layouts.admin')

@section('title', 'History Report Details')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/create-duties.css') }}">

<style>
    /* ============================================= */
    /* REUSE YOUR EXISTING FIXED LAYOUT FROM OTHER PAGES */
    /* ============================================= */
    header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 200;
        background: linear-gradient(to right, #000066, #191970);
        height: 90px;
    }

    .sidebar {
        background: linear-gradient(to bottom, #000066, #0A0A40);
        width: 240px;
        padding: 20px 0 0 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: fixed;
        top: 90px;
        left: 0;
        height: calc(100vh - 90px);
        overflow-y: auto;
        z-index: 100;
    }

    .content-wrapper {
        margin-left: 240px;
        margin-top: 90px;
        padding: 2rem;
        min-height: calc(100vh - 90px);
        background-color: #f5f7fa;
    }

    /* ============================================= */
    /* MODERN PAGE STYLING (kept from previous version) */
    /* ============================================= */
    :root {
        --primary: #2563eb;
        --success: #16a34a;
        --warning: #ca8a04;
        --purple: #7c3aed;
        --gray-100: #f8fafc;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-600: #475569;
        --gray-800: #1e293b;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.1);
        --shadow: 0 8px 25px rgba(0,0,0,0.1);
        --radius: 0.75rem;
        --transition: all 0.25s ease;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        color: var(--gray-800);
        font-weight: 600;
        text-decoration: none;
        padding: 0.75rem 1.2rem;
        border-radius: var(--radius);
        background: white;
        border: 1px solid var(--gray-300);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        margin-bottom: 1.5rem;
    }

    .back-link:hover {
        background: var(--gray-100);
        transform: translateY(-2px);
        box-shadow: var(--shadow);
        color: var(--gray-800);
    }

    .card {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        margin-bottom: 2rem;
        border: 1px solid var(--gray-200);
    }

    .card-header {
        background: linear-gradient(to bottom, #ffffff, #f8fafc);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .card-header h5 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gray-800);
    }

    .title-wrapper {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .status-badge {
        padding: 0.6rem 1.4rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .status-badge.completed    { background: #dcfce7; color: #166534; }
    .status-badge.under-review { background: #fffbeb; color: #92400e; }

    .card-body {
        padding: 2rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-item .label {
        font-size: 0.9rem;
        color: var(--gray-600);
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .info-item .value {
        font-size: 1.1rem;
        color: var(--gray-800);
        font-weight: 600;
    }

    .description-box {
        background: var(--gray-100);
        padding: 1.5rem;
        border-radius: var(--radius);
        border-left: 4px solid var(--primary);
    }

    .description-box h6 {
        margin: 0 0 1rem 0;
        color: var(--gray-800);
        font-weight: 600;
    }

    .table-container {
        overflow-x: auto;
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
    }

    .participants-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.95rem;
    }

    .participants-table thead th {
        background: var(--gray-100);
        color: var(--gray-800);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.8px;
        padding: 1.25rem 1rem;
        border-bottom: 2px solid var(--gray-300);
        text-align: left;
    }

    .participants-table tbody tr:hover {
        background: #f0f9ff !important;
    }

    .participants-table tbody td {
        padding: 1.25rem 1rem;
        border-bottom: 1px solid var(--gray-200);
        vertical-align: middle;
    }

    .participant-plv-id {
        font-family: 'Monaco', monospace;
        font-weight: 700;
        color: var(--primary);
    }

    .report-badge.submitted {
        padding: 0.5rem 1rem;
        border-radius: 1rem;
        background: #dcfce7;
        color: #166534;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .action-buttons-group {
        display: flex;
        gap: 0.75rem;
        flex-wrap: nowrap;
        justify-content: center;
        align-items: center;
    }

    .btn-sm-modern {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.6rem 1rem;
        border-radius: 0.6rem;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        transition: var(--transition);
        white-space: nowrap;
        height: 36px;
        min-width: 70px;
    }

    .btn-view-report   { background: #dbeafe; color: #1e40af; }
    .btn-view-report:hover { background: #bfdbfe; transform: translateY(-1px); }

    .btn-resend-cert   { background: #f3e8ff; color: #6b21a8; }
    .btn-resend-cert:hover { background: #e9d5ff; transform: translateY(-1px); }

    .btn-download-cert { background: #d1fae5; color: #065f46; }
    .btn-download-cert:hover { background: #a7f3d0; color: #064e3b; transform: translateY(-1px); }

    .no-participants-message {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--gray-600);
    }

    /* Responsive table on mobile */
    @media (max-width: 768px) {
        .content-wrapper { padding: 1rem; margin-left: 0 !important; }
        .sidebar { display: none; } /* or keep if you have mobile menu */
        /* Keep desktop table layout exactly, enable horizontal scrolling on small screens */
        .table-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Preserve exact desktop column widths — table will remain the same but become horizontally scrollable */
        .participants-table {
            min-width: 1164px !important; /* matches desktop column sizing */
            width: auto !important;
            display: table !important;
            white-space: nowrap !important;
        }
        .action-buttons-group { 
            justify-content: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .btn-sm-modern {
            min-width: 60px;
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
            height: auto;
        }
    }

    /* Extra small screens: slightly reduce min-width but keep desktop column proportions; stack action buttons to full width for ease of use */
    @media (max-width: 420px) {
        .participants-table {
            min-width: 900px !important;
            width: auto !important;
            display: table !important;
            white-space: nowrap !important;
        }
        .action-buttons-group { justify-content: flex-end; }
        .action-buttons-group .btn-sm-modern { min-width: 0; width: 100%; text-align: center; }
        .action-buttons-group .btn-sm-modern + .btn-sm-modern { margin-top: 6px; }
    }

    /* === Mobile spacing, button sizing and animations (mobile-only changes) === */
    @media (max-width: 768px) {
        /* Move content upwards closer to header without touching desktop layout */
        header { height: 72px; }
        .content-wrapper { margin-top: 72px !important; padding-top: 6px; }
        .back-link { margin-bottom: 0.8rem; padding: 0.6rem 1rem; }
        .card { margin-top: 6px; }

        /* Make action buttons more tappable and center their text */
        .action-buttons-group { gap: 0.5rem; justify-content: center; }
        .action-buttons-group .btn-sm-modern {
            min-width: 100px;
            padding: 0.65rem 0.9rem;
            height: 44px;
            font-size: 0.92rem;
            text-align: center;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
        }

        /* Ensure table remains horizontally scrollable but content sits closer to header */
        .table-container { margin-top: 6px; }
    }

    @media (max-width: 420px) {
        header { height: 64px; }
        .content-wrapper { margin-top: 64px !important; padding: 0.5rem; }
        .action-buttons-group .btn-sm-modern { min-width: 120px; width: 100%; }
    }

    /* --- Animations used on both desktop and mobile (no layout change for desktop) --- */
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .fade-in-up { animation: fadeInUp .42s cubic-bezier(.2,.8,.2,1) both; }
    .card, .card-header, .card-body, .table-container { will-change: transform, opacity; }

    /* Staggered rows: we use a CSS variable set from JS to apply staggered delays */
    .animated-row { animation: fadeInUp .36s ease both; animation-delay: calc(var(--i, 0) * 60ms); }

    /* Mobile-only visual fixes for info boxes and buttons (no desktop changes) */
    @media (max-width: 768px) {
        /* Make info items card-like on mobile for clearer separation */
        .info-grid { grid-template-columns: 1fr !important; gap: 12px; }
        .info-item {
            background: #ffffff;
            border: 1px solid rgba(15,23,42,0.06);
            box-shadow: 0 10px 30px rgba(2,6,23,0.04);
            border-radius: 0.65rem;
            padding: 14px 16px;
        }
        .info-item .label { margin-bottom: 6px; }
        .description-box {
            background: #ffffff;
            border: 1px solid rgba(15,23,42,0.06);
            box-shadow: 0 12px 34px rgba(2,6,23,0.05);
            padding: 14px 16px;
            border-left: none;
            border-radius: 0.75rem;
        }

        /* Reduce top blank space and pull content closer to the header */
        header { height: 72px; }
        .content-wrapper { margin-top: 72px !important; padding-top: 6px; }

        /* Buttons: larger taps and centered text */
        .action-buttons-group .btn-sm-modern { min-width: 120px; height: 44px; padding: 0.6rem 1rem; font-size: 0.95rem; }
        @media (max-width: 420px) {
            .action-buttons-group { gap: 0.6rem; }
            .action-buttons-group .btn-sm-modern { width: 100%; min-width: 0; }
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">

    <a href="{{ route('admin.history') }}" class="back-link">
        Back to History
    </a>

    <!-- Duty Summary Card -->
    <div class="card">
        <div class="card-header">
            <div class="title-wrapper">
                <h5>{{ $duty->title }}</h5>
                @php
                    $isCompleted = false;
                    try {
                        if (isset($duty->status) && stripos($duty->status, 'COMPLETE') !== false) {
                            $isCompleted = true;
                        } else {
                            $reportedCount = \App\Models\DutyReport::where('event_id', $duty->event_id)
                                ->distinct()->count('participant_id');
                            $totalParticipants = $duty->participants->count() ?? 0;
                            if ($totalParticipants > 0 && $reportedCount >= $totalParticipants) {
                                $isCompleted = true;
                            }
                        }
                    } catch (\Throwable $e) {
                        $isCompleted = (isset($duty->status) && stripos($duty->status, 'COMPLETE') !== false);
                    }
                @endphp

                @if($isCompleted)
                    <span class="status-badge completed">Completed</span>
                @else
                    <span class="status-badge under-review">Under Review</span>
                @endif
            </div>
        </div>

        <div class="card-body">
            <div class="info-grid">
                <div class="info-item">
                    <div class="label">Date</div>
                    <div class="value">{{ $duty->duty_date ? $duty->duty_date->format('M d, Y') : 'Not set' }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Time</div>
                    <div class="value">{{ $duty->formatted_start_time }} - {{ $duty->formatted_end_time }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Team Leader</div>
                    <div class="value">{{ $duty->team_leader_name ?? '—' }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Participants</div>
                    <div class="value">{{ $duty->participants->count() }}</div>
                </div>
            </div>

            @if($duty->description)
                <div class="description-box">
                    <h6>Description</h6>
                    <p class="mb-0">{{ $duty->description }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Participants Table Card -->
    <div class="card">
        <div class="card-header">
            <h5>Participant Reports</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-container">
                @php
                    $certificateMap = [];
                    try {
                        $files = \Illuminate\Support\Facades\Storage::disk('public')->files('certificates');
                        foreach ($files as $f) {
                            if (preg_match('/certificate_(\d+)_/', $f, $m)) {
                                $certificateMap[$m[1]] = $f;
                            }
                        }
                    } catch (\Throwable $ex) {}
                @endphp

                <table class="participants-table">
                    <thead>
                        <tr>
                            <th>PLV ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Report Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($duty->participants as $p)
                            @php
                                try {
                                    $hasReport = \App\Models\DutyReport::where('event_id', $duty->event_id)
                                        ->where('participant_id', $p->participant_id)
                                        ->exists();
                                } catch (\Throwable $e) {
                                    $hasReport = false;
                                }
                            @endphp

                            <tr>
                                <td data-label="PLV ID">
                                    <span class="participant-plv-id">{{ $p->plv_student_id ?? '—' }}</span>
                                </td>
                                <td data-label="Name">
                                    <span class="participant-name">{{ trim(($p->first_name ?? '') . ' ' . ($p->last_name ?? '')) ?: ($p->name ?? '—') }}</span>
                                </td>
                                <td data-label="Email">
                                    <span class="participant-email">{{ $p->email ?? '—' }}</span>
                                </td>
                                <td data-label="Report Status">
                                    @if($hasReport)
                                        <span class="report-badge submitted">
                                            Submitted
                                        </span>
                                    @endif
                                </td>
                                <td data-label="Actions" class="actions-cell">
                                    <div class="action-buttons-group">
                                        <a href="{{ route('admin.reports.participant.report', ['duty' => $duty->event_id, 'participant' => $p->participant_id]) }}"
                                           class="btn-sm-modern btn-view-report" title="View Report">
                                            View
                                        </a>

                                        <form method="POST" action="{{ route('admin.reports.certificate', ['duty' => $duty->event_id, 'participant' => $p->participant_id]) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn-sm-modern btn-resend-cert" title="Resend Certificate">
                                                Resend
                                            </button>
                                        </form>

                                        @if(isset($certificateMap[$p->participant_id]))
                                            <a href="{{ route('admin.reports.certificate.download', ['duty' => $duty->event_id, 'participant' => $p->participant_id]) }}" class="btn-sm-modern btn-download-cert" title="Download Certificate">
                                                Download
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="no-participants-message">
                                        <p class="mb-1 fw-bold">No participants found</p>
                                        <small>There are no participants assigned to this duty event.</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Success Toast -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100;">
        <div id="successToast" class="toast align-items-center text-bg-success border-0 shadow-lg" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <span id="successMessage"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toastEl = document.getElementById('successToast');
        @if(session('success'))
            document.getElementById('successMessage').textContent = "{{ session('success') }}";
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        @endif

        // Add staggered animation indices to participant rows for a pleasant entrance
        try {
            const rows = document.querySelectorAll('.participants-table tbody tr');
            rows.forEach((r, idx) => {
                r.style.setProperty('--i', idx);
                r.classList.add('animated-row');
            });
        } catch (e) {
            // fail silently; no impact on core features
        }

        // Animate cards and info items with a small stagger on mobile and web (only visual)
        try {
            const cards = document.querySelectorAll('.card');
            cards.forEach((c, i) => {
                setTimeout(() => c.classList.add('fade-in-up'), 80 + i * 80);
            });

            const infoItems = document.querySelectorAll('.info-item');
            infoItems.forEach((it, j) => {
                it.style.setProperty('--i', j);
                it.classList.add('animated-row');
            });
        } catch (e) {}
    });
</script>
@endsection