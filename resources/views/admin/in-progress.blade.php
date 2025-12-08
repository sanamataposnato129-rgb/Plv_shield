@extends('layouts.admin')

@section('title', 'In Progress')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/create-duties.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* HEADER - FIXED AT TOP */
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 200;
            background: linear-gradient(to right, #000066, #191970);
            height: 90px;
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
            top: 90px; /* Start below header */
            left: 0;
            height: calc(100vh - 90px); /* Full height minus header */
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
            padding: 0px 20px 20px 20px;
            min-height: calc(100vh - 90px);
        }

        /* Override layout defaults to remove extra padding */
        .content-area {
            flex: 1;
            padding: 0;
            margin: 0;
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

        .duties-title {
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

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .search-filters {
            background: white;
            padding: 16px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            margin-bottom: 24px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
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

        .search-filters input[type="text"] {
            order: 1;
            flex: 1;
            min-width: 200px;
        }

        .search-filters button:nth-of-type(1) {
            order: 2;
        }

        .search-filters button:nth-of-type(2) {
            order: 3;
        }

        .search-filters select {
            order: 4;
            width: 100%;
            max-width: 220px;
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
        }

        .status-OPEN {
            background: #e3f2fd;
            color: #1565c0;
        }

        .status-IN_PROGRESS {
            background: #fff3e0;
            color: #ef6c00;
        }

        .status-CERTIFIED {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-COMPLETED {
            background: #d4edda;
            color: #155724;
        }

        .status-CANCELLED {
            background: #f8d7da;
            color: #721c24;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 12px;
        }

        /* MOBILE RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                display: none !important;
            }

            header {
                padding-left: 80px !important;
            }

            main,
            .content-wrapper {
                margin-left: 0 !important;
                margin-top: 90px;
                padding: 15px;
            }

            .duties-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .duties-title {
                font-size: 20px;
            }

            .duties-actions {
                width: 100%;
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .search-filters {
                flex-direction: column;
            }

            .search-filters .form-control {
                width: 100%;
                min-width: auto;
            }

            .duties-table table {
                font-size: 13px;
            }

            .duties-table tbody td,
            .duties-table thead th {
                padding: 10px 8px;
            }
        }

        @media (max-width: 480px) {
            header {
                padding: 15px 50px 15px 15px;
            }

            header h1 {
                font-size: 20px;
            }

            main,
            .content-wrapper {
                padding: 10px;
            }

            .duties-header {
                padding: 16px;
            }

            .duties-title {
                font-size: 18px;
            }

            .btn {
                padding: 8px 12px;
                font-size: 13px;
            }

            .btn-sm {
                padding: 6px 10px;
                font-size: 11px;
            }

            .duties-table {
                overflow-x: auto;
            }

            .duties-table table {
                font-size: 12px;
                min-width: 600px;
            }

            .duties-table tbody td,
            .duties-table thead th {
                padding: 8px 6px;
            }
        }

        .btn-info {
            background: #17a2b8;
            color: white;
        }

        .btn-info:hover {
            background: #138496;
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

        .team-leader-section {
            background: rgba(255, 215, 0, 0.1);
            border: 1px solid #FFD700;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
        }

        .table-responsive {
            border-radius: 8px;
            border: 1px solid #eee;
            max-height: 400px;
            overflow-y: auto;
        }

    /* Use global admin dashboard styles for layout and sidebar */
    </style>
    <style>
      /* Mobile-only: make in-progress duties table horizontally scrollable without affecting desktop */
      @media (max-width: 768px) {
        .duties-table {
          overflow-x: auto !important;
          -webkit-overflow-scrolling: touch;
        }
        .duties-table table {
          min-width: 820px !important;
          width: auto !important;
        }
      }
      @media (max-width: 480px) {
        .duties-table {
          overflow-x: auto !important;
        }
        .duties-table table {
          min-width: 700px !important;
          width: auto !important;
        }
      }

      /* Participants modal: improve mobile layout without changing desktop */
      @media (max-width: 768px) {
        /* Make modal nearly full-width on small screens */
        .modal-dialog {
          max-width: 95vw !important;
          margin: 1rem auto !important;
        }

        .modal-content {
          border-radius: 10px !important;
        }

        /* Ensure table inside modal scrolls horizontally and keeps header alignment */
        .table-responsive {
          overflow-x: auto !important;
          -webkit-overflow-scrolling: touch;
        }

        .table-responsive table {
          min-width: 640px !important; /* keeps columns readable */
          width: auto !important;
          white-space: nowrap !important;
        }

        .table-responsive thead th,
        .table-responsive tbody td {
          padding: 10px 12px !important;
          box-sizing: border-box !important;
          vertical-align: middle !important;
        }

        /* Stack team leader section vertically on small screens */
        .team-leader-section .d-flex {
          flex-direction: column !important;
          gap: 8px !important;
          align-items: flex-start !important;
        }

        .team-leader-section .btn-warning {
          width: auto !important;
        }

        /* Modal footer: stack buttons on very small screens for easier tapping */
        .modal-footer {
          display: flex !important;
          gap: 8px !important;
          flex-wrap: wrap !important;
          justify-content: flex-end !important;
        }
        .modal-footer .btn {
          flex: 0 0 auto !important;
        }
      }

      @media (max-width: 480px) {
        .modal-dialog { max-width: 98vw !important; }
        .table-responsive table { min-width: 600px !important; }
        .team-leader-section .d-flex { align-items: stretch !important; }
      }
    </style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="duties-header d-flex align-items-center justify-content-between">
      <h2 class="duties-title">In-Progress Duties</h2>
      <div class="duties-actions">
        {{-- kept intentionally empty to preserve existing functionality (no extra action buttons) --}}
      </div>
    </div>

    {{-- Use a form-like container similar to create-duties for consistent layout. Keep all IDs and controls unchanged to preserve behavior. --}}
    <form method="GET" action="#" class="search-filters" style="margin:1rem 0;display:flex;gap:0.5rem;align-items:center;">
      <input type="text" id="searchDuty" name="search" class="form-control" placeholder="Search by title..." value="{{ $search ?? '' }}">
      <select id="tlFilter" class="form-control" name="tlFilter" style="width:220px;">
        <option value="all">All</option>
        <option value="with-tl">With Team Leader</option>
        <option value="no-tl">Without Team Leader</option>
      </select>
      <button type="button" id="btnSearch" class="btn btn-secondary">Search</button>
      <button type="button" id="btnClear" class="btn btn-outline-secondary">Clear</button>
    </form>

    <!-- Duties table -->
  @php
    // Normalize $duties to a Collection and filter for IN_PROGRESS status
    if (isset($duties) && is_object($duties) && method_exists($duties, 'getCollection')) {
      $baseCollection = $duties->getCollection();
    } else {
      $baseCollection = collect($duties ?? []);
    }
    $inProgressDuties = $baseCollection->filter(function($d) {
      return isset($d->status) && strtoupper($d->status) === 'IN_PROGRESS';
    })->values();
  @endphp

  <!-- Modals Container -->
  <div class="modals-container">
    @foreach($inProgressDuties as $duty)
      <div class="modal fade" id="participantsModal{{ $duty->id }}" tabindex="-1" aria-labelledby="participantsModalLabel{{ $duty->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="participantsModalLabel{{ $duty->id }}">Participants List</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <!-- Team Leader Section -->
              <div class="team-leader-section mb-4">
                <h6 class="border-bottom pb-2">Team Leader</h6>
                <div class="d-flex justify-content-between align-items-center">
                  @php
                    // Show blank when no team leader exists
                    $tlName = '';
                    if (!empty($duty->team_leader_name)) {
                        $tlName = $duty->team_leader_name;
                    } elseif (isset($duty->team_leader) && is_object($duty->team_leader) && isset($duty->team_leader->name)) {
                        $tlName = $duty->team_leader->name;
                    }
                  @endphp
                  <span>{{ $tlName }}</span>
                  <button class="btn btn-warning btn-sm">Set TL</button>
                </div>
              </div>

              <!-- Participants Table -->
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>PLV ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($duty->participants ?? [] as $participant)
                      <tr>
                        <td>{{ $participant->plv_student_id ?? ($participant->plv_id ?? 'N/A') }}</td>
                        <td>{{ trim(($participant->first_name ?? '') . ' ' . ($participant->last_name ?? '')) ?: ($participant->name ?? 'N/A') }}</td>
                        <td>{{ $participant->email ?? 'N/A' }}</td>
                        <td>
                          <button class="btn btn-danger btn-sm" onclick="return confirm('Remove participant?')">Delete</button>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="4" class="text-center">No participants found</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
              <button type="button" class="btn btn-success">Add Student</button>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="duties-table">
  <table class="table table-hover">
      <thead>
        <tr>
          <th width="20%">Title</th>
          <th width="15%">Date</th>
          <th width="15%">Time</th>
          <th width="10%">Participants</th>
          <th width="15%">Team Leader</th>
          <th width="10%">Status</th>
          <th width="15%">Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($inProgressDuties as $duty)
          <tr>
            <td>{{ $duty->title }}</td>
            <td>{{ optional($duty->duty_date)->format('M d, Y') }}</td>
            <td>{{ $duty->start_time }} - {{ $duty->end_time }}</td>
            <td>{{ $duty->number_of_participants }}</td>
            @php
              $tlName = '';
              if (!empty($duty->team_leader_name)) {
                  $tlName = $duty->team_leader_name;
              } elseif (isset($duty->team_leader) && is_object($duty->team_leader) && isset($duty->team_leader->name)) {
                  $tlName = $duty->team_leader->name;
              }
            @endphp
            <td class="tl-name">{{ $tlName }}</td>
            <td><span class="status-badge status-{{ $duty->status }}">{{ str_replace('_',' ', $duty->status) }}</span></td>
            <td>
              <a href="{{ route('admin.duties.participants', $duty->event_id ?? $duty->id) }}" class="btn btn-primary btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                  <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                  <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                </svg>
                View Participants
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center">No duties found</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if(isset($duties) && method_exists($duties, 'hasPages') && $inProgressDuties->isNotEmpty())
    <div class="pagination">{{ $duties->links() }}</div>
  @endif




@endsection

@section('scripts')
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('searchDuty');
      const tlFilter = document.getElementById('tlFilter');
      const btnSearch = document.getElementById('btnSearch');
      const btnClear = document.getElementById('btnClear');
      const tbody = document.querySelector('.duties-table table tbody');

      if (!tbody) return;

      function applyFilters() {
        const q = (searchInput.value || '').trim().toLowerCase();
        const tlVal = tlFilter.value;
        Array.from(tbody.querySelectorAll('tr')).forEach(row => {
          const tds = row.querySelectorAll('td');
          if (!tds.length) return;

          const title = (tds[0].textContent || '').toLowerCase();
          const tlName = (row.querySelector('.tl-name')?.textContent || '').trim();

          const matchesSearch = !q || title.includes(q) || row.textContent.toLowerCase().includes(q);
          const matchesTl = tlVal === 'all' || 
                          (tlVal === 'with-tl' && tlName && tlName !== '—') || 
                          (tlVal === 'no-tl' && (!tlName || tlName === '—'));

          row.style.display = (matchesSearch && matchesTl) ? '' : 'none';
        });
      }

      // Set up event listeners
      searchInput.addEventListener('input', applyFilters);
      tlFilter.addEventListener('change', applyFilters);
      if (btnSearch) btnSearch.addEventListener('click', applyFilters);
      if (btnClear) btnClear.addEventListener('click', function(){
        searchInput.value = '';
        tlFilter.value = 'all';
        applyFilters();
      });

      // Allow Enter to trigger search
      searchInput.addEventListener('keydown', function(e){ 
        if (e.key === 'Enter') { 
          e.preventDefault(); 
          applyFilters(); 
        } 
      });

      // Initialize modals
      const modals = document.querySelectorAll('.modal');
      modals.forEach(modal => {
        new bootstrap.Modal(modal);
      });

      // Apply initial filters
      applyFilters();

      // Initialize Bootstrap modals
      document.querySelectorAll('.modal').forEach(modalElement => {
        new bootstrap.Modal(modalElement);
      });

      // Mobile menu toggle
      const hamburgerBtn = document.getElementById('hamburgerBtn');
      const mobileSidebar = document.getElementById('mobileSidebar');
      const mobileOverlay = document.getElementById('mobileOverlay');

      if (hamburgerBtn) {
        hamburgerBtn.addEventListener('click', () => {
          mobileSidebar.classList.add('active');
          mobileOverlay.classList.add('active');
          document.body.style.overflow = 'hidden';
        });
      }

      if (mobileOverlay) {
        mobileOverlay.addEventListener('click', () => {
          mobileSidebar.classList.remove('active');
          mobileOverlay.classList.remove('active');
          document.body.style.overflow = '';
        });
      }

      // Close menu when clicking on menu links
      const menuLinks = mobileSidebar.querySelectorAll('.menu-link');
      menuLinks.forEach(link => {
        link.addEventListener('click', () => {
          mobileSidebar.classList.remove('active');
          mobileOverlay.classList.remove('active');
          document.body.style.overflow = '';
        });
      });
    });
  </script>
</div>
@endsection

<!-- Mobile centering, spacing fix and animations (scoped to mobile/animations only) -->
<style>
  @media (max-width: 768px) {
    /* Move mobile contents slightly upwards to reduce empty space under header */
    .content-wrapper { margin-top: 70px !important; padding-top: 8px !important; }

    /* Make duties header more compact on mobile */
    .duties-header { padding: 12px !important; margin-bottom: 12px !important; align-items: center !important; }
    .duties-title { text-align: center !important; width: 100%; }

    /* Center and stack actions and make buttons tappable */
    .duties-actions { width: 100% !important; display:flex !important; flex-direction: column !important; gap: 10px !important; align-items: center !important; }
    .duties-actions .btn { width: calc(100% - 24px) !important; max-width: 420px !important; justify-content: center !important; text-align: center !important; }

    /* Center search controls */
    .search-filters { display: flex !important; flex-direction: column !important; gap: 10px !important; }
    .search-filters .form-control, .search-filters select, .search-filters button { width: 100% !important; }
  }

  /* Button micro-interactions (applies cross-view but doesn't change layout) */
  .btn { transition: transform .14s cubic-bezier(.2,.8,.2,1), box-shadow .14s ease, opacity .12s ease; }
  .btn:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(11,44,105,0.06); }
  .btn:active { transform: translateY(0); }

  /* Entrance animation for header and table */
  .duties-header { transform: translateY(8px); opacity: 0; transition: transform .28s cubic-bezier(.2,.8,.2,1), opacity .28s ease; }
  .duties-header.loaded { transform: translateY(0); opacity: 1; }
  .duties-table { transform: translateY(8px); opacity: 0; transition: transform .36s cubic-bezier(.2,.8,.2,1), opacity .36s ease; }
  .duties-table.loaded { transform: translateY(0); opacity: 1; }

  /* Page-load popup */
  .inprogress-popup { position: fixed; inset: auto 16px 16px auto; z-index: 1300; display: none; }
  .inprogress-popup .panel { background:#fff;padding:12px 14px;border-radius:10px;box-shadow:0 18px 40px rgba(2,6,23,0.12);transform:translateY(8px);opacity:0;transition:transform .22s ease,opacity .22s ease; }
  .inprogress-popup.show { display:block; }
  .inprogress-popup.show .panel { transform:translateY(0); opacity:1; }
</style>
<!-- Participants: mobile sizing, centering and animations (desktop layout unchanged) -->
<style>
  /* Shared animation keyframes used across views (non-layout) */
  @keyframes fadeInUpSmall {
    from { transform: translateY(8px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
  }

  /* Apply gentle entrance animation to modal content and header on show */
  .modal.fade .modal-dialog { transition: transform .28s cubic-bezier(.2,.8,.2,1), opacity .28s ease; }
  .modal.show .modal-dialog { animation: fadeInUpSmall .32s ease both; }

  /* Utility fade-in-up used by rows and panels (web + mobile) */
  .fade-in-up { opacity: 0; transform: translateY(8px); will-change: transform, opacity; animation: fadeInUpSmall .36s cubic-bezier(.2,.8,.2,1) both; }
  .staggered-row { display: table-row; }
  .search-filters.fade-in, .search-container.fade-in { animation: fadeInUpSmall .28s cubic-bezier(.2,.8,.2,1) both; }
  .pagination.fade-in { animation: fadeInUpSmall .28s cubic-bezier(.2,.8,.2,1) both; }

  /* Button micro-interactions and focus ring (no layout change on desktop) */
  .modal .btn, .team-leader-section .btn, .table-responsive .btn {
    transition: transform .12s cubic-bezier(.2,.8,.2,1), box-shadow .12s ease, background-color .12s ease;
  }
  .modal .btn:hover, .team-leader-section .btn:hover, .table-responsive .btn:hover { transform: translateY(-3px); }

  @media (max-width: 768px) {
    /* Move overall page content a bit closer to header on mobile for this page */
    .content-wrapper { margin-top: 48px !important; }

    /* Make modal nearly full-height and nudge upward so it appears closer to header */
    .modal-dialog { max-width: 96vw !important; margin: 8vh auto !important; }
    .modal-content { border-radius: 10px !important; }

    /* Center team-leader button and make tappable */
    .team-leader-section .d-flex { flex-direction: column !important; align-items: center !important; gap: 10px !important; }
    .team-leader-section .btn-warning { width: calc(100% - 28px) !important; max-width: 420px !important; text-align: center !important; padding: 10px 14px !important; font-size: 15px !important; }

    /* Participants table actions: center and make buttons full-width for easy tapping */
    .table-responsive tbody td { vertical-align: middle !important; }
    .table-responsive tbody td:last-child { text-align: center !important; }
    .table-responsive tbody td:last-child .btn {
      display: block !important;
      width: calc(100% - 28px) !important;
      max-width: 420px !important;
      margin: 6px auto !important;
      padding: 10px 14px !important;
      font-size: 15px !important;
      text-align: center !important;
      border-radius: 8px !important;
    }

    /* Modal footer buttons: stack and center on mobile */
    .modal-footer { flex-direction: column !important; gap: 10px !important; align-items: center !important; }
    .modal-footer .btn { width: calc(100% - 28px) !important; max-width: 420px !important; text-align: center !important; }

    /* Entrance animation for modal pieces on mobile as well */
    .modal.show .modal-content { animation: fadeInUpSmall .32s ease both; }
    .modal.show .modal-header, .modal.show .modal-body, .modal.show .modal-footer { animation: fadeInUpSmall .36s ease both; }
  }

  /* Keep desktop layout intact; only non-layout animations allowed */
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Entrance animations
    const hdr = document.querySelector('.duties-header');
    const table = document.querySelector('.duties-table');
    if (hdr) setTimeout(() => hdr.classList.add('loaded'), 60);
    if (table) setTimeout(() => table.classList.add('loaded'), 120);

    // animate the search filters container
    const search = document.querySelector('.search-filters');
    if (search) setTimeout(() => search.classList.add('fade-in'), 90);

    // stagger duties table rows for a nicer entrance animation
    const rows = document.querySelectorAll('.duties-table tbody tr');
    rows.forEach((r, i) => {
      r.classList.add('fade-in-up', 'staggered-row');
      r.style.animationDelay = (140 + i * 45) + 'ms';
    });

    // Small, non-blocking page popup that auto-dismisses
    const popup = document.createElement('div');
    popup.className = 'inprogress-popup';
    popup.innerHTML = '<div class="panel">In-progress duties — tap items for details.</div>';
    document.body.appendChild(popup);
    setTimeout(() => popup.classList.add('show'), 140);
    setTimeout(() => { popup.classList.remove('show'); setTimeout(() => popup.remove(), 260); }, 3200);

    // animate pagination if present
    const pag = document.querySelector('.pagination');
    if (pag) setTimeout(() => pag.classList.add('fade-in'), 420);
  });
</script>

<!-- Mobile-specific button sizing, centered text, and upward content shift (desktop unchanged) -->
<style>
  @media (max-width: 768px) {
    /* Move mobile contents slightly upwards to reduce empty space under header */
    .content-wrapper { margin-top: 56px !important; padding-top: 6px !important; }

    /* Ensure header/title is compact and centered on mobile */
    .duties-header, .inprogress-header { padding: 10px 12px !important; margin-bottom: 10px !important; }
    .duties-title, .inprogress-title { text-align: center !important; width: 100%; }

    /* Stack and center action groups (keeps desktop layout untouched) */
    .duties-actions, .inprogress-actions { display:flex !important; flex-direction:column !important; gap:10px !important; align-items:center !important; justify-content:center !important; }

    /* Make buttons more tappable, center text and icons, and limit max width */
    .duties-actions .btn, .inprogress-actions .btn, .btn-action, .btn {
      width: calc(100% - 28px) !important;
      max-width: 420px !important;
      padding: 12px 16px !important;
      font-size: 15px !important;
      text-align: center !important;
      justify-content: center !important;
      align-items: center !important;
      border-radius: 8px !important;
      box-sizing: border-box !important;
    }

    /* Ensure icons inside buttons are spaced consistently when centered */
    .duties-actions .btn i, .inprogress-actions .btn i, .btn-action i { margin-right: 8px; }

    /* Slightly tighten vertical spacing for lists/tables on mobile */
    .duties-table, .inprogress-table { margin-top: 6px !important; }
  }

  /* Micro-interactions preserved (no layout changes on desktop) */
  .btn, .btn-action { transition: transform .12s cubic-bezier(.2,.8,.2,1), box-shadow .12s ease, opacity .12s ease; }
  .btn:hover, .btn-action:hover { transform: translateY(-3px); }
  .btn:active, .btn-action:active { transform: translateY(0); }
</style>

