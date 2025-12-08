<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PLV - SHIELD Team Leader</title>
  <link rel="stylesheet" href="{{ asset('css/member/team-leader.css') }}" />
</head>
  <style>
    /* ==================== GLOBAL LAYOUT ==================== */
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
    }

    /* Fixed Header */
    header {
      background: linear-gradient(to right, #000066, #191970);
      color: #FFD700;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 15px 20px;
      border-bottom: 3px solid #8000FF;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 3000;
    }

    .logo {
      height: 50px;
      margin-right: 15px;
    }

    .header-left {
      display: flex;
      align-items: center;
    }

    header h1 {
      font-size: 18px;
      font-weight: 800;
    }

    /* Main Content */
    .main-content {
      display: flex;
      margin-top: 90px; /* Add space for the fixed header */
      min-height: calc(100vh - 90px);
    }

    /* Sidebar */
    .sidebar {
      width: 240px;
      flex-shrink: 0;
      background: linear-gradient(to bottom, #000066, #0A0A40);
      padding: 20px 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      height: calc(100vh - 90px);
      position: sticky;
      top: 90px; /* Stick below the fixed header */
      overflow-y: auto;
    }

    /* Content Area */
    .content-area {
      flex: 1;
      background: #FFF8DC;
      padding: 30px 20px;
      overflow-y: auto;
    }

    /* ==================== HAMBURGER MENU ==================== */
    .hamburger {
      display: none;
      position: fixed;
      top: 20px;
      left: 20px;
      z-index: 3000;
      background: #191970;
      color: #FFD700;
      border: none;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      font-size: 24px;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
      align-items: center;
      justify-content: center;
    }

    .hamburger:active {
      transform: scale(0.95);
    }

    .mobile-sidebar-overlay {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.6);
      z-index: 2500;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }

    .mobile-sidebar-overlay.active {
      opacity: 1;
      visibility: visible;
    }

    .mobile-sidebar {
      position: fixed;
      top: 0;
      left: -280px;
      width: 280px;
      height: 100vh;
      background: linear-gradient(to bottom, #000066, #0A0A40);
      z-index: 2600;
      padding: 120px 20px 20px;
      transition: left 0.35s cubic-bezier(0.25, 0.8, 0.25, 1);
      box-shadow: 4px 0 20px rgba(0, 0, 0, 0.3);
      overflow-y: auto;
    }

    .mobile-sidebar.active {
      left: 0;
    }

    .mobile-sidebar .sidebar-title {
      color: #FFD700;
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 30px;
      text-align: center;
    }

    .mobile-sidebar .menu li a.menu-link {
      padding: 14px 20px;
      border-radius: 12px;
      margin-bottom: 8px;
      color: white;
      text-decoration: none;
      display: flex;
      align-items: center;
    }

    .mobile-sidebar .menu li a.menu-link img.icon {
      width: 22px;
      height: 22px;
      margin-right: 12px;
      filter: brightness(0) invert(1);
    }

    .mobile-sidebar .menu li:hover a.menu-link,
    .mobile-sidebar .menu li.active a.menu-link {
      background: #FFD700;
      color: black;
      border-radius: 12px;
    }

    .mobile-sidebar .logout-form {
      margin-top: 40px;
      width: 100%;
      display: flex;
      justify-content: center;
    }

    /* Mobile View Adjustments */
    @media (max-width: 768px) {
      .hamburger {
        display: flex !important;
      }

      .sidebar {
        display: none !important;
      }

      header {
        padding-left: 80px !important;
      }

      .content-area {
        padding: 20px 15px;
      }

      .main-content {
        flex-direction: column;
      }
    }

    @media (max-width: 480px) {
      .content-area {
        padding: 15px 10px;
      }

      header h1 {
        font-size: 16px;
      }

      .logo {
        height: 40px;
      }
    }
  </style>
<body>
  <div class="container">
    <header>
      <div class="header-left">
        <img src="{{ asset('ASSETS/shield-logo.png') }}" alt="PLV SHIELD Logo" class="logo" />
        <h1>PLV - SHIELD</h1>
      </div>
    </header>

  <!-- Hamburger Button (Mobile Only) -->
  <button class="hamburger" id="hamburgerBtn" aria-label="Open Menu">
    <i class="fas fa-bars"></i>
  </button>

  <!-- Mobile Sidebar Overlay -->
  <div class="mobile-sidebar-overlay" id="mobileOverlay"></div>

  <!-- Mobile Sidebar -->
  <div class="mobile-sidebar" id="mobileSidebar">
    <h3 class="sidebar-title">Team Leader</h3>
    <ul class="menu">
      <li><a href="{{ route('member.profile') }}" class="menu-link"><img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon"> Profile</a></li>
      <li><a href="{{ route('member.announcement') }}" class="menu-link"><img src="{{ asset('ASSETS/announce-icon.png') }}" class="icon"> Announcement</a></li>
      <li><a href="{{ route('member.duties') }}" class="menu-link"><img src="{{ asset('ASSETS/viewreport-icon.png') }}" class="icon"> Duties</a></li>
      <li><a href="{{ route('member.duty-history') }}" class="menu-link"><img src="{{ asset('ASSETS/history-icon.png') }}" class="icon"> Duty History</a></li>
    </ul>
    <form method="POST" action="{{ route('student.logout') }}" class="logout-form">
      @csrf
      <button class="logout-btn" type="submit">Logout</button>
    </form>
  </div>

      <main class="content-area">
        <h2>Team Leader Panel</h2>
        <p>Team leader specific controls go here.</p>
      </main>
    </div>
  </div>
  
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const hamburger = document.getElementById('hamburgerBtn');
      const mobileSidebar = document.getElementById('mobileSidebar');
      const overlay = document.getElementById('mobileOverlay');

      function openMenu() {
        mobileSidebar.classList.add('active');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent background scroll
      }

      function closeMenu() {
        mobileSidebar.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
      }

      hamburger?.addEventListener('click', openMenu);
      overlay?.addEventListener('click', closeMenu);

      // Close when clicking any menu link
      document.querySelectorAll('.mobile-sidebar .menu-link').forEach(link => {
        link.addEventListener('click', closeMenu);
      });

      // Optional: Close with Escape key
      document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && mobileSidebar.classList.contains('active')) {
          closeMenu();
        }
      });
    });
  </script>
</body>
</html>