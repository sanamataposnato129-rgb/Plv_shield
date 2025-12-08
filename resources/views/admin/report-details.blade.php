@extends('layouts.admin')

@section('title', 'Report Details')

@section('styles')
<style>
    :root {
        --navy: #1a1a4d;
        --navy-dark: #191970;
        --navy-gradient: linear-gradient(135deg, #1a1a4d 0%, #2a2a5d 100%);
        --gold: #FFD700;
        --gold-light: #ffea00;
        --gold-glow: rgba(255, 215, 0, 0.4);
        --bg-light: #f5f7fa;
        --text-dark: #1a1a4d;
        --text-muted: #6b7280;
        --success: #10b981;
        --warning: #f59e0b;
        --border: #e5e7eb;
    }

    /* Layout */
    header {
        position: fixed;
        top: 0; left: 0; right: 0;
        height: 90px;
        background: linear-gradient(to right, #000066, #191970);
        z-index: 200;
    }

    .sidebar {
        position: fixed;
        top: 90px; left: 0;
        width: 240px;
        height: calc(100vh - 90px);
        background: linear-gradient(to bottom, #000066, #0A0A40);
        padding-top: 20px;
        z-index: 100;
        overflow-y: auto;
    }

    .report-details-wrap {
        margin-left: 240px;
        margin-top: 90px;
        padding: 2rem;
        background: var(--bg-light);
        min-height: calc(100vh - 90px);
    }

    /* Back Button */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: white;
        color: var(--navy);
        border: 2px solid var(--border);
        border-radius: 0.5rem;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.25s ease;
    }

    .btn-back:hover {
        background: var(--navy);
        color: white;
        border-color: var(--navy);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(26,26,77,0.25);
    }

    /* Cards */
    .detail-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .detail-card .card-header {
        background: var(--navy-gradient);
        padding: 1.75rem 2rem;
        color: white;
    }

    .detail-card h5 {
        font-size: 1.75rem;
        font-weight: 800;
        margin: 0;
        letter-spacing: 0.5px;
    }

    .badge-status {
        padding: 0.5rem 1.25rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.9rem;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .badge-status.under-review {
        background: linear-gradient(135deg, #FFF3CD, #FFE69C);
        color: #856404;
    }

    .card-body {
        padding: 2rem;
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-item {
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
        padding: 1.5rem;
        border-radius: 0.75rem;
        border-left: 6px solid var(--gold);
        box-shadow: 0 6px 16px rgba(255,215,0,0.15);
        transition: all 0.3s ease;
    }

    .info-item:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(255,215,0,0.25);
    }

    .info-item .label {
        font-size: 0.75rem;
        color: #92400e;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
    }

    .info-item .value {
        font-size: 1.35rem;
        font-weight: 800;
        color: var(--text-dark);
    }

    /* Description */
    .description-box {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-left: 6px solid var(--navy);
        padding: 1.5rem;
        border-radius: 0.75rem;
        margin-top: 1.5rem;
    }

    .description-box h6 {
        color: var(--navy);
        font-weight: 800;
        text-transform: uppercase;
        font-size: 1rem;
        margin-bottom: 0.75rem;
    }

    /* Action Buttons */
    .action-buttons {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 3px solid var(--border);
        text-align: right;
    }

    .btn-mark-complete {
        padding: 1rem 2.5rem;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        border-radius: 0.75rem;
        font-weight: 700;
        font-size: 1.1rem;
        text-transform: uppercase;
        box-shadow: 0 8px 25px rgba(16,185,129,0.35);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-mark-complete:hover {
        transform: translateY(-4px);
        background: linear-gradient(135deg, #059669, #047857);
        box-shadow: 0 15px 35px rgba(16,185,129,0.5);
    }

    /* Table */
    .table {
        margin: 0;
        font-size: 0.95rem;
    }

    .table thead {
        background: var(--navy-gradient);
    }

    .table thead th {
        color: var(--gold);
        font-weight: 800;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
        padding: 1.25rem 1rem;
        border: none;
    }

    .table tbody td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f3f4f6;
    }

    .table tbody tr:hover {
        background: #f8fafc;
    }

    .badge.rounded-pill {
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
        font-weight: 700;
    }

    .bg-success-subtle {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0) !important;
        color: #065f46 !important;
    }

    .bg-warning {
        background: linear-gradient(135deg, #fef3c7, #fde68a) !important;
        color: #78350f !important;
    }

    /* Buttons */
    .btn-view-report, .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 1.25rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.25s ease;
    }

    .btn-view-report {
        background: var(--navy-gradient);
        color: white;
        box-shadow: 0 4px 15px rgba(26,26,77,0.3);
    }

    .btn-view-report:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(26,26,77,0.4);
    }

    .btn-outline-dark {
        border: 2px solid #374151;
        color: #374151;
        background: white;
    }

    .btn-outline-dark:hover {
        background: #374151;
        color: white;
        transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .sidebar { width: 80px; }
        .report-details-wrap { margin-left: 80px; }
        .info-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
        .report-details-wrap {
            padding: 1.5rem;
            margin-left: 0 !important;
            margin-top: 90px;
        }
        .title-wrapper { flex-direction: column; align-items: flex-start; }
        .action-buttons { text-align: center; }
        /* Improve card paddings and table responsiveness on small screens */
        .detail-card .card-header { padding: 1rem 1rem; }
        .card-body { padding: 1rem; }

        /* Make participant table horizontally scrollable while keeping desktop columns intact */
        .table-responsive {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            min-width: 900px; /* keep desktop-like column widths, allow horizontal scroll */
            white-space: nowrap;
        }

        /* Stack action buttons and make them tap-friendly */
        .action-buttons { text-align: center; }
        .action-buttons .btn-mark-complete { width: 100%; display: inline-block; }

        /* Participant action buttons: make buttons stack on very small screens and be full-width within their cell */
        .table tbody td .d-flex { flex-wrap: wrap; justify-content: flex-end; }
        .table tbody td .d-flex a.btn-view-report,
        .table tbody td .d-flex .btn-action {
            display: inline-block;
            white-space: nowrap;
            margin-bottom: 6px;
        }
        @media (max-width: 420px) {
            .table { min-width: 820px; }
            .table tbody td .d-flex a.btn-view-report,
            .table tbody td .d-flex .btn-action {
                width: 100%;
                text-align: center;
            }
        }

        /* Mobile: convert participant rows into stacked cards for easier reading and make action buttons prominent */
        .table-responsive {
            overflow-x: visible !important;
        }

        .table {
            min-width: auto !important;
            white-space: normal !important;
        }

        .table thead {
            display: none !important;
        }

        .table tbody, .table tbody tr {
            display: block !important;
        }

        .table tbody tr {
            background: #ffffff;
            border-radius: 10px;
            margin-bottom: 12px;
            padding: 12px;
            box-shadow: 0 6px 18px rgba(16,24,40,0.04);
            border: 1px solid #f3f4f6;
        }

        .table tbody td {
            display: block !important;
            width: 100% !important;
            padding: 6px 0 !important;
            border: none !important;
        }

        /* First cell usually contains participant info; keep it prominent */
        .table tbody td:first-child {
            font-weight: 700;
            color: var(--text-dark);
            padding-bottom: 6px !important;
        }

        /* Action cell: place buttons below details and align full width on very small screens */
        .table tbody td:last-child {
            display: flex !important;
            gap: 8px;
            justify-content: flex-end;
            align-items: center;
            padding-top: 8px !important;
        }

        .table tbody td .btn-view-report,
        .table tbody td .btn-action,
        .table tbody td a.btn-outline-dark {
            display: inline-flex !important;
            padding: 0.75rem 1rem !important;
            border-radius: 8px !important;
            font-size: 0.95rem !important;
        }

        /* Attachments (thumbnails) */
        .attachment-list {
            padding-left: 0;
            list-style: none;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin: 0;
        }

        .attachment-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            max-width: 240px;
        }

        .thumb img {
            display: block;
            width: 100%;
            max-width: 240px;
            max-height: 160px;
            object-fit: cover;
            border-radius: 6px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        }

        .img-preview-link { cursor: pointer; }


        @media (max-width: 420px) {
            .table tbody td:last-child {
                flex-direction: column;
                gap: 8px;
                align-items: stretch;
            }
            .table tbody td .btn-view-report,
            .table tbody td .btn-action,
            .table tbody td a.btn-outline-dark {
                width: 100% !important;
                justify-content: center !important;
            }
        }
    }
</style>
@endsection

@section('content')
<div class="report-details-wrap">
    <div class="mb-4">
        <a href="javascript:history.back()" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mb-4">{{ session('error') }}</div>
    @endif

    <!-- Duty Summary Card -->
    <div class="detail-card">
        <div class="card-header">
            <div class="title-wrapper d-flex align-items-center justify-content-between flex-wrap gap-3">
                <h5>{{ $duty->title }}</h5>
                <span class="badge-status under-review">
                    <i class="fas fa-clock"></i>
                    Under Review
                </span>
            </div>
        </div>

        <div class="card-body">
            <div class="info-grid">
                <div class="info-item">
                    <div class="label">Date</div>
                    <div class="value">{{ $duty->duty_date?->format('M d, Y') ?? 'Not set' }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Time</div>
                    <div class="value">{{ $duty->formatted_start_time }} - {{ $duty->formatted_end_time }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Team Leader</div>
                    <div class="value">
                        <i class="fas fa-user-shield" style="color: var(--gold)"></i>
                        {{ $duty->team_leader_name ?? '—' }}
                    </div>
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

            <div class="action-buttons">
                <form method="POST" action="{{ route('admin.reports.complete', ['id' => $duty->event_id]) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn-mark-complete">
                        <i class="fas fa-check-circle"></i>
                        Mark as Complete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Participants Table -->
    <div class="detail-card">
        <div class="card-header">
            <h5>Participant Reports</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
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
                                $hasReport = collect($p->reports ?? [])->contains('event_id', $duty->event_id);
                            @endphp
                            <tr>
                                <td class="fw-semibold">{{ $p->plv_student_id ?? 'N/A' }}</td>
                                <td>{{ trim(($p->first_name ?? '') . ' ' . ($p->last_name ?? '')) ?: ($p->name ?? 'N/A') }}</td>
                                <td class="text-muted small">{{ $p->email ?? 'N/A' }}</td>
                                <td>
                                    @if($hasReport)
                                        <span class="badge rounded-pill bg-success-subtle">
                                            <i class="fas fa-check-circle"></i> Submitted
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-warning">
                                            <i class="fas fa-clock"></i> Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('admin.reports.participant.report', ['duty' => $duty->event_id, 'participant' => $p->participant_id]) }}"
                                           class="btn-view-report">
                                            <i class="fas fa-file-alt"></i> View Report
                                        </a>

                                        <form method="POST" action="{{ route('admin.reports.certificate', ['duty' => $duty->event_id, 'participant' => $p->participant_id]) }}"
                                              style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-dark btn-action"
                                                    onclick="return confirm('Send certificate to {{ $p->email }}?')">
                                                <i class="fas fa-certificate"></i> Certificate
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">No participants found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

  <!-- Confirmation Modal -->
  <div class="modal fade" id="confirmCompleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirm Action</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to mark this duty as completed? This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-success" id="confirmCompleteBtn">
            <i class="fas fa-check me-1"></i>Confirm Complete
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Success Toast -->
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          <i class="fas fa-check-circle me-2"></i>
          <span id="successMessage"></span>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const confirmModal = new bootstrap.Modal(document.getElementById('confirmCompleteModal'));
  const successToast = new bootstrap.Toast(document.getElementById('successToast'));
  
  // Handle Mark as Complete confirmation
  document.querySelector('.btn-mark-complete').addEventListener('click', function(e) {
    e.preventDefault();
    confirmModal.show();
  });

  // Handle confirmation button click
  document.getElementById('confirmCompleteBtn').addEventListener('click', function() {
    const form = document.querySelector('form');
    form.submit();
    confirmModal.hide();
  });

  // Show success message if exists in session
  @if(session('success'))
    document.getElementById('successMessage').textContent = "{{ session('success') }}";
    successToast.show();
  @endif
});
</script>
@endsection