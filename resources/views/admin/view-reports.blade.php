@extends('layouts.admin')

@section('title', 'View Reports')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/create-duties.css') }}">
    <style>
      /* === HEADER === */
      header {
          background: linear-gradient(to right, #000066, #191970);
          color: #FFD700;
          display: flex;
          align-items: center;
          justify-content: space-between;
          padding: 15px 40px;
          border-bottom: 3px solid #8000FF;
          position: fixed;
          top: 0;
          left: 0;
          right: 0;
          z-index: 200;
      }
      
      header .logo {
          height: 60px;
          margin-right: 15px;
      }
      
      header .header-left {
          display: flex;
          align-items: center;
      }
      
      header h1 {
          font-size: 28px;
          font-weight: 800;
          margin: 0;
      }
      
      /* SIDEBAR - FIXED UNDER HEADER */
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

      .sidebar-title {
          color: #FFD700;
          font-weight: bold;
          margin-bottom: 10px;
          font-size: 18px;
          flex-shrink: 0;
          padding: 0 20px;
      }

      .menu {
          list-style: none;
          width: 100%;
          flex: 1;
          overflow-y: auto; 
          padding: 0;
          margin: 0;
      }

      .menu li {
          color: white;
          padding: 12px 25px;
          display: flex;
          align-items: center;
          cursor: pointer;
          transition: 0.3s;
      }

      .menu li a.menu-link {
          text-decoration: none;
          color: inherit;
          display: flex;
          align-items: center;
          width: 100%;
      }

      .menu li a.menu-link img.icon {
          width: 22px;
          height: 22px;
          margin-right: 12px;
          filter: brightness(0) invert(1);
      }

      .menu li:hover,
      .menu li.active {
          background-color: #FFD700;
          color: black;
          font-weight: bold;
      }

      .menu li.active img.icon,
      .menu li:hover img.icon {
          filter: brightness(0);
      }

      /* LOGOUT BUTTON */
      .logout-btn {
          background-color: #FFD700;
          color: black;
          font-weight: bold;
          border: none;
          padding: 10px 25px;
          border-radius: 30px;
          margin: 20px; 
          cursor: pointer;
          transition: all 0.3s ease;
          flex-shrink: 0; 
          width: calc(100% - 40px); 
      }

      .logout-btn:hover {
          background-color: #ffea00;
          transform: scale(1.05);
          box-shadow: 0 0 15px rgba(255, 215, 0, 0.8);
      }

      /* MAIN CONTENT AREA - SCROLLABLE */
      main {
          margin-left: 240px; 
          margin-top: 90px; 
          padding: 20px;
          min-height: calc(100vh - 90px);
      }
      .content-wrapper {
          margin-left: 240px;
          margin-top: 90px;
          padding: 20px;
          min-height: calc(100vh - 90px);
      }

      /* Override layout defaults to remove extra padding */
      .content-area {
          flex: 1;
          padding: 0;
      }

      .admin-container {
          background: transparent;
          border-radius: 0;
          padding: 0;
          box-shadow: none;
      }
      
      /* Professional styling */
      .duties-header {
          background: white;
          padding: 24px;
          border-radius: 8px;
          margin-bottom: 24px;
          box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
          display: flex;
          justify-content: space-between;
          align-items: center;
      }

      .create-header {
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
      }

      .search-filters .form-control:focus {
          outline: none;
          border-color: #000066;
          box-shadow: 0 0 0 3px rgba(0, 0, 102, 0.1);
      }

      .duties-table {
          background: white;
          border-radius: 8px;
          overflow-x: auto;
          -webkit-overflow-scrolling: touch;
          box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
          display: block;
          width: 100%;
      }

      .duties-table table {
          width: 100%;
          margin: 0;
          border-collapse: collapse;
          min-width: 1000px;
          white-space: nowrap;
      }

      .duties-table thead th {
          background: linear-gradient(135deg, #000066, #191970);
          color: #FFD700;
          padding: 16px;
          font-weight: 700;
          text-align: center;
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
          text-align: center;
      }

      .status-badge {
          display: inline-block;
          padding: 6px 12px;
          border-radius: 20px;
          font-size: 12px;
          font-weight: 600;
          text-align: center;
          background: #fff3e0;
          color: #ef6c00;
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

      /* MOBILE RESPONSIVE DESIGN */
      @media (max-width: 768px) {
          /* Hide sidebar on mobile */
          .sidebar {
              display: none;
          }

          /* Adjust main content for mobile */
          main,
          .content-wrapper {
              margin-left: 0;
              margin-top: 90px;
              padding: 12px;
              min-height: auto;
          }

          /* Stack header content vertically on mobile */
          .duties-header {
              flex-direction: column;
              gap: 16px;
              padding: 16px;
          }

          .create-header {
              font-size: 18px;
              width: 100%;
              text-align: center;
          }

          .duties-actions {
              width: 100%;
              flex-wrap: wrap;
              justify-content: center;
          }

          /* Stack search filters vertically */
          .search-filters {
              flex-direction: column;
              gap: 8px;
          }

          .search-filters .form-control {
              min-width: auto;
              width: 100%;
          }

          .search-filters select {
              width: 100% !important;
          }

          .search-filters button,
          .search-filters a {
              width: 100%;
              justify-content: center;
          }

          /* Make table responsive */
          .duties-table {
              overflow-x: auto;
              -webkit-overflow-scrolling: touch;
              display: block;
              width: 100%;
          }

          .duties-table table {
              min-width: 800px;
              font-size: 12px;
              width: 100%;
              white-space: nowrap;
          }

          .duties-table thead th {
              padding: 10px 8px;
              font-size: 12px;
              text-align: center;
          }

          .duties-table tbody td {
              padding: 10px 8px;
              font-size: 12px;
              text-align: center;
          }

          /* Show all columns on mobile with horizontal scroll */
          .duties-table th,
          .duties-table td {
              display: table-cell;
          }

          /* Button sizing on mobile */
          .btn {
              padding: 8px 12px;
              font-size: 12px;
          }

          .btn-sm {
              padding: 6px 12px;
              font-size: 11px;
          }

          /* Modal adjustments */
          .modal-dialog {
              margin: 0.5rem auto;
              max-width: 95vw;
          }

          /* Status badge sizing */
          .status-badge {
              padding: 4px 8px;
              font-size: 11px;
          }

          /* Pagination adjustments */
          .d-flex.justify-content-end {
              justify-content: center;
          }

          .pagination {
              margin: 0;
              flex-wrap: wrap;
              justify-content: center;
          }
      }

      @media (max-width: 480px) {
          /* Extra small screen adjustments */
          header {
              padding: 12px 20px;
          }

          header .logo {
              height: 50px;
              margin-right: 12px;
          }

          header h1 {
              font-size: 20px;
          }

          main,
          .content-wrapper {
              margin-top: 90px;
              padding: 8px;
          }

          .duties-header {
              padding: 12px;
              gap: 12px;
          }

          .create-header {
              font-size: 16px;
          }

          .search-filters {
              margin: 0.5rem 0 !important;
              padding: 12px;
          }

          .search-filters .form-control {
              padding: 8px 10px;
              font-size: 13px;
          }

          .duties-table {
              overflow-x: auto;
              -webkit-overflow-scrolling: touch;
              display: block;
              width: 100%;
          }

          .duties-table table {
              font-size: 11px;
              white-space: nowrap;
          }

          .duties-table thead th {
              padding: 8px 6px;
              font-size: 11px;
          }

          .duties-table tbody td {
              padding: 8px 6px;
              font-size: 11px;
          }

          /* Stack action buttons on extra small screens */
          .btn {
              padding: 6px 10px;
              font-size: 11px;
              width: 100%;
              margin: 4px 0;
          }

          .btn-sm {
              padding: 5px 10px;
              font-size: 10px;
          }

          /* Adjust team leader display */
          .d-flex.align-items-center {
              flex-direction: column;
              align-items: flex-start;
          }

          .d-flex.align-items-center i {
              margin-bottom: 4px;
              margin-right: 0;
          }
      }

      /* Tablet adjustments */
      @media (min-width: 769px) and (max-width: 1024px) {
          .sidebar {
              width: 200px;
          }

          main,
          .content-wrapper {
              margin-left: 200px;
          }

          .duties-header {
              flex-direction: column;
              gap: 12px;
              align-items: flex-start;
          }

          .create-header {
              font-size: 20px;
          }

          .search-filters {
              flex-wrap: wrap;
          }

          .search-filters .form-control {
              min-width: 150px;
          }
          }

          /* Additional mobile overrides: keep desktop layout exactly the same,
           but ensure the table keeps its desktop column sizing and becomes
           horizontally scrollable on small screens. Also fix header/content
           offsets for mobile. */
          @media (max-width: 768px) {
            /* ensure header stays fixed and reduce top offset for content */
            header {
              position: fixed;
              top: 0;
              left: 0;
              right: 0;
              z-index: 200;
            }

            main,
            .content-wrapper {
              margin-left: 0;
              margin-top: 90px; /* matches header height */
              padding: 12px;
            }

            /* Force table to keep desktop layout and be horizontally scrollable */
            .duties-table {
              display: block !important;
              overflow-x: auto !important;
              -webkit-overflow-scrolling: touch;
              white-space: nowrap !important;
            }

            .duties-table table {
              display: table !important;
              width: auto !important;
              white-space: nowrap !important;
              min-width: 1164px !important; /* sum of the explicit column widths below */
            }

            .duties-table th,
            .duties-table td {
              padding: 10px 12px !important;
              box-sizing: border-box !important;
              vertical-align: middle !important;
              display: table-cell !important;
              white-space: nowrap !important;
            }

            /* Explicit column widths to keep header aligned with data */
            .duties-table th:nth-child(1), .duties-table td:nth-child(1) { width: 360px !important; min-width: 360px !important; }
            .duties-table th:nth-child(2), .duties-table td:nth-child(2) { width: 220px !important; min-width: 220px !important; }
            .duties-table th:nth-child(3), .duties-table td:nth-child(3) { width: 140px !important; min-width: 140px !important; }
            .duties-table th:nth-child(4), .duties-table td:nth-child(4) { width: 160px !important; min-width: 160px !important; }
            .duties-table th:nth-child(5), .duties-table td:nth-child(5) { width: 140px !important; min-width: 140px !important; }
            .duties-table th:nth-child(6), .duties-table td:nth-child(6) { width: 140px !important; min-width: 140px !important; }

            /* Buttons: avoid wrapping and keep consistent sizing */
            .btn, .btn-sm { white-space: nowrap !important; }
          }

          @media (max-width: 480px) {
            /* Slightly smaller min-width for very small devices */
            .duties-table table { min-width: 1000px !important; }
          }
        </style>
      @endsection

@section('content')
<div class="content-wrapper">
  <div class="duties-header d-flex align-items-center justify-content-between">
    <h2 class="create-header">Submitted Reports</h2>
    <div class="duties-actions"></div>
  </div>

  <!-- Search / filters -->
  <form method="GET" action="{{ route('admin.view-reports') }}" class="search-filters" style="margin:1rem 0;display:flex;gap:0.5rem;align-items:center;">
    <input type="text" id="searchDuty" name="search" class="form-control" placeholder="Search by title..." value="{{ $search ?? '' }}">
    <select id="tlFilter" class="form-control" name="tlFilter" style="width:220px;">
      <option value="all" {{ ($tlFilter ?? '') == 'all' ? 'selected' : '' }}>All</option>
      <option value="with-tl" {{ ($tlFilter ?? '') == 'with-tl' ? 'selected' : '' }}>With Team Leader</option>
      <option value="no-tl" {{ ($tlFilter ?? '') == 'no-tl' ? 'selected' : '' }}>Without Team Leader</option>
    </select>
    <button type="submit" class="btn btn-secondary">Search</button>
    <a href="{{ route('admin.view-reports') }}" class="btn btn-outline-secondary">Clear</a>
  </form>

  <!-- Modals container (participants modal per report) -->
  <div class="modals-container">
    @foreach($reports as $r)
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
    @endforeach
  </div>

  <!-- Reports table -->
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
        @forelse($reports as $report)
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
                <i class="fas fa-clock me-1"></i>
                Under Review
              </span>
            </td>
            <td>
              <a href="{{ route('admin.reports.show', ['id' => $report->event_id]) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-file-alt me-1"></i>View Report
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center py-4">
              <div class="text-muted">
                <i class="fas fa-inbox me-2"></i>No reports pending review
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($reports->hasPages())
    <div class="d-flex justify-content-end mt-3">
      {{ $reports->links() }}
    </div>
  @endif
</div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap components
    const successToast = new bootstrap.Toast(document.getElementById('successToast'));
    const errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
    const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));

    function showSuccess(message) {
      document.getElementById('successMessage').textContent = message;
      successToast.show();
    }

    function showError(message) {
      document.getElementById('errorMessage').textContent = message;
      errorToast.show();
    }

    function showConfirmation(title, message, actionCallback) {
      document.getElementById('confirmTitle').textContent = title;
      document.getElementById('confirmMessage').textContent = message;
      
      const confirmBtn = document.getElementById('confirmActionBtn');
      confirmBtn.onclick = () => {
        confirmModal.hide();
        actionCallback();
      };
      
      confirmModal.show();
    }

    // Handle approve button clicks
    document.querySelectorAll('.approve-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const dutyId = this.dataset.dutyId;
        const row = this.closest('tr');
        
        showConfirmation(
          'Approve Report',
          'Are you sure you want to approve this report?',
          () => {
            fetch(`/admin/reports/${dutyId}/approve`, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
              }
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                showSuccess(data.message);
                row.remove(); // Remove the row since it's no longer under review
              } else {
                showError(data.message || 'Error approving report');
              }
            })
            .catch(error => {
              console.error('Error:', error);
              showError('Error approving report');
            });
          }
        );
      });
    });

    // Handle reject button clicks
    document.querySelectorAll('.reject-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const dutyId = this.dataset.dutyId;
        const row = this.closest('tr');
        
        showConfirmation(
          'Reject Report',
          'Are you sure you want to reject this report?',
          () => {
            fetch(`/admin/reports/${dutyId}/reject`, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
              }
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                showSuccess(data.message);
                row.remove(); // Remove the row since it's no longer under review
              } else {
                showError(data.message || 'Error rejecting report');
              }
            })
            .catch(error => {
              console.error('Error:', error);
              showError('Error rejecting report');
            });
          }
        );
      });
    });
  });
</script>
@endsection
