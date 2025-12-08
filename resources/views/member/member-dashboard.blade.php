<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLV - SHIELD Member Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/member/member-dashboard.css') }}" />
</head>
<style>
     .sidebar {
      background: linear-gradient(to bottom, #000066, #0A0A40);
      width: 240px;
      padding: 20px 0;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .sidebar-title {
      color: #FFD700;
      font-weight: bold;
      margin-bottom: 20px;
      font-size: 18px;
      text-align: center;
    }
    .menu {
      list-style: none;
      width: 100%;
      padding: 0;
      margin: 0;
    }
    .menu li {
      color: white;
      padding: 12px 25px;
      display: flex;
      align-items: center;
      transition: 0.3s;
      cursor: pointer;
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
    .logout-form {
      margin-top: auto;
      margin-bottom: 20px;
      width: 100%;
      display: flex;
      justify-content: center;
      padding: 0;
    }
    .logout-btn {
      background-color: #FFD700;
      color: black;
      font-weight: bold;
      border: none;
      padding: 10px 30px;
      border-radius: 30px;
      cursor: pointer;
      transition: all 0.3s ease;
      font-size: 14px;
    }
    .logout-btn:hover {
      background-color: #ffea00;
      transform: scale(1.05);
      box-shadow: 0 0 15px rgba(255, 215, 0, 0.8);
    }
  </style>
<body>
    <div class="container">
        <!-- HEADER -->
        <header>
            <div class="header-left">
                <img src="{{ asset('ASSETS/shield-logo.png') }}" alt="PLV SHIELD Logo" class="logo" />
                <h1>PLV - SHIELD</h1>
            </div>
        </header>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <!-- SIDEBAR -->
            <div class="sidebar">
                <h3 class="sidebar-title">Dashboard</h3>
                <ul class="menu">
                    <li class="active"><a href="{{ route('member.dashboard') }}" class="menu-link"><img src="{{ asset('ASSETS/home-icon.png') }}" class="icon">Dashboard</a></li>
                    <li><a href="{{ route('member.profile') }}" class="menu-link"><img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon">Profile</a></li>
                    <li><a href="{{ route('member.announcement') }}" class="menu-link"><img src="{{ asset('ASSETS/announce-icon.png') }}" class="icon">Announcement</a></li>
                    <li><a href="{{ route('member.duties') }}" class="menu-link"><img src="{{ asset('ASSETS/viewreport-icon.png') }}" class="icon">Duties</a></li>
                    <li><a href="{{ route('member.duty-history') }}" class="menu-link"><img src="{{ asset('ASSETS/history-icon.png') }}" class="icon">Duty History</a></li>
                    @if(Auth::guard('student')->user()->is_team_leader)
                    <li><a href="{{ route('member.team-leader') }}" class="menu-link"><img src="{{ asset('ASSETS/team-icon.png') }}" class="icon">Team Leader</a></li>
                    @endif
                </ul>
                <form method="POST" action="{{ route('student.logout') }}">
                    @csrf
                    <button class="logout-btn" type="submit">Logout</button>
                </form>
            </div>

            <!-- CONTENT AREA -->
            <main class="content-area">
                <h2>Welcome to Your Dashboard</h2>

                @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Quick Links Section -->
                <div class="quick-links">
                    <div class="link-card">
                        <img src="{{ asset('ASSETS/viewreport-icon.png') }}" alt="Duties Icon">
                        <h3>Current Duties</h3>
                        <p>View and manage your assigned duties</p>
                        <a href="{{ route('member.duties') }}" class="card-link">View Duties</a>
                    </div>

                    <div class="link-card">
                        <img src="{{ asset('ASSETS/announce-icon.png') }}" alt="Announcements Icon">
                        <h3>Announcements</h3>
                        <p>Check latest updates and notices</p>
                        <a href="{{ route('member.announcement') }}" class="card-link">View Announcements</a>
                    </div>

                    <div class="link-card">
                        <img src="{{ asset('ASSETS/history-icon.png') }}" alt="History Icon">
                        <h3>Duty History</h3>
                        <p>Review your completed duties</p>
                        <a href="{{ route('member.duty-history') }}" class="card-link">View History</a>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>