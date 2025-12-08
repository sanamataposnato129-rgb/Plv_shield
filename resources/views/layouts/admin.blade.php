<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PLV - SHIELD Admin Dashboard - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/admin/admin-dashboard.css') }}" />
    @yield('styles')
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

        <!-- HEADER -->
        <header>
            <div class="header-left">
                <img src="{{ asset('ASSETS/shield-logo.png') }}" alt="PLV SHIELD Logo" class="logo" />
                <h1>PLV - SHIELD</h1>
            </div>
        </header>

        @isset($error)
            <div style="margin:12px;">
                <div class="alert alert-danger">{{ $error }}</div>
            </div>
        @endisset

        <div class="main-content">
            <!-- SIDEBAR -->
            <div class="sidebar">
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

            <!-- CONTENT -->
            <div class="content-area">
                <div class="admin-container">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('hamburgerBtn').onclick = () => {
            document.getElementById('mobileSidebar').classList.add('active');
            document.getElementById('mobileOverlay').classList.add('active');
        };

        document.getElementById('mobileOverlay').onclick = () => {
            document.getElementById('mobileSidebar').classList.remove('active');
            document.getElementById('mobileOverlay').classList.remove('active');
        };

        document.querySelectorAll('.mobile-sidebar .menu-link').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('mobileSidebar').classList.remove('active');
                document.getElementById('mobileOverlay').classList.remove('active');
            });
        });
    </script>

    @yield('scripts')
</body>
</html>