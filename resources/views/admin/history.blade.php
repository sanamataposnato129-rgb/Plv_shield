@extends('layouts.admin')

@section('title', 'History')

@section('styles')
    <style>
      /* Content area padding */
      .content-area {
          flex: 1;
          padding: 30px;
          padding-top: 0;
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
          margin-top: 0;
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

      .duties-actions {
          display: flex;
          gap: 12px;
      }

      .btn {
          padding: 10px 20px;
          border-radius: 6px;
          border: none;
          font-weight: 600;
          cursor: pointer;
          transition: all 0.2s ease;
          font-size: 14px;
          display: inline-flex;
          align-items: center;
          gap: 8px;
      }

      .btn-secondary {
          background: #6c757d;
          color: white;
      }

      .btn-secondary:hover {
          background: #5a6268;
          box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
      }

      .btn-outline-secondary {
          background: white;
          color: #6c757d;
          border: 1px solid #6c757d;
      }

      .btn-outline-secondary:hover {
          background: #6c757d;
          color: white;
      }

      .search-filters {
          background: white;
          padding: 16px;
          border-radius: 8px;
          box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
          margin-bottom: 24px;
          display: flex;
          gap: 12px;
          align-items: center;
          flex-wrap: wrap;
      }

      .search-filters .form-control {
          padding: 10px 14px;
          border: 1px solid #ddd;
          border-radius: 6px;
          font-size: 14px;
          flex: 1;
          min-width: 200px;
          height: 40px;
      }

      .search-filters .btn {
          height: 40px;
          flex: 1;
          min-width: 200px;
          display: inline-flex;
          justify-content: center;
          align-items: center;
      }

      .search-filters select {
          padding: 10px 14px;
          border: 1px solid #ddd;
          border-radius: 6px;
          font-size: 14px;
          height: 40px;
          flex: 1;
          min-width: 200px;
      }

      .search-filters .form-control:focus,
      .search-filters select:focus {
          outline: none;
          border-color: #000066;
          box-shadow: 0 0 0 3px rgba(0, 0, 102, 0.1);
      }

      .duties-table {
          background: white;
          border-radius: 8px;
          overflow: hidden;
          box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
      }

      .duties-table table {
          width: 100%;
          margin: 0;
          border-collapse: collapse;
      }

      .duties-table thead th {
          background: linear-gradient(135deg, #000066, #191970);
          color: #FFD700;
          padding: 16px;
          font-weight: 700;
          text-align: left;
          border: none;
          font-size: 14px;
          letter-spacing: 0.3px;
      }

      .duties-table tbody tr {
          border-bottom: 1px solid #f0f0f0;
          transition: background-color 0.2s ease;
      }

      .duties-table tbody tr:hover {
          background-color: rgba(0, 0, 102, 0.04);
      }

      .duties-table tbody td {
          padding: 14px 16px;
          vertical-align: middle;
          font-size: 14px;
      }

      .status-badge {
          display: inline-block;
          padding: 6px 12px;
          border-radius: 20px;
          font-size: 12px;
          font-weight: 600;
          text-align: center;
          background: #d4edda;
          color: #155724;
      }

      .btn-sm {
          padding: 8px 16px;
          font-size: 12px;
      }

      .btn-primary {
          background: linear-gradient(135deg, #000066, #191970);
          color: white;
          border: 1px solid rgba(255, 255, 255, 0.1);
      }

      .btn-primary:hover {
          background: linear-gradient(135deg, #000080, #1a1a80);
          box-shadow: 0 4px 12px rgba(0, 0, 102, 0.3);
          transform: translateY(-2px);
      }

      /* Modal styles */
      .modal-dialog {
          max-width: 700px;
          margin: 1.75rem auto;
      }

      .modal-content {
          border: none;
          border-radius: 12px;
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      }

      .modal-header {
          background: linear-gradient(90deg, #000066, #191970);
          color: #FFD700;
          border-bottom: 3px solid #FFD700;
          border-top-left-radius: 12px;
          border-top-right-radius: 12px;
      }

      .modal-title {
          color: #FFD700;
          font-weight: 700;
      }

      .btn-close {
          filter: invert(1) brightness(2);
      }

      /* MOBILE RESPONSIVE STYLES - Match admin dashboard */
      @media (max-width: 768px) {
          .content-area {
            margin-left: 0 !important;
            /* reduce top blank space on mobile so content sits closer to header */
            padding: 48px 15px 50px !important;
          }

          .admin-header {
              flex-direction: row;
              align-items: center;
              justify-content: space-between;
              flex-wrap: wrap;
          }

          .admin-header h2 {
              font-size: 18px;
          }

          .duties-actions {
              width: 100%;
          }

          /* Search filters - Stack on mobile */
          .search-filters {
              flex-direction: column;
              gap: 8px;
              padding: 12px;
              width: 100%;
          }

          .search-filters .form-control {
              min-width: auto;
              width: 100%;
          }

          /* Table - Scrollable on mobile */
          .duties-table {
              border-radius: 6px;
              overflow-x: auto;
          }

            /* Preserve exact desktop table layout/sizing, but allow horizontal scroll on small screens */
            .duties-table table {
              font-size: 13px;
              /* keep desktop column sizing intact by using a large min-width matching desktop layout */
              min-width: 1164px !important;
              width: auto !important;
              white-space: nowrap !important;
              display: table !important;
            }

          .duties-table thead th {
              padding: 12px 8px;
              font-size: 12px;
          }

          .duties-table tbody td {
              padding: 10px 8px;
              font-size: 13px;
          }

          /* Buttons - Mobile friendly */
          .btn {
              padding: 8px 14px;
              font-size: 12px;
          }

            /* Make search/filter buttons full-width, centered and more tappable on mobile */
            .search-filters .btn, .search-filters .btn-outline-secondary {
              width: calc(100% - 24px) !important;
              max-width: 520px !important;
              margin: 0 auto !important;
              justify-content: center !important;
              text-align: center !important;
              padding: 12px 14px !important;
              font-size: 15px !important;
            }

          .btn-sm {
              padding: 6px 12px;
              font-size: 11px;
          }

          /* Modal adjustments */
          .modal-dialog {
              max-width: 95vw;
              margin: 10px auto;
          }

          /* Status badge */
          .status-badge {
              padding: 4px 8px;
              font-size: 11px;
          }

          /* Remove hover effects on touch devices */
          .duties-table tbody tr:hover {
              background-color: transparent;
          }
      }

      @media (max-width: 480px) {
        .content-area {
          /* tighten top spacing further on very small screens */
          padding: 48px 10px 40px !important;
        }

          .admin-container {
              padding: 15px;
          }

          .admin-header h2 {
              font-size: 16px;
          }

          /* Search filters */
          .search-filters {
              padding: 10px;
              gap: 6px;
              margin: 0.5rem 0;
          }

          .search-filters .form-control {
              font-size: 13px;
              padding: 8px 10px;
          }

            /* Keep desktop table sizing but allow horizontal scroll on extra-small screens */
            .duties-table table {
              font-size: 12px;
              min-width: 1164px !important;
              width: auto !important;
              white-space: nowrap !important;
              display: table !important;
            }

          .duties-table thead th {
              padding: 8px 6px;
              font-size: 11px;
          }

          .duties-table tbody td {
              padding: 8px 6px;
              font-size: 12px;
          }

          /* Icons in table */
          .duties-table .me-1,
          .duties-table .me-2 {
              margin-right: 4px !important;
          }

          .duties-table i {
              font-size: 12px;
          }

          /* Status badge */
          .status-badge {
              display: inline-block;
              padding: 3px 6px;
              font-size: 10px;
              white-space: nowrap;
          }

          /* Buttons */
          .btn {
              padding: 6px 10px;
              font-size: 11px;
          }

            /* Table action buttons: larger and block on small screens for tappability */
            .duties-table .btn { display:block !important; width: calc(100% - 24px) !important; max-width:420px !important; margin:8px auto !important; text-align:center !important; padding:10px 12px !important; font-size:15px !important; }

          .btn-sm {
              padding: 5px 10px;
              font-size: 10px;
          }

          /* Modal */
          .modal-dialog {
              margin: 0 auto;
          }

          .modal-content {
              border-radius: 8px;
          }

          .modal-body .table {
              font-size: 12px;
          }

          .modal-body .table th,
          .modal-body .table td {
              padding: 0.5rem 0.25rem;
          }
      }
    </style>
@endsection

@section('after-styles')
<style>
  /* Animations (global, non-layout) */
  @keyframes fadeInUpSmall { from { transform: translateY(8px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

  .admin-header { transform: translateY(6px); opacity: 0; transition: transform .28s cubic-bezier(.2,.8,.2,1), opacity .28s ease; }
  .admin-header.page-loaded { transform: translateY(0); opacity: 1; }

  .duties-table { transform: translateY(6px); opacity: 0; transition: transform .36s cubic-bezier(.2,.8,.2,1), opacity .36s ease; }
  .duties-table.page-loaded { transform: translateY(0); opacity: 1; }

  /* Modal entrance animation */
  .modal.show .modal-dialog { animation: fadeInUpSmall .32s ease both; }

  /* Utility fade-in-up class used for staggered entrances (works on web & mobile) */
  .fade-in-up { opacity: 0; transform: translateY(8px); will-change: transform, opacity; animation: fadeInUpSmall .36s cubic-bezier(.2,.8,.2,1) both; }
  .staggered-row { display: table-row; }

  /* subtle fades for search/filter and pagination areas */
  .search-filters.fade-in, .search-container.fade-in { animation: fadeInUpSmall .28s cubic-bezier(.2,.8,.2,1) both; }
  .pagination.fade-in { animation: fadeInUpSmall .28s cubic-bezier(.2,.8,.2,1) both; }
</style>
@endsection

@section('content')
<div class="admin-container">
  <div class="admin-header">
    <h2>History of Duties</h2>
    <div class="duties-actions"></div>
  </div>

  <!-- Search / filters -->
  <form method="GET" action="{{ route('admin.history') }}" class="search-filters">
    <input type="text" id="searchDuty" name="search" class="form-control" placeholder="Search by title..." value="{{ $search ?? '' }}">
    <select id="tlFilter" class="form-control" name="tlFilter">
      <option value="all" {{ ($tlFilter ?? '') == 'all' ? 'selected' : '' }}>All</option>
      <option value="with-tl" {{ ($tlFilter ?? '') == 'with-tl' ? 'selected' : '' }}>With Team Leader</option>
      <option value="no-tl" {{ ($tlFilter ?? '') == 'no-tl' ? 'selected' : '' }}>Without Team Leader</option>
    </select>
    <button type="submit" class="btn btn-secondary">Search</button>
    <a href="{{ route('admin.history') }}" class="btn btn-outline-secondary">Clear</a>
  </form>

  <!-- Modals container (participants modal per report) -->
  <div class="modals-container">
    @php
      // Ensure $reports exists to avoid view errors when controller doesn't provide it
      $reports = $reports ?? collect();
    @endphp
    @foreach($reports as $r)
      @if(isset($r->status) && $r->status === 'COMPLETED')
      <div class="modal fade" id="participantsModal{{ $r->event_id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Duty Participants</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>PLV ID</th>
                      <th>Name</th>
                      <th>Role</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($r->participants ?? [] as $p)
                      <tr>
                        <td>{{ $p->plv_id ?? 'N/A' }}</td>
                        <td>{{ $p->name ?? 'N/A' }}</td>
                        <td>{{ $p->id === $r->team_leader_id ? 'Team Leader' : 'Member' }}</td>
                      </tr>
                    @empty
                      <tr><td colspan="3" class="text-center">No participants found</td></tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      @endif
    @endforeach
  </div>

  <!-- History table (only COMPLETED duties) -->
  <div class="duties-table">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>Title</th>
          <th>Team Leader</th>
          <th>Date</th>
          <th>Time</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @php $shown = 0; @endphp
        @forelse($reports as $report)
          @if(isset($report->status) && $report->status === 'COMPLETED')
            @php $shown++; @endphp
            <tr>
              <td class="fw-semibold">{{ $report->title }}</td>
              <td>
                <div class="d-flex align-items-center">
                  <i class="fas fa-user-shield me-2 text-primary"></i>
                  <span class="fw-medium">{{ $report->team_leader_name }}</span>
                </div>
              </td>
              <td>{{ $report->duty_date ? $report->duty_date->format('M d, Y') : 'Not set' }}</td>
              <td>{{ $report->formatted_start_time }} - {{ $report->formatted_end_time }}</td>
              <td>
                <span class="status-badge">
                  <i class="fas fa-check-circle me-1"></i>
                  Completed
                </span>
              </td>
              <td>
                <a href="{{ route('admin.history.show', ['id' => $report->event_id]) }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-file-alt me-1"></i>View Details
                </a>
              </td>
            </tr>
          @endif
        @empty
          <tr>
            <td colspan="6" class="text-center py-4">
              <div class="text-muted">
                <i class="fas fa-inbox me-2"></i>No completed duties found
              </div>
            </td>
          </tr>
        @endforelse

        @if($shown === 0 && $reports->count() > 0)
          <tr>
            <td colspan="6" class="text-center py-4 text-muted">No completed duties found</td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>

  @if(isset($reports) && method_exists($reports, 'hasPages') && $reports->hasPages())
    <div class="d-flex justify-content-end mt-3">
      {{ $reports->links() }}
    </div>
  @endif
</div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap components if needed
    const successToast = document.getElementById('successToast') ? new bootstrap.Toast(document.getElementById('successToast')) : null;
    const errorToast = document.getElementById('errorToast') ? new bootstrap.Toast(document.getElementById('errorToast')) : null;
    // Entrance animations for header and table
    const hdr = document.querySelector('.admin-header');
    const table = document.querySelector('.duties-table');
    if (hdr) setTimeout(() => hdr.classList.add('page-loaded'), 60);
    if (table) setTimeout(() => table.classList.add('page-loaded'), 120);

    // animate search filters
    const search = document.querySelector('.search-filters');
    if (search) setTimeout(() => search.classList.add('fade-in'), 90);

    // stagger table rows for a pleasant entrance
    const rows = document.querySelectorAll('.duties-table tbody tr');
    rows.forEach((r, i) => {
      r.classList.add('fade-in-up', 'staggered-row');
      r.style.animationDelay = (140 + i * 40) + 'ms';
    });

    // Small non-blocking page popup for consistency
    const popup = document.createElement('div');
    popup.className = 'history-page-popup';
    popup.innerHTML = '<div class="panel" style="background:#fff;padding:10px 12px;border-radius:10px;box-shadow:0 12px 30px rgba(2,6,23,0.08);">History — tap an item for details.</div>';
    document.body.appendChild(popup);
    setTimeout(() => { popup.style.position = 'fixed'; popup.style.inset = 'auto 16px 16px auto'; popup.style.zIndex = 1200; popup.querySelector('.panel').style.transform = 'translateY(8px)'; popup.querySelector('.panel').style.opacity = '0'; popup.classList.add('show'); popup.querySelector('.panel').style.transition = 'transform .22s ease,opacity .22s ease'; setTimeout(()=>{ popup.querySelector('.panel').style.transform='translateY(0)'; popup.querySelector('.panel').style.opacity='1'; },10); }, 140);
    setTimeout(() => { if (popup) { popup.querySelector('.panel').style.transform='translateY(8px)'; popup.querySelector('.panel').style.opacity='0'; setTimeout(()=>popup.remove(),260); } }, 3200);
    // animate pagination if present
    const pag = document.querySelector('.d-flex .pagination, .pagination');
    if (pag) setTimeout(() => pag.classList.add('fade-in'), 420);
  });
</script>
@endsection
