@extends('layouts.admin')

@section('title', 'Create Duties')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/create-duties.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/admin-dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Make View button obvious and clickable */
        .view-duty { cursor: pointer; }

        /* Improve small Edit button appearance */
        .btn-sm.btn-primary {
            background: #3a2b72;
            border: 1px solid rgba(0,0,0,0.05);
            color: #fff;
            padding: 6px 10px;
            border-radius: 6px;
        }

        /* Modal styles */
        .modal-dialog {
            max-width: 600px;
        }
        .modal.show {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 1.5rem;
            min-height: 100vh;
        }

        .modal.show .modal-dialog {
            margin: 0 !important;
        }
        .modal-content {
            border-radius: 8px;
        }
        /* Floating X close button inside modal (visible on web & mobile) */
        .modal-close-x {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(11,44,105,0.95);
            color: #fff;
            border: none;
            cursor: pointer;
            box-shadow: 0 8px 18px rgba(2,6,23,0.18);
            z-index: 1200;
            font-size: 18px;
            line-height: 1;
        }
        .modal-close-x:focus { outline: none; box-shadow: 0 0 0 3px rgba(11,44,105,0.12); }
        @media (max-width: 480px) {
            .modal-close-x { width: 32px; height: 32px; top: 8px; right: 8px; font-size: 16px; }
        }
        .form-label {
            font-weight: 600;
            color: #22243a;
            font-size: 0.95rem;
        }
        .modal-body .form-control {
            border-radius: 12px;
            padding: 0.6rem 0.9rem;
            background: #fff;
        }
        .modal-body .modal-section {
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(0,0,0,0.03);
            margin-bottom: 0.75rem;
        }
        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
        .modal-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }
        
        /* HEADER - STICKY AT TOP */
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 200;
            background: linear-gradient(to right, #000066, #191970)
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
            padding: 20px;
            min-height: calc(100vh - 90px);
        }

        /* Hamburger and mobile sidebar for mobile view */
        @media (max-width: 768px) {
            .hamburger {
                display: flex;
            }
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

            .duties-table {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .duties-table table {
                min-width: 600px;
            }

            .modal-dialog {
                max-width: 95%;
            }

            .modal.show {
                padding: 1rem;
            }

            .row {
                display: flex;
                flex-wrap: wrap;
            }

            .col-md-6 {
                width: 100%;
                margin-bottom: 10px;
            }

            .modal-section {
                margin-bottom: 1rem;
                padding-bottom: 1rem;
            }

            .form-control,
            .form-select {
                padding: 10px 12px;
                font-size: 16px;
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

            .search-filters {
                padding: 12px;
                gap: 8px;
            }

            .search-filters .form-control {
                font-size: 13px;
                padding: 8px 10px;
            }

            .modal-dialog {
                max-width: 100%;
            }

            .modal-content {
                border-radius: 6px;
            }

            .modal-header {
                padding: 12px 16px;
            }

            .modal-body {
                padding: 16px 12px;
            }

            .modal-footer {
                padding: 12px 16px;
                flex-direction: column-reverse;
                gap: 8px;
            }

            .modal-footer .btn {
                width: 100%;
            }

            .form-label {
                font-size: 14px;
            }

            .alert {
                padding: 10px 12px;
                font-size: 13px;
                margin-bottom: 15px;
            }

            .modal-section {
                margin-bottom: 1rem;
                padding: 0;
                border-bottom: 1px solid rgba(0,0,0,0.03);
            }

            .modal-section:last-child {
                border-bottom: none;
            }

            .col-md-6 {
                width: 100%;
                margin-bottom: 12px;
            }

            .row {
                margin-right: 0;
                margin-left: 0;
                display: flex;
                flex-direction: column;
            }

            .text-md-end {
                text-align: left;
            }

            .mt-md-0 {
                margin-top: 10px;
            }
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
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            gap: 15px;
        }

        .duties-title {
            font-size: 24px;
            font-weight: 700;
            color: #000066;
            margin: 0;
            text-align: center;
            width: 100%;
        }

        .duties-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            width: 100%;
            flex-wrap: wrap;
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
            margin-right: 8px;
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
            flex-wrap: wrap;
            gap: 12px;
            align-items: flex-start;
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

        .search-filters select {
            order: 3;
            width: 100%;
            max-width: 220px;
        }

        .search-filters input[type="text"] {
            order: 1;
            flex: 1;
            min-width: 200px;
        }

        .search-filters button {
            order: 2;
        }

        .duties-table {
            background: white;
            border-radius: 8px;
            overflow-x: auto;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .duties-table table {
            width: 100%;
            margin: 0;
            border-collapse: collapse;
            min-width: 700px;
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

        .btn-info {
            background: #17a2b8;
            color: white;
        }

        .btn-info:hover {
            background: #138496;
        }

        .btn-warning {
            background: #ffc107;
            color: #000;
        }

        .btn-warning:hover {
            background: #ffb300;
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

        /* Additional mobile form styling */
        .row {
            margin-right: calc(var(--bs-gutter-x, 0.75rem) * -0.5);
            margin-left: calc(var(--bs-gutter-x, 0.75rem) * -0.5);
        }

        .col-12, .col-md-6 {
            flex: 0 0 auto;
            width: 100%;
        }

        @media (min-width: 768px) {
            .col-md-6 {
                width: 50%;
            }
        }

        .form-control,
        .form-select {
            display: block;
            width: 100%;
            padding: 0.6rem 0.9rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

    </style>
    <style>
        /* Ensure duties table is horizontally scrollable on small screens only */
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
    </style>
@endsection

@section('content')
<!-- HAMBURGER BUTTON (mobile only) -->
<button class="hamburger" id="hamburgerBtn" aria-label="Open Menu" style="display:none;">
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
        <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon">Profile
            </a>
        </li>
        <li class="{{ Request::is('admin/approvals') ? 'active' : '' }}">
            <a href="{{ route('admin.approvals') }}" class="menu-link">
                <img src="{{ asset('ASSETS/checkreport-icon.png') }}" class="icon">Approvals
            </a>
        </li>
        <li class="{{ Request::is('admin/students*') ? 'active' : '' }}">
            <a href="{{ route('admin.students.index') }}" class="menu-link">
                <img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon">Students
            </a>
        </li>
        <li class="{{ Request::is('admin/create-duties') ? 'active' : '' }}">
            <a href="{{ route('admin.create-duties') }}" class="menu-link">
                <img src="{{ asset('ASSETS/createduty-icon.png') }}" class="icon">Duties
            </a>
        </li>
        <li class="{{ Request::is('admin/in-progress') ? 'active' : '' }}">
            <a href="{{ route('admin.in-progress') }}" class="menu-link">
                <img src="{{ asset('ASSETS/in-progress-icon.png') }}" class="icon">In Progress
            </a>
        </li>
        <li class="{{ Request::is('admin/view-reports') ? 'active' : '' }}">
            <a href="{{ route('admin.view-reports') }}" class="menu-link">
                <img src="{{ asset('ASSETS/viewreport-icon.png') }}" class="icon">View Reports
            </a>
        </li>
        <li class="{{ Request::is('admin/history') ? 'active' : '' }}">
            <a href="{{ route('admin.history') }}" class="menu-link">
                <img src="{{ asset('ASSETS/history-icon.png') }}" class="icon">History
            </a>
        </li>
    </ul>
    <form method="POST" action="{{ route('admin.logout') }}" class="logout-form">
        @csrf
        <button type="submit" class="logout-btn">Logout</button>
    </form>
</div>
<div class="content-wrapper" style="margin-top:100px !important; padding-top:12px !important;">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="duties-header">
        <h2 class="duties-title">Manage Event Duties</h2>
        <div class="duties-actions">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDutyModal">
                <i class="fas fa-plus"></i> Create New Duty
            </button>
            <button class="btn btn-secondary" onclick="refreshTable()">
                <i class="fas fa-sync"></i> Refresh
            </button>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.create-duties') }}" class="search-filters" style="margin:1rem 0;display:flex;gap:0.5rem;align-items:center;">
        <input type="text" name="search" class="form-control" placeholder="Search duties..." value="{{ $search ?? '' }}">
        <select class="form-control" name="status" style="width:220px;">
            <option value="">All Statuses</option>
            <option value="OPEN" {{ (isset($status) && $status=='OPEN')? 'selected': '' }}>Open</option>
            <option value="IN_PROGRESS" {{ (isset($status) && $status=='IN_PROGRESS')? 'selected': '' }}>In Progress</option>
            <option value="CERTIFIED" {{ (isset($status) && $status=='CERTIFIED')? 'selected': '' }}>Certified</option>
            <option value="COMPLETED" {{ (isset($status) && $status=='COMPLETED')? 'selected': '' }}>Completed</option>
            <option value="CANCELLED" {{ (isset($status) && $status=='CANCELLED')? 'selected': '' }}>Cancelled</option>
        </select>
        <button type="submit" class="btn btn-secondary">Search</button>
    </form>

    <!-- Create Duty Modal -->
    <div class="modal fade" id="createDutyModal" tabindex="-1" aria-labelledby="createDutyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="modal-close-x" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                <div class="modal-header">
                    <h5 class="modal-title" id="createDutyModalLabel">Create New Duty</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.duties.store') }}" method="POST" id="createDutyForm">
                        @csrf
                        <div class="container-fluid">
                            <div class="modal-section">
                                <div class="row gx-3">
                                    <div class="col-md-6">
                                        <label for="title" class="form-label">Title</label>
                                        <input id="title" name="title" class="form-control" placeholder="Enter duty title" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="duty_date" class="form-label">Date</label>
                                        <input id="duty_date" name="duty_date" type="date" class="form-control" required
                                               min="{{ \Carbon\Carbon::today()->toDateString() }}">
                                    </div>
                                </div>
                            </div>

                            <div class="modal-section">
                                <div class="row gx-3">
                                    <div class="col-md-6">
                                        <label for="start_time" class="form-label">Start Time</label>
                                        <input id="start_time" name="start_time" type="time" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="end_time" class="form-label">End Time</label>
                                        <input id="end_time" name="end_time" type="time" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-section">
                                <div class="row gx-3">
                                    <div class="col-12">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea id="description" name="description" class="form-control" rows="4" placeholder="Add a short description" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row gx-3 align-items-end">
                                <div class="col-md-6">
                                    <label for="number_of_participants" class="form-label"># Participants</label>
                                    <input id="number_of_participants" name="number_of_participants" type="number" min="0" class="form-control" placeholder="0" required>
                                </div>
                                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                    <div class="modal-footer p-0 border-0 justify-content-end">
                                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Create Duty</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="duties-table">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Participants</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($duties as $duty)
                <tr>
                    <td>{{ $duty->title }}</td>
                    <td>{{ optional($duty->duty_date)->format('M d, Y') }}</td>
                    <td>{{ $duty->formatted_start_time }} - {{ $duty->formatted_end_time }}</td>
                    <td>
                        @php $registered = $duty->registered_count ?? 0; $required = $duty->number_of_participants; @endphp
                        @if($required !== null)
                            {{ $registered }}/{{ $required }}
                        @else
                            {{ $registered }}
                        @endif
                    </td>
                    <td><span class="status-badge status-{{ $duty->status }}">{{ str_replace('_',' ', $duty->status) }}</span></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info view-duty"
                            data-bs-toggle="modal" 
                            data-bs-target="#viewDutyModal"
                            data-title="{{ e($duty->title) }}"
                            data-date="{{ optional($duty->duty_date)->format('M d, Y') }}"
                            data-time="{{ $duty->formatted_start_time }} - {{ $duty->formatted_end_time }}"
                            data-participants="{{ $duty->number_of_participants }}"
                            data-status="{{ $duty->status }}"
                            data-description="{{ e($duty->description ?? '') }}"
                        >View</button>

                        <button type="button" class="btn btn-sm btn-primary edit-duty"
                            data-bs-toggle="modal" 
                            data-bs-target="#editDutyModal"
                            data-id="{{ $duty->event_id }}"
                            data-title="{{ e($duty->title) }}"
                            data-date="{{ $duty->duty_date }}"
                            data-start-time="{{ $duty->start_time }}"
                            data-end-time="{{ $duty->end_time }}"
                            data-participants="{{ $duty->number_of_participants }}"
                            data-status="{{ $duty->status }}"
                            data-description="{{ e($duty->description ?? '') }}"
                        >Edit</button>

                        <form action="{{ route('admin.duties.destroy', $duty->event_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete duty?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No duties found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($duties->hasPages())
    <div class="pagination">{{ $duties->links() }}</div>
    @endif
    <!-- View Duty Modal -->
    <div class="modal fade" id="viewDutyModal" tabindex="-1" aria-labelledby="viewDutyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 450px;">
            <div class="modal-content" style="border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                <div class="modal-header" style="background: #f8f9fa; border-bottom: 1px solid #dee2e6; border-radius: 12px 12px 0 0;">
                    <h5 class="modal-title detail-title" id="viewDutyModalLabel" style="font-size: 1.25rem; font-weight: 600; color: #22243a;"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 1.5rem;">
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 0.75rem; border-bottom: 1px solid #e9ecef;">
                            <span style="font-weight: 600; color: #22243a; min-width: 100px;">Date:</span>
                            <span class="detail-date" style="color: #495057; text-align: right;"></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 0.75rem; border-bottom: 1px solid #e9ecef;">
                            <span style="font-weight: 600; color: #22243a; min-width: 100px;">Time:</span>
                            <span class="detail-time" style="color: #495057; text-align: right;"></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 0.75rem; border-bottom: 1px solid #e9ecef;">
                            <span style="font-weight: 600; color: #22243a; min-width: 100px;">Participants:</span>
                            <span class="detail-participants" style="color: #495057; text-align: right;"></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 0.75rem; border-bottom: 1px solid #e9ecef;">
                            <span style="font-weight: 600; color: #22243a; min-width: 100px;">Status:</span>
                            <span class="detail-status" style="color: #495057; text-align: right;"></span>
                        </div>
                        <div style="padding-top: 0.5rem;">
                            <div style="font-weight: 600; color: #22243a; margin-bottom: 0.5rem;">Description:</div>
                            <div class="detail-description" style="color: #495057; line-height: 1.6; background: #f8f9fa; padding: 0.75rem; border-radius: 6px;"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f8f9fa; border-top: 1px solid #dee2e6; border-radius: 0 0 12px 12px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Duty Modal -->
    <div class="modal fade" id="editDutyModal" tabindex="-1" aria-labelledby="editDutyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDutyModalLabel">Edit Duty</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editDutyForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="container-fluid">
                            <div class="modal-section">
                                <div class="row gx-3">
                                    <div class="col-md-6">
                                        <label for="edit_title" class="form-label">Title</label>
                                        <input id="edit_title" name="title" class="form-control" placeholder="Duty title" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="edit_duty_date" class="form-label">Date</label>
                                        <input id="edit_duty_date" name="duty_date" type="date" class="form-control" required
                                               min="{{ \Carbon\Carbon::today()->toDateString() }}">
                                    </div>
                                </div>
                            </div>

                            <div class="modal-section">
                                <div class="row gx-3">
                                    <div class="col-md-6">
                                        <label for="edit_start_time" class="form-label">Start Time</label>
                                        <input id="edit_start_time" name="start_time" type="time" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="edit_end_time" class="form-label">End Time</label>
                                        <input id="edit_end_time" name="end_time" type="time" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-section">
                                <div class="row gx-3">
                                    <div class="col-12">
                                        <label for="edit_description" class="form-label">Description</label>
                                        <textarea id="edit_description" name="description" class="form-control" rows="4" placeholder="Short description" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row gx-3 align-items-end">
                                <div class="col-md-6">
                                    <label for="edit_number_of_participants" class="form-label"># Participants</label>
                                    <input id="edit_number_of_participants" name="number_of_participants" type="number" min="0" class="form-control" placeholder="0" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit_status" class="form-label">Status</label>
                                    <select id="edit_status" name="status" class="form-control" required>
                                        <option value="OPEN">Open</option>
                                        <option value="IN_PROGRESS">In Progress</option>
                                        <option value="CERTIFIED">Certified</option>
                                        <option value="COMPLETED">Completed</option>
                                        <option value="CANCELLED">Cancelled</option>
                                    </select>
                                </div>
                                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                    <div class="modal-footer p-0 border-0 justify-content-end">
                                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Update Duty</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.getElementById('hamburgerBtn').onclick = () => {
        document.getElementById('mobileSidebar').classList.add('active');
        document.getElementById('mobileOverlay').classList.add('active');
        document.body.style.overflow = 'hidden';
    };
    document.getElementById('mobileOverlay').onclick = () => {
        document.getElementById('mobileSidebar').classList.remove('active');
        document.getElementById('mobileOverlay').classList.remove('active');
        document.body.style.overflow = '';
    };
    document.querySelectorAll('.mobile-sidebar .menu-link').forEach(link => {
        link.addEventListener('click', () => {
            document.getElementById('mobileSidebar').classList.remove('active');
            document.getElementById('mobileOverlay').classList.remove('active');
            document.body.style.overflow = '';
        });
    });
</script>
    <script>
    function refreshTable() { 
        window.location.reload(); 
    }

    // Time validation function
    function setupTimeValidation(startTimeId, endTimeId) {
        const startTimeInput = document.getElementById(startTimeId);
        const endTimeInput = document.getElementById(endTimeId);

        if (!startTimeInput || !endTimeInput) return;

        function updateMinEndTime() {
            const startTime = startTimeInput.value;
            if (startTime) {
                endTimeInput.min = startTime;
                if (endTimeInput.value && endTimeInput.value < startTime) {
                    endTimeInput.value = startTime;
                }
            }
        }

        function updateMaxStartTime() {
            const endTime = endTimeInput.value;
            if (endTime) {
                startTimeInput.max = endTime;
                if (startTimeInput.value && startTimeInput.value > endTime) {
                    startTimeInput.value = endTime;
                }
            }
        }

        startTimeInput.addEventListener('change', updateMinEndTime);
        endTimeInput.addEventListener('change', updateMaxStartTime);

        // Initial validation
        updateMinEndTime();
        updateMaxStartTime();
    }

    document.addEventListener('DOMContentLoaded', function(){
        // Setup time validation for create form
        setupTimeValidation('start_time', 'end_time');
        // Setup time validation for edit form
        setupTimeValidation('edit_start_time', 'edit_end_time');
        // View duty details
        const viewDutyModal = document.getElementById('viewDutyModal');
        if (viewDutyModal) {
            viewDutyModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const title = button.getAttribute('data-title');
                const date = button.getAttribute('data-date');
                const time = button.getAttribute('data-time');
                const participants = button.getAttribute('data-participants');
                const status = button.getAttribute('data-status');
                const description = button.getAttribute('data-description');

                this.querySelector('.detail-title').innerText = title;
                this.querySelector('.detail-date').innerText = date;
                this.querySelector('.detail-time').innerText = time;
                this.querySelector('.detail-participants').innerText = participants;
                this.querySelector('.detail-status').innerText = status.replace(/_/g,' ');
                this.querySelector('.detail-description').innerText = description;
            });
        }

        // Edit duty details
        const editDutyModal = document.getElementById('editDutyModal');
        if (editDutyModal) {
            editDutyModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const dutyId = button.getAttribute('data-id');
                const title = button.getAttribute('data-title');
                const date = button.getAttribute('data-date');
                const startTime = button.getAttribute('data-start-time');
                const endTime = button.getAttribute('data-end-time');
                const participants = button.getAttribute('data-participants');
                const description = button.getAttribute('data-description');
                const status = button.getAttribute('data-status');

                const form = this.querySelector('#editDutyForm');
                form.action = '/admin/duties/' + dutyId;
                
                form.querySelector('#edit_title').value = title;
                form.querySelector('#edit_duty_date').value = date;
                form.querySelector('#edit_start_time').value = startTime;
                form.querySelector('#edit_end_time').value = endTime;
                form.querySelector('#edit_number_of_participants').value = participants;
                form.querySelector('#edit_description').value = description;
                // set status selection if present
                if (status && form.querySelector('#edit_status')) {
                    try {
                        form.querySelector('#edit_status').value = status;
                    } catch (e) {
                        // ignore if value not found in select
                    }
                }
            });
        }
    });
    </script>
@endsection
<!-- Mobile centering fixes and entrance animations (no desktop layout changes) -->
<style>
    @media (max-width: 768px) {
        /* reduce blank space under header on mobile */
        .duties-header { margin-bottom: 8px !important; padding: 12px !important; }
        .duties-title { font-size: 20px !important; }
        /* ensure actions are centered and buttons full-width on mobile */
        .duties-actions { flex-direction: column !important; align-items: center !important; gap: 10px !important; }
        .duties-actions .btn { width: calc(100% - 24px) !important; max-width: 420px !important; justify-content: center !important; text-align: center !important; }
        /* center icon + text and reduce icon gap so text remains centered visually */
        .duties-actions .btn i { margin-right: 8px; }
        .btn { justify-content: center !important; text-align: center !important; }
        .btn .fa, .btn .fas { vertical-align: middle; }
        .search-filters { gap: 10px !important; }
    }

    /* Button animations (applies to web & mobile without changing layout) */
    .btn { transition: transform .12s cubic-bezier(.2,.8,.2,1), box-shadow .12s ease, opacity .12s ease; }
    .btn:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(11,44,105,0.06); }
    .btn:active { transform: translateY(0); }

    /* Subtle entrance animation for header and actions on page load */
    .duties-header { transform: translateY(6px); opacity: 0; transition: transform .28s cubic-bezier(.2,.8,.2,1), opacity .28s ease; }
    .duties-header.loaded { transform: translateY(0); opacity: 1; }

    /* Popup panel for optional page-load info (hidden by default) */
    .page-popup { display:none; position: fixed; inset: auto 16px 16px auto; z-index: 1300; max-width: 340px; }
    .page-popup .panel { background:#fff; padding:12px 14px; border-radius:10px; box-shadow: 0 18px 40px rgba(2,6,23,0.12); transform: translateY(8px) scale(.995); opacity:0; transition: transform .22s cubic-bezier(.2,.8,.2,1), opacity .22s ease; }
    .page-popup.show { display:block; }
    .page-popup.show .panel { transform: translateY(0) scale(1); opacity:1; }
</style>

<script>
    // Trigger entrance animations on page load for duties view
    document.addEventListener('DOMContentLoaded', function () {
        const hdr = document.querySelector('.duties-header');
        if (hdr) setTimeout(() => hdr.classList.add('loaded'), 60);

        // Optional small popup that appears on page load and fades after 3s
        const popup = document.createElement('div');
        popup.className = 'page-popup';
        popup.innerHTML = '<div class="panel">Manage duties — quick actions available.</div>';
        document.body.appendChild(popup);
        setTimeout(() => { popup.classList.add('show'); }, 120);
        setTimeout(() => { popup.classList.remove('show'); setTimeout(() => popup.remove(), 260); }, 3200);
    });
</script>
 