<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'PLV - SHIELD')</title>
  <link rel="stylesheet" href="{{ asset('css/member/member-announcement.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/member/member-profile.css') }}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-pap6V+o2X1a1k6+XkzG5QeXQ1+7qzO1q0R6a9WQdZq5pQe0nY6Fq9z6b1yZxK7d6E1z6z1aA6L3xg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    
  /* ==================== LAYOUT & SCROLL FIX ==================== */
  header {
    background: linear-gradient(to right, #000066, #191970);
    color: #FFD700;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 40px;
    border-bottom: 3px solid #8000FF;
    flex-shrink: 0;
  }
  .logo { height: 60px; margin-right: 15px; }
  .header-left { display: flex; align-items: center; }
  header h1 { font-size: 28px; font-weight: 800; }

  .main-content {
    display: flex;
    min-height: calc(100vh - 90px);
    overflow: hidden;                    /* Prevents whole page scroll */
  }

  .sidebar {
    width: 240px;
    flex-shrink: 0;
    background: linear-gradient(to bottom, #000066, #0A0A40);
    padding: 20px 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    height: calc(100vh - 90px);          /* Full height minus header */
    position: sticky;
    top: 0;
    overflow-y: auto;                    /* Only if sidebar content is very long */
  }

  .content-area {
    flex: 1;
    background: #FFF8DC;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    overflow-y: auto;                    /* Only content area scrolls */
    height: calc(100vh - 90px);
  }

  .announcement-header {
    background: linear-gradient(to right, #000066, #191970);
    color: #FFD700;
    font-size: 24px;
    font-weight: bold;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 30px;
    text-align: center;
    width: 100%;
    max-width: 1250px;
  }

  .announcement-list {
    display: flex;
    flex-direction: column;
    align-items: stretch;
    gap: 1.5rem;
    width: 100%;
    max-width: 1250px;
    padding: 0 20px;
    margin: 0 auto;
  }

  /* Sidebar Menu */
  .sidebar-title {
    color: #FFD700;
    font-weight: bold;
    margin-bottom: 20px;
    font-size: 18px;
    text-align: center;
  }
  .menu { list-style: none; width: 100%; padding: 0; margin: 0; }
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
    /* Responsive adjustments for the dashboard */
    .admin-container {
      padding: 20px;
    }

    .info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }

    .info-item {
      background: #f9f9f9;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .quick-actions {
      margin-top: 20px;
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
    }

    .action-btn {
      display: flex;
      align-items: center;
      background: #191970;
      color: #fff;
      padding: 10px 15px;
      border-radius: 8px;
      text-decoration: none;
      transition: background 0.3s;
    }

    .action-btn:hover {
      background: #000066;
    }

    .action-btn img.icon {
      width: 20px;
      height: 20px;
      margin-right: 10px;
    }

    /* Mobile adjustments */
    @media (max-width: 768px) {
      .admin-header {
        flex-direction: column;
        align-items: flex-start;
      }

      .create-account-btn {
        margin-top: 10px;
      }

      .info-grid {
        grid-template-columns: 1fr;
      }

      .quick-actions {
        flex-direction: column;
      }
    }

    /* Include the earlier CSS for the hamburger menu and mobile sidebar */
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
      transition: all 0.3s ease;
      align-items: center;
      justify-content: center;
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
      padding: 80px 20px 20px;
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
        padding: 100px 20px 40px !important;
      }
    }

    @media (max-width: 480px) {
      .content-area {
        padding: 90px 15px 30px !important;
      }
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header style="background: #191970; color: #FFD700; padding: 15px; display: flex; align-items: center; justify-content: space-between;">
    <div style="display: flex; align-items: center;">
      <img src="{{ asset('ASSETS/shield-logo.png') }}" alt="PLV SHIELD Logo" style="height: 40px; margin-right: 10px;">
      <h1 style="font-size: 20px; margin: 0;">PLV - SHIELD</h1>
    </div>
    <div>
      <span>Welcome, {{ auth('admin')->user()->first_name ?? 'Admin' }}</span>
    </div>
  </header>

  <!-- Hamburger Button -->
  <button class="hamburger" id="hamburgerBtn" aria-label="Open Menu">
    <i class="fas fa-bars"></i>
  </button>

  <!-- Mobile Sidebar Overlay -->
  <div class="mobile-sidebar-overlay" id="mobileOverlay"></div>

  <!-- Mobile Sidebar -->
  <div class="mobile-sidebar" id="mobileSidebar">
    <h3 class="sidebar-title">Dashboard</h3>
    @yield('sidebar') <!-- Sidebar content will be injected here -->
  </div>

  <!-- Main Content -->
  <div class="container">
    @yield('content')
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const hamburger = document.getElementById('hamburgerBtn');
      const mobileSidebar = document.getElementById('mobileSidebar');
      const overlay = document.getElementById('mobileOverlay');

      function openMenu() {
        mobileSidebar.classList.add('active');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
      }

      function closeMenu() {
        mobileSidebar.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
      }

      hamburger?.addEventListener('click', openMenu);
      overlay?.addEventListener('click', closeMenu);

      document.querySelectorAll('.mobile-sidebar .menu-link').forEach(link => {
        link.addEventListener('click', closeMenu);
      });

      document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && mobileSidebar.classList.contains('active')) {
          closeMenu();
        }
      });
    });
  </script>
</body>
</html>