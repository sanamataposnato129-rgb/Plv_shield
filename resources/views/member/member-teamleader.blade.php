<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PLV - SHIELD Team Leader</title>
  <link rel="stylesheet" href="{{ asset('css/member/member-announcement.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/member/member-profile.css') }}" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
      body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
    }
  /* ==================== GLOBAL LAYOUT & SCROLL FIX (SAME ACROSS ALL PAGES) ==================== */
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
      width: 100%;
      z-index: 3000;
    }

    .logo {
      height: 60px;
      margin-right: 15px;
    }

    .header-left {
      display: flex;
      align-items: center;
    }

    header h1 {
      font-size: 20px;
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
      padding: 50px 20px;
      overflow-y: auto;
    }

  /* ==================== SIDEBAR MENU ==================== */
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

  /* ==================== TEAM LEADER PAGE STYLES ==================== */
.report-container {
  background: #ffffff;
  border-radius: 12px;
  box-shadow: 0 6px 18px rgba(20, 30, 40, 0.08);
  margin-bottom: 1.5rem;
  width: 100%; /* Ensure it takes the full width of the parent */
  max-width: 100%; /* Prevent overflow */
  padding: 1.5rem;
  box-sizing: border-box; /* Include padding in width calculations */
}

  .info-box {
    background: linear-gradient(90deg, #000066, #191970);
    border-radius: 10px;
    padding: 1.5rem;
    color: #fff;
    margin-bottom: 2rem;
  }
  .info-box h3 { margin: 0; font-size: 1.2rem; font-weight: 600; }
  .info-box .team-leader-name { color: #fff; font-size: 1.25rem; }
  .duty-meta { display: flex; gap: 1.5rem; font-size: 0.95rem; opacity: 0.9; }

  .participants-section {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 2rem;
  }
  .participants-section h3 { margin: 0; font-size: 1.2rem; color: #2c3e50; font-weight: 600; }
  .participants-list { display: flex; flex-direction: column; gap: 0.75rem; margin-top: 1rem; }
  .participant-item {
    background: #fff;
    padding: 1rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    transition: transform 0.2s ease;
  }
  .participant-item:hover { transform: translateX(5px); }
  .no-participants {
    color: #6c757d;
    text-align: center;
    padding: 2rem;
    background: #fff;
    border-radius: 8px;
    font-size: 1.1rem;
  }

  .create-report-btn {
    background: #4169E1;
    color: white;
    border: none;
    padding: 0.8rem 2rem;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }
  .create-report-btn:hover {
    background: #3258c7;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(65, 105, 225, 0.2);
  }

  /* Utility & Button Classes */
  .d-flex { display: flex; }
  .justify-content-between { justify-content: space-between; }
  .justify-content-end { justify-content: flex-end; }
  .align-items-center { align-items: center; }
  .mb-3 { margin-bottom: 1rem; }
  .mb-4 { margin-bottom: 1.5rem; }
  .mt-2 { margin-top: 0.5rem; }
  .mt-4 { margin-top: 1.5rem; }
  .me-1, .me-2, .me-3 { margin-right: 0.5rem; }
  .ms-3 { margin-left: 1rem; }
  .fw-bold { font-weight: 600; }
  .text-muted { color: #6c757d; }
  .text-white { color: white; }
  .text-warning { color: #ffc107; }
  .text-primary { color: #4169E1; }
  .small { font-size: 0.875rem; }
  .gap-3 { gap: 1rem; }
  .badge { padding: 0.5em 1em; font-weight: 500; }

  .btn {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }
  .btn-sm { padding: 0.4rem 0.8rem; font-size: 0.875rem; }
  .btn-outline-secondary {
    background: transparent;
    border: 2px solid #6c757d;
    color: #6c757d;
  }
  .btn-outline-secondary:hover { background: #6c757d; color: white; }
  .btn-secondary { background: #6c757d; color: white; }
  .btn-secondary:hover { background: #5a6268; }
  .btn-primary { background: #000066; color: white; }
  .btn-primary:hover { background: #000080; }
  .btn-success { background: #28a745; color: white; }
  .btn-success:hover { background: #218838; }
  .bg-primary { background-color: #191970; color: white; border-radius: 20px; }

  /* Floating Modals */
  .floating-modal { display: none; position: fixed; inset: 0; z-index: 100000; }
  .floating-backdrop { position: absolute; inset: 0; background: rgba(0,0,0,0.45); }
  .floating-dialog {
    position: absolute;
    top: 50%; left: 50%; transform: translate(-50%, -50%);
    width: 100%; max-width: 680px; background: #fff; border-radius: 12px; overflow: hidden;
    box-shadow: 0 20px 50px rgba(0,0,0,0.2);
  }
  .floating-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1rem 1.25rem; background: linear-gradient(90deg, #000066, #191970); color: #FFD700;
  }
  .floating-header h3, .floating-header h4 { margin: 0; color: #FFD700; font-weight: 600; }
  .floating-close { background: transparent; border: none; font-size: 1.6rem; cursor: pointer; color: #FFD700; }
  .floating-close:hover { color: #ffffff; }
  .floating-body { padding: 1.25rem; }
  .floating-body .form-group { margin-bottom: 1rem; }
  .floating-body label { display: block; margin-bottom: 0.5rem; color: #2c3e50; font-weight: 500; }
  .floating-body .form-control {
    width: 100%; padding: 0.75rem; border: 1px solid #e6e6e6; border-radius: 8px;
    font-family: 'Poppins', sans-serif;
  }
  .floating-body textarea.form-control { min-height: 140px; resize: vertical; }
  .file-format-hint { margin-top: 0.5rem; color: #666; font-size: 0.9rem; }
  .modal-footer { display: flex; justify-content: flex-end; gap: 0.75rem; padding-top: 0.5rem; }

  /* Confirmation Buttons */
  .btn-confirm {
    background: #191970; color: white; border: none; padding: 0.8rem 2rem;
    border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.3s ease;
  }
  .btn-cancel {
    background: #e9ecef; color: #495057; border: none; padding: 0.8rem 2rem;
    border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.3s ease;
  }
  .btn-confirm:hover { background: #3258c7; transform: translateY(-2px); }
  .btn-cancel:hover { background: #dee2e6; transform: translateY(-2px); }

  /* Toast Messages */
  .success-message {
    position: fixed; top: 20px; right: 20px; background: #fff; border-radius: 12px;
    padding: 1.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.15); display: none; z-index: 1060;
    min-width: 300px; animation: slideInRight 0.5s ease;
  }
  .success-content { display: flex; align-items: center; gap: 1rem; }
  .success-icon {
    background: #4169E1; color: white; width: 40px; height: 40px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
  }
  .success-text .success-title { font-weight: 600; color: #2c3e50; margin-bottom: 0.25rem; }
  .success-text .success-description { color: #6c757d; font-size: 0.9rem; }
  @keyframes slideInRight {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
  }

  /* Image Modal */
  .image-modal {
    display: none; position: fixed; z-index: 100001; padding: 20px; left: 0; top: 0;
    width: 100%; height: 100%; background-color: rgba(0,0,0,0.9); overflow: auto;
  }
  .image-modal-content {
    margin: auto; display: block; max-width: 90%; max-height: 90vh; object-fit: contain;
  }
  .image-modal-close {
    position: absolute; right: 35px; top: 15px; color: #f1f1f1; font-size: 40px;
    font-weight: bold; cursor: pointer; z-index: 3001;
  }
  .image-modal-close:hover { color: #bbb; }
  .image-preview { transition: transform 0.2s ease; cursor: pointer; }
  .image-preview:hover { transform: scale(1.05); }
  .img-thumbnail { border: 1px solid #dee2e6; border-radius: 4px; padding: 0.25rem; }
  .gap-2 { gap: 0.5rem; }
  .flex-wrap { flex-wrap: wrap; }
  .p-0 { padding: 0; }
  .overflow-hidden { overflow: hidden; }

  /* Responsive */
  @media (max-width: 768px) {
    .content-area { padding: 30px 20px; }
    .main-content { flex-direction: column; }
    .sidebar { width: 100%; height: auto; position: static; padding: 15px 0; }
    .content-area { height: auto; min-height: calc(100vh - 160px); }
    .duty-meta { flex-direction: column; gap: 0.5rem; }
    /* Mobile: ensure floating dialogs sit above fixed header and fit screen */
    .floating-modal { z-index: 100000 !important; }
    .floating-dialog {
      position: fixed !important;
      top: 50% !important;
      left: 50% !important;
      transform: translate(-50%, -50%) !important;
      width: calc(100% - 32px) !important;
      max-width: 640px !important;
      max-height: calc(100vh - 100px) !important;
      display: flex !important;
      flex-direction: column !important;
      overflow: hidden !important;
      border-radius: 12px !important;
    }
    .floating-header { position: sticky; top: 0; z-index: 20; }
    .floating-body { overflow-y: auto; -webkit-overflow-scrolling: touch; flex: 1 1 auto; }
    .modal-footer { position: sticky; bottom: 0; z-index: 20; background: #fff; padding: 0.75rem; }
    /* Primary action: full-width, larger touch target on mobile */
    .create-report-btn {
      padding: 0.95rem 1rem;
      font-size: 1rem;
      width: 100%;
      text-align: center;
      border-radius: 10px;
      box-sizing: border-box;
      display: block;
      margin-top: 0.6rem;
    }
    
    /* General buttons: stack and become full-width inside lists and forms */
    .btn {
      padding: 0.85rem 1rem;
      font-size: 0.98rem;
      border-radius: 10px;
      box-sizing: border-box;
    }
    
    /* Small buttons usually used inline; keep them compact but allow full-width when needed */
    .btn-sm {
      padding: 0.55rem 0.9rem;
      font-size: 0.92rem;
    }
    
    /* Modal/footer buttons: stack vertically and fill width for easy tapping */
    .modal-footer {
      flex-direction: column !important;
      gap: 0.5rem;
    }
    .modal-footer .btn {
      width: 100%;
    }
    
    /* Participant action buttons (view report, etc.) should be easy to tap on small screens */
    .view-report-btn {
      width: 100%;
      display: block;
      margin-top: 0.5rem;
      padding: 0.75rem 0.9rem;
    }
    /* Title box and back button placement on mobile */
    .page-title-box { display: inline-block; padding: 12px 18px; background: #fff; border-radius: 10px; box-shadow: 0 6px 18px rgba(20,30,40,0.06); }
    .back-to-duties { white-space: nowrap; }
    .header-row { display:flex; flex-direction: column; align-items: flex-start; gap: 0.6rem; }
    @media (max-width: 768px) {
      .header-row { flex-direction: column; align-items: stretch; gap: 0.5rem; }
      .back-to-duties { order: -1; width: 100%; display: block; }
      .page-title-box { width: 100%; text-align: center; }
      .page-title-box h2 { margin: 0; }
    }
    /* Ensure desktop (wide) also stacks the header elements in case other utilities override */
    @media (min-width: 769px) {
      .header-row { flex-direction: column !important; align-items: flex-start !important; gap: 0.6rem !important; }
      .page-title-box { width: auto !important; text-align: left !important; margin-left: 0 !important; }
    }
  }

  @media (max-width: 600px) {
    .floating-dialog { width: calc(100% - 32px); }
    .create-report-btn, .btn { padding: 0.7rem 1.5rem; font-size: 0.95rem; }
  }
      /* ==================== HAMBURGER MENU (MOBILE) ==================== */
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
      box-shadow: 0 4px 15px rgba(0,0,0,0.3);
      transition: all 0.3s ease;
      align-items: center;
      justify-content: center;
    }
    .hamburger:active { transform: scale(0.95); }

    .mobile-sidebar-overlay {
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.6);
      z-index: 2500;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }
    .mobile-sidebar-overlay.active { opacity: 1; visibility: visible; }

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
      box-shadow: 4px 0 20px rgba(0,0,0,0.3);
      overflow-y: auto;
    }
    .mobile-sidebar.active { left: 0; }

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
      width: 22px; height: 22px; margin-right: 12px; filter: brightness(0) invert(1);
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
        .create-report-btn {
    padding: 0.6rem 1.5rem; /* Reduce padding */
    font-size: 0.9rem; /* Adjust font size */
    width: 100%; /* Make the button take full width */
    text-align: center; /* Center the text */
  }

  .btn {
    padding: 0.6rem 1.5rem; /* Reduce padding for all buttons */
    font-size: 0.9rem; /* Adjust font size */
  }

  .btn-sm {
    padding: 0.5rem 1rem; /* Adjust padding for small buttons */
    font-size: 0.85rem; /* Adjust font size for small buttons */
  }

  .d-flex {
    flex-direction: column; /* Stack buttons vertically */
    gap: 1rem; /* Add spacing between buttons */
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
        .create-report-btn {
    padding: 0.5rem 1rem; /* Further reduce padding */
    font-size: 0.85rem; /* Adjust font size for smaller screens */
  }

  .btn {
    padding: 0.5rem 1rem; /* Further reduce padding for all buttons */
    font-size: 0.85rem; /* Adjust font size */
  }

  .btn-sm {
    padding: 0.4rem 0.8rem; /* Adjust padding for small buttons */
    font-size: 0.8rem; /* Adjust font size for small buttons */
  }

  .d-flex {
    flex-direction: column; /* Stack buttons vertically */
    gap: 0.75rem; /* Add spacing between buttons */
  }
    }
</style>
</head>
<body>
 <!-- HEADER -->
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


    <!-- MAIN CONTENT -->
    <div class="main-content">
      <!-- SIDEBAR -->
      <div class="sidebar">
        <h3 class="sidebar-title">Dashboard</h3>
        <ul class="menu">
          <li>
            <a href="{{ route('member.profile') }}" class="menu-link">
              <img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon">Profile
            </a>
          </li>
          <li>
            <a href="{{ route('member.announcement') }}" class="menu-link">
              <img src="{{ asset('ASSETS/announce-icon.png') }}" class="icon">Announcement
            </a>
          </li>
          <li class="active">
            <a href="{{ route('member.duties') }}" class="menu-link">
              <img src="{{ asset('ASSETS/viewreport-icon.png') }}" class="icon">Duties
            </a>
          </li>
          <li>
            <a href="{{ route('member.duty-history') }}" class="menu-link">
              <img src="{{ asset('ASSETS/history-icon.png') }}" class="icon">Duty History
            </a>
          </li>
        </ul>
        <form method="POST" action="{{ route('student.logout') }}" class="logout-form">
          @csrf
          <button class="logout-btn" type="submit">Logout</button>
        </form>
      </div>

      <!-- CONTENT AREA -->
      <main class="content-area">
          <div class="d-flex header-row align-items-center mb-4">
          <button type="button" class="btn btn-outline-secondary back-to-duties" aria-label="Back to Duties" onclick="window.location='{{ $backRoute ?? route('member.duties') }}'">
            <i class="fas fa-arrow-left"></i> Back to Duties
          </button>
          <div class="page-title-box">
            <h2 style="color: #000066; margin: 0;">{{ $dutyTitle ?? 'Team Leader Dashboard' }}</h2>
          </div>
        </div>
        
        <div class="report-container">
          <!-- Team Leader Info Box -->
          <div class="info-box">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h3>Team Leader</h3>
                <p class="team-leader-name mb-0" style="margin-top: 0.5rem;">
                  @if($teamLeader && ($teamLeader->first_name || $teamLeader->last_name))
                    <i class="fas fa-user-shield me-2"></i>{{ $teamLeader->first_name }} {{ $teamLeader->last_name }}
                    <div class="duty-meta mt-2">
                      <small class="text-white"><i class="fas fa-envelope me-1"></i> {{ $teamLeader->email }}</small>
                      <small class="text-white ms-3"><i class="fas fa-id-card me-1"></i> {{ $teamLeader->plv_student_id }}</small>
                    </div>
                  @elseif($duty->team_leader_name)
                    <i class="fas fa-user-shield me-2"></i>{{ $duty->team_leader_name }}
                  @else
                    <span class="text-warning"><i class="fas fa-exclamation-circle me-2"></i>Team Leader not yet assigned</span>
                  @endif
                </p>
              </div>
              @if(isset($duty) && $duty)
                <div class="duty-meta text-white">
                  <div><i class="far fa-calendar me-2"></i>{{ $duty->duty_date ? $duty->duty_date->format('M d, Y') : 'Date not set' }}</div>
                  <div><i class="far fa-clock me-2"></i>{{ $duty->formatted_start_time }} - {{ $duty->formatted_end_time }}</div>
                </div>
              @endif
            </div>
          </div>

          <!-- Participants List -->
          <div class="participants-section">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h3><i class="fas fa-users me-2"></i>Team Members</h3>
              @if(isset($duty) && isset($duty->participants))
                @php
                  $memberCount = isset($teamLeader) 
                    ? count($duty->participants->where('participant_id', '!=', $teamLeader->participant_id))
                    : count($duty->participants);
                @endphp
                <span class="badge bg-primary">{{ $memberCount }} {{ $memberCount === 1 ? 'Member' : 'Members' }}</span>
              @endif
            </div>
            <div class="participants-list">
              @if(isset($duty) && isset($duty->participants))
                @forelse($duty->participants as $participant)
                  @if(!isset($teamLeader) || $participant->participant_id !== $teamLeader->participant_id)
                    <div class="participant-item">
                      <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                          <i class="fas fa-user me-3 text-primary"></i>
                          <div>
                            <div class="fw-bold">{{ $participant->first_name }} {{ $participant->last_name }}</div>
                            <div class="text-muted small">
                              <i class="fas fa-envelope me-1"></i> {{ $participant->email }}<br>
                              <i class="fas fa-id-card me-1"></i> {{ $participant->plv_student_id }}
                            </div>
                          </div>
                        </div>
                        <div>
                          @php $hasReport = isset($reportedParticipants) && in_array($participant->participant_id, $reportedParticipants); @endphp
                          @if($hasReport)
                            <button type="button" class="btn btn-primary btn-sm view-report-btn" data-participant-id="{{ $participant->participant_id }}">
                              <i class="fas fa-file-alt me-1"></i> View Report
                            </button>
                          @else
                            <button type="button" class="btn btn-secondary btn-sm" disabled title="No report submitted">
                              <i class="fas fa-file-alt me-1"></i> View Report
                            </button>
                          @endif
                        </div>
                      </div>
                    </div>
                  @endif
                @empty
                  <div class="no-participants">
                    <i class="fas fa-user-slash me-2"></i>No team members found
                  </div>
                @endforelse
              @endif
            </div>
          </div>

          <!-- Action Buttons -->
          @if(empty($historyMode))
          <div class="d-flex justify-content-end gap-3 mt-4">
            <button type="button" class="btn btn-success" id="submitDutyBtn" style="font-size: 1.1rem; padding: 0.8rem 2rem;" data-duty-id="{{ $duty->event_id ?? '' }}">
              <i class="fas fa-paper-plane me-2"></i>Submit for Review
            </button>
            <button class="create-report-btn" id="showReportFormBtn" type="button">
              <i class="fas fa-file-alt"></i>
              {{ isset($existingReport) && $existingReport ? 'Edit Report' : 'Create Report' }}
            </button>
          </div>
          @endif
        </div>
      </main>
    </div>
  </div>

  <!-- Submit Confirmation Modal -->
  <div id="submitConfirmModal" class="floating-modal" aria-hidden="true">
    <div class="floating-backdrop"></div>
    <div class="floating-dialog" role="dialog" aria-modal="true">
      <div class="floating-body p-0 overflow-hidden" style="max-width:480px; margin:0 auto;">
        <div style="background: linear-gradient(90deg,#4169E1,#2a64d6); padding:1.25rem; color:#fff; display:flex; gap:1rem; align-items:center;">
          <div style="background:rgba(255,255,255,0.12); width:56px; height:56px; border-radius:12px; display:flex; align-items:center; justify-content:center;">
            <i class="fas fa-paper-plane" style="font-size:1.25rem; color:#fff;"></i>
          </div>
          <div>
            <h4 style="margin:0; font-weight:600;">Submit Report for Review</h4>
            <div style="font-size:0.9rem; opacity:0.95; margin-top:4px">This will send the report to administrators.</div>
          </div>
        </div>

        <div style="padding:1.25rem; background:#fff;">
          <div style="margin-bottom:0.75rem; color:#2c3e50; font-weight:600">Duty Details</div>
          <div style="font-size:0.95rem; color:#6c757d; margin-bottom:1rem">
            <div><strong>Title:</strong> {{ $duty->title ?? ($dutyTitle ?? '—') }}</div>
            <div><strong>Date:</strong> {{ isset($duty) && $duty->duty_date ? $duty->duty_date->format('M d, Y') : 'Not set' }}</div>
            <div><strong>Time:</strong> {{ $duty->formatted_start_time ?? '—' }} - {{ $duty->formatted_end_time ?? '—' }}</div>
          </div>

          <p style="color:#495057; margin-bottom:1rem">Are you sure you want to submit this duty report for review? Once submitted, it cannot be edited.</p>

          <div style="display:flex; justify-content:flex-end; gap:0.75rem;">
            <button class="btn-cancel" onclick="hideSubmitConfirm()">Cancel</button>
            <button class="btn-confirm" onclick="submitDutyForReview()">Yes, Submit</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Success/Error Toast Messages -->
  <div id="successToast" class="success-message">
    <div class="success-content">
      <div class="success-icon">
        <i class="fas fa-check"></i>
      </div>
      <div class="success-text">
        <div class="success-title">Report Submitted</div>
        <div class="success-description">Your report has been successfully submitted for review.</div>
      </div>
    </div>
  </div>

  <div id="errorToast" class="success-message" style="display:none;">
    <div class="success-content">
      <div class="success-icon" style="background:#dc3545">
        <i class="fas fa-exclamation-triangle"></i>
      </div>
      <div class="success-text">
        <div class="success-title">Error</div>
        <div class="success-description" id="errorToastMessage">An error occurred</div>
      </div>
    </div>
  </div>

  <!-- Report Modal -->
  <div id="reportModal" class="floating-modal" aria-hidden="true">
    <div class="floating-backdrop" id="reportModalBackdrop"></div>
    <div class="floating-dialog" role="dialog" aria-modal="true">
      <div class="floating-header">
        <h3>{{ isset($existingReport) && $existingReport ? 'Edit Report Details' : 'Add Report Details' }}</h3>
        <button type="button" class="floating-close" id="closeReportModal">&times;</button>
      </div>
      <div class="floating-body">
        <form action="{{ route('member.report.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @if(isset($duty))
          <input type="hidden" name="event_id" value="{{ $duty->event_id }}">
          @endif
          
          <div class="form-group">
            <label for="summary">Summary:</label>
            <input class="form-control" id="summary" name="summary" type="text" placeholder="Short summary (max 255 chars)" required maxlength="255" value="{{ $existingReport->summary ?? '' }}" />
          </div>

          <div class="form-group">
            <label for="details">Details / Narrative:</label>
            <textarea class="form-control" id="details" name="details" placeholder="Enter full narrative..." required>{{ isset($existingReport) && $existingReport ? $existingReport->details : '' }}</textarea>
          </div>

          <div class="form-group">
            <label>Attach Images (optional):</label>
            @if(isset($existingReport) && $existingReport && isset($existingReport->attachments) && $existingReport->attachments)
              <div class="mb-3">
                <p class="small text-muted">Current attachments:</p>
                <div class="d-flex flex-wrap gap-2 mb-3">
                  @foreach($existingReport->attachments as $attachment)
                    <img src="{{ asset('storage/' . $attachment) }}" alt="Attachment" class="img-thumbnail image-preview" style="height: 60px;" onclick="openImageModal(this.src)">
                  @endforeach
                </div>
                <p class="small text-muted">Upload new images to replace:</p>
              </div>
            @endif
            <input type="file" id="attachments" name="attachments[]" accept="image/*" multiple class="form-control">
            <div class="file-format-hint">Supported: JPG, PNG, GIF. Max ~5MB each.</div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="cancelReport">Cancel</button>
            <button type="submit" class="btn btn-primary">
              {{ isset($existingReport) && $existingReport ? 'Update Report' : 'Submit Report' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- View Participant Report Modal -->
  <div id="viewParticipantReportModal" class="floating-modal" aria-hidden="true">
    <div class="floating-backdrop" id="viewParticipantBackdrop"></div>
    <div class="floating-dialog">
      <div class="floating-header">
        <h3>Participant Report</h3>
        <button type="button" class="floating-close" id="closeViewParticipantModal">&times;</button>
      </div>
      <div class="floating-body">
        <div class="form-group">
          <label>Summary</label>
          <input type="text" id="participantReportSummary" class="form-control" readonly />
        </div>
        <div class="form-group">
          <label>Details</label>
          <textarea id="participantReportDetails" class="form-control" readonly></textarea>
        </div>
        <div class="form-group">
          <label>Attachments</label>
          <div id="participantReportAttachments" class="d-flex flex-wrap gap-2"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="closeViewParticipantBtn">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Image Preview Modal -->
  <div id="imageModal" class="image-modal">
    <span class="image-modal-close" onclick="closeImageModal()">&times;</span>
    <img id="modalImage" class="image-modal-content">
  </div>

  <script>
    // Submit confirmation (bind only if button exists)
    var submitBtn = document.getElementById('submitDutyBtn');
    if (submitBtn) {
      submitBtn.addEventListener('click', function() {
        var modal = document.getElementById('submitConfirmModal');
        if (modal) modal.style.display = 'block';
      });
    }

    function hideSubmitConfirm() {
      document.getElementById('submitConfirmModal').style.display = 'none';
    }

    function showSuccessMessage() {
      const toast = document.getElementById('successToast');
      toast.style.display = 'block';
      setTimeout(() => {
        toast.style.display = 'none';
        window.location.reload();
      }, 5000);
    }

    function showErrorMessage(message) {
      const toast = document.getElementById('errorToast');
      const msgField = document.getElementById('errorToastMessage');
      if (msgField) msgField.textContent = message;
      toast.style.display = 'block';
      setTimeout(() => { toast.style.display = 'none'; }, 6000);
    }

    function submitDutyForReview() {
      const btn = document.getElementById('submitDutyBtn');
      const dutyId = btn.dataset.dutyId;
      if (!dutyId) {
        showErrorMessage('Error: Could not find duty ID');
        return;
      }

      btn.disabled = true;
      
      fetch(`/member/teamleader/${dutyId}/submit`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
      })
      .then(response => response.json())
      .then(data => {
        hideSubmitConfirm();
        if (data.success) {
          showSuccessMessage();
        } else {
          showErrorMessage(data.message || 'Error submitting duty');
        }
      })
      .catch(error => {
        hideSubmitConfirm();
        console.error('Error:', error);
        showErrorMessage('Error submitting duty');
      });
    }

    // Report modal controls
    document.addEventListener('DOMContentLoaded', function(){
      var openBtn = document.getElementById('showReportFormBtn');
      var modal = document.getElementById('reportModal');
      var backdrop = document.getElementById('reportModalBackdrop');
      var closeBtn = document.getElementById('closeReportModal');
      var cancelBtn = document.getElementById('cancelReport');

      function showModal(){
        if(!modal) return;
        modal.style.display = 'block';
        modal.setAttribute('aria-hidden','false');
      }
      function hideModal(){
        if(!modal) return;
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden','true');
      }

      if(openBtn) openBtn.addEventListener('click', showModal);
      if(closeBtn) closeBtn.addEventListener('click', hideModal);
      if(cancelBtn) cancelBtn.addEventListener('click', hideModal);
      if(backdrop) backdrop.addEventListener('click', hideModal);
      document.addEventListener('keydown', function(e){ if(e.key === 'Escape'){ hideModal(); } });
    });

    // Image modal controls
    function openImageModal(imageSrc) {
      const modal = document.getElementById('imageModal');
      const modalImg = document.getElementById('modalImage');
      modal.style.display = 'block';
      modalImg.src = imageSrc;
    }

    function closeImageModal() {
      const modal = document.getElementById('imageModal');
      modal.style.display = 'none';
    }

    document.getElementById('imageModal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeImageModal();
      }
    });

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeImageModal();
      }
    });

    // View participant report
    document.addEventListener('DOMContentLoaded', function(){
      const modal = document.getElementById('viewParticipantReportModal');
      const backdrop = document.getElementById('viewParticipantBackdrop');
      const closeBtn = document.getElementById('closeViewParticipantModal');
      const closeFooterBtn = document.getElementById('closeViewParticipantBtn');

      const summaryField = document.getElementById('participantReportSummary');
      const detailsField = document.getElementById('participantReportDetails');
      const attachmentsContainer = document.getElementById('participantReportAttachments');

      function showViewModal(){ 
        if(!modal) return; 
        modal.style.display = 'block'; 
        modal.setAttribute('aria-hidden','false'); 
      }
      
      function hideViewModal(){ 
        if(!modal) return; 
        modal.style.display = 'none'; 
        modal.setAttribute('aria-hidden','true'); 
      }

      function clearViewModal(){
        if(summaryField) summaryField.value = '';
        if(detailsField) detailsField.value = '';
        if(attachmentsContainer) attachmentsContainer.innerHTML = '';
      }

      async function fetchAndShow(participantId){
        clearViewModal();
        try {
          const res = await fetch('/member/report/participant/' + participantId, { credentials: 'same-origin' });
          if (!res.ok) {
            const err = await res.json().catch(()=>({message: 'Could not load report'}));
            showErrorMessage(err.message || 'Report not found');
            return;
          }
          const data = await res.json();
          if(summaryField) summaryField.value = data.summary || '';
          if(detailsField) detailsField.value = data.details || '';
          if(attachmentsContainer && Array.isArray(data.attachments)){
            data.attachments.forEach(src => {
              const img = document.createElement('img');
              img.src = src;
              img.style.height = '70px';
              img.style.cursor = 'pointer';
              img.className = 'img-thumbnail image-preview';
              img.onclick = function(){ openImageModal(src); };
              attachmentsContainer.appendChild(img);
            });
          }
          showViewModal();
        } catch (e) {
          console.error('Error fetching participant report', e);
          showErrorMessage('Error loading report');
        }
      }

      document.addEventListener('click', function(e){
        const btn = e.target.closest('.view-report-btn');
        if (!btn) return;
        const id = btn.getAttribute('data-participant-id');
        if (id) fetchAndShow(id);
      });

      if(closeBtn) closeBtn.addEventListener('click', hideViewModal);
      if(closeFooterBtn) closeFooterBtn.addEventListener('click', hideViewModal);
      if(backdrop) backdrop.addEventListener('click', hideViewModal);
      document.addEventListener('keydown', function(e){ if(e.key === 'Escape'){ hideViewModal(); } });
    });
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