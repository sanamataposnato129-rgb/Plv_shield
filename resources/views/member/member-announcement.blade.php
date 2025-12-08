<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PLV - SHIELD Announcements</title>
  <link rel="stylesheet" href="{{ asset('css/member/member-announcement.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/member/member-profile.css') }}" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
  /* Clean, professional card UI (responsive, centered width) */
  .duty-box {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(20,30,40,0.08);
    margin: 0 auto;
    width: 100%;
    max-width: 100%;
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
    padding: 0;
    cursor: pointer;
    transition: transform 0.18s ease, box-shadow 0.18s ease;
  }
  .duty-box:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(16,24,40,0.12);
  }
  @keyframes cardIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .duty-box { opacity: 0; animation: cardIn 420ms cubic-bezier(.2,.9,.3,1) forwards; }

  .duty-box-header {
    height: 70px;
    background: linear-gradient(90deg, #000066, #191970);
    display: flex;
    align-items: flex-end;
    padding: 0.7rem 1.2rem 0.5rem 1.2rem;
    color: #fff;
    position: relative;
  }
  .duty-box-header.color-1 { background: linear-gradient(90deg, #000066, #191970); }
  .duty-box-header.color-2 { background: linear-gradient(90deg, #388e3c, #8bc34a); }
  .duty-box-header.color-3 { background: linear-gradient(90deg, #7b1fa2, #e040fb); }
  .duty-box-header.color-4 { background: linear-gradient(90deg, #ff6f00, #ffd600); color: #222; }
  .duty-box-header.color-5 { background: linear-gradient(90deg, #0097a7, #00e5ff); }

  .duty-title {
    font-size: 1.18rem;
    font-weight: 600;
    margin: 0;
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .duty-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #fff;
    border: 2px solid #fff;
    margin-left: 0.7rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    color: #3f51b5;
    font-weight: 700;
    box-shadow: 0 1px 4px rgba(60,72,88,0.10);
  }
  .duty-box-content {
    padding: 1rem 1.25rem 1.1rem 1.25rem;
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
  }
  .duty-meta {
    font-size: 0.97rem;
    color: #5f6368;
    margin-bottom: 0.2rem;
    display: flex;
    gap: 1.5rem;
  }
  .duty-desc {
    color: #444;
    font-size: 1rem;
    margin-bottom: 0.5rem;
    min-height: 2.2em;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-word;
  }
  .duty-participants {
    font-size: 0.95rem;
    color: #757575;
    margin-bottom: 0.7rem;
  }

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

  /* ==================== MODAL STYLES (unchanged) ==================== */
  .modal {
    display: none;
    position: fixed;
    inset: 0;
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
    z-index: 2050;
    overflow-x: hidden;
    overflow-y: auto;
  }
  .modal.show { display: flex !important; align-items: center !important; justify-content: center !important; }
  .modal-dialog { position: relative; width: auto; max-width: 600px; margin: 3rem auto; pointer-events: none; }
  .modal.fade .modal-dialog { transition: transform 0.3s ease-out; transform: translate(0, -50px); }
  .modal.show .modal-dialog { transform: none; }
  .modal-dialog-centered { display: flex; align-items: center; min-height: calc(100% - 6rem); margin: 3rem auto; }
  .modal-backdrop.show { background-color: rgba(0,0,0,0.42) !important; backdrop-filter: blur(2px); z-index: 2040 !important; }
  .modal-content {
    background-color: #ffffff;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    overflow: hidden;
    color: #0f172a;
    position: relative;
    display: flex;
    flex-direction: column;
    width: 100%;
    pointer-events: auto;
    background-clip: padding-box;
    outline: 0;
    border: none;
  }
  .modal-duty-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 2rem 2rem 1.5rem 2rem;
    background: #f8f9fa;
    border-bottom: none;
    position: relative;
  }
  .modal-duty-avatar {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
    color: #1f2937;
    font-weight: 700;
    font-size: 1.75rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border: 3px solid #e5e7eb;
  }
  .modal-duty-titlewrap { flex: 1; min-width: 0; }
  .modal-duty-title { margin: 0; font-size: 1.75rem; font-weight: 700; color: #111827; line-height: 1.2; }
  .modal-duty-subtitle { font-size: 1rem; color: #6b7280; margin-top: 0.5rem; font-weight: 400; }
  .btn-close {
    position: absolute;
    top: 1.25rem;
    right: 1.25rem;
    background: transparent;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    opacity: 0.5;
    transition: opacity 0.2s;
    padding: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .btn-close:hover { opacity: 1; }
  .btn-close::before { content: "×"; font-size: 2rem; }
  .modal-duty-body { padding: 2rem; background: #ffffff; }
  .meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem; }
  .meta-item { display: flex; flex-direction: column; gap: 0.5rem; }
  .meta-item strong { display: block; color: #6b7280; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.25rem; }
  .meta-item div:last-child { color: #111827; font-size: 1rem; font-weight: 500; }
  .modal-duty-body hr { border: none; border-top: 1px solid #e5e7eb; margin: 1.5rem 0; }
  .modal-duty-description { color: #374151; line-height: 1.6; font-size: 1rem; }
  .modal-footer {
    background: #f8f9fa;
    border-top: 1px solid #e5e7eb;
    padding: 1.5rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
  }
  .modal-footer .left-actions, .modal-footer .right-actions { display: flex; gap: 0.75rem; }
  .modal-footer .btn {
    min-width: 140px;
    padding: 0.75rem 1.75rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
  }
  .modal-footer .btn-secondary { background: #ffffff; color: #374151; border: 1px solid #d1d5db; }
  .modal-footer .btn-secondary:hover { background: #f3f4f6; border-color: #9ca3af; }
  .modal-footer .btn-primary { background: #111827; color: #ffffff; }
  .modal-footer .btn-primary:hover { background: #1f2937; transform: translateY(-1px); }
  .modal-footer .btn-outline-danger { background: transparent; color: #dc2626; border: 2px solid #dc2626; min-width: 180px; }
  .modal-footer .btn-outline-danger:hover { background: #dc2626; color: white; }

  @keyframes modalIn {
    from { opacity: 0; transform: translateY(12px) scale(0.985); }
    to { opacity: 1; transform: translateY(0) scale(1); }
  }
  .modal.show .modal-content { animation: modalIn 260ms cubic-bezier(.2,.9,.3,1) both; }
  .modal-backdrop { opacity: 0; transition: opacity 220ms ease; }
  .modal-backdrop.show { opacity: 1; }

  /* ==================== RESPONSIVE ==================== */
  @media (max-width: 768px) {
    .main-content { flex-direction: column; }
    .sidebar {
      width: 100%;
      height: auto;
      position: static;
      padding: 15px 0;
    }
    .content-area { height: auto; min-height: calc(100vh - 160px); }
    .announcement-list { padding: 0 15px; }
    /* Make modal fit mobile viewport better: tighter margins, allow internal scrolling */
    .modal-dialog {
      max-width: calc(100% - 2rem);
      margin: 0.5rem auto;
      width: 100%;
    }
    .modal-dialog-centered { min-height: calc(100% - 2rem); }
    .modal.show .modal-content {
      max-height: calc(100vh - 3rem);
      overflow-y: auto;
      -webkit-overflow-scrolling: touch;
    }
    .modal-footer { flex-direction: column; gap: 0.75rem; }
    .modal-footer .left-actions, .modal-footer .right-actions { width: 100%; }
    .modal-footer .btn { width: 100%; }
    .meta-grid { grid-template-columns: 1fr; }
    .modal-duty-title { font-size: 1.25rem; }
    .announcement-header { font-size: 20px; }
    /* Slightly reduce header paddings/avatar for mobile space */
    .modal-duty-header { padding: 1.2rem 1rem 0.9rem 1rem; }
    .modal-duty-avatar { width: 48px; height: 48px; font-size: 1.2rem; border-width: 2px; }
    .modal-duty-title { font-size: 1.2rem; }
  }

  /* More aggressive mobile adjustments for very small screens (phones) */
  @media (max-width: 480px) {
    /* Make the dialog act like a bottom sheet / full-screen panel */
    .modal-dialog {
      position: fixed;
      inset: 0; /* top:0; right:0; bottom:0; left:0 */
      height: 100%;
      margin: 0;
      max-width: 100%;
      width: 100%;
      display: flex;
      align-items: flex-end;
      pointer-events: none;
    }
    .modal-dialog-centered { align-items: flex-end; }
    .modal.show .modal-dialog { pointer-events: auto; }

    .modal-content {
      height: 100%;
      border-radius: 0;
      display: flex;
      flex-direction: column;
      overflow: hidden;
      box-shadow: none;
    }

    /* Header stays visible when scrolling content */
    .modal-duty-header {
      position: sticky;
      top: 0;
      z-index: 12;
      background: #ffffff;
      padding: 1rem 0.9rem;
      border-bottom: 1px solid #eee;
    }

    /* Make body scroll internally */
    .modal-duty-body {
      overflow-y: auto;
      -webkit-overflow-scrolling: touch;
      padding: 1rem;
      flex: 1 1 auto;
    }

    /* Footer sticks to bottom so actions are always reachable */
    .modal-footer {
      position: sticky;
      bottom: 0;
      z-index: 12;
      background: #ffffff;
      padding: 0.75rem 0.9rem;
      box-shadow: 0 -8px 22px rgba(16,24,40,0.06);
      gap: 0.5rem;
      display: flex;
      flex-direction: column;
    }

    .modal-footer .left-actions, .modal-footer .right-actions { width: 100%; display:flex; gap:0.5rem; }

    .modal-footer .btn { width: 100%; min-width: 0; }

    /* Slightly smaller typography for phones */
    .modal-duty-title { font-size: 1.05rem; }
    .modal-duty-subtitle { font-size: 0.92rem; }

    /* Make close control easier to tap */
    .btn-close { width: 40px; height: 40px; top: 0.85rem; right: 0.85rem; }

    /* Avoid very tall avatar on small screens */
    .modal-duty-avatar { width: 44px; height: 44px; font-size: 1.05rem; }
    /* Improve close (X) button touch target and visibility on phones */
    .btn-close {
      position: absolute;
      top: 0.9rem;
      right: 0.9rem;
      width: 44px;
      height: 44px;
      border-radius: 10px;
      background: rgba(0,0,0,0.06);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0;
      z-index: 30;
      opacity: 1;
    }
    .btn-close::before { content: "\00d7"; font-size: 1.35rem; color: #111827; }

    /* Place buttons side-by-side and size them for easy tap targets */
    .modal-footer {
      display: flex;
      flex-direction: row;
      gap: 0.5rem;
      padding: 0.75rem 0.9rem;
      align-items: center;
      justify-content: space-between;
    }
    .modal-footer .left-actions, .modal-footer .right-actions { width: auto; display:flex; gap:0.5rem; }
    .modal-footer .btn { flex: 1 1 0; padding: 0.9rem 0.9rem; font-size: 1rem; border-radius: 10px; }
    .modal-footer .btn-primary { min-width: 48%; }
    .modal-footer .btn-outline-danger { min-width: 48%; }
  }

  @media (max-width: 600px) {
    .duty-box-content { padding-left: 0.7rem; padding-right: 0.7rem; }
    .duty-box-header { padding-left: 0.7rem; padding-right: 0.7rem; }
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
      padding: 80px 20px 20px;
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
      .hamburger { display: flex !important; }
      .sidebar { display: none !important; }
      header { padding-left: 80px !important; }
      .content-area { padding: 100px 20px 40px !important; }
    }
    @media (max-width: 480px) {
      .content-area { padding: 90px 15px 30px !important; }
    }
</style>
</head>
<body>
 <!-- Hamburger Button (Mobile Only) -->
  <button class="hamburger" id="hamburgerBtn" aria-label="Open Menu">
    <i class="fas fa-bars"></i>
  </button>

  <!-- Mobile Overlay -->
  <div class="mobile-sidebar-overlay" id="mobileOverlay"></div>

  <!-- Mobile Sidebar -->
  <div class="mobile-sidebar" id="mobileSidebar">
    <h3 class="sidebar-title">Dashboard</h3>
    <ul class="menu">
      <li><a href="{{ route('member.profile') }}" class="menu-link"><img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon"> Profile</a></li>
      <li class="active"><a href="{{ route('member.announcement') }}" class="menu-link"><img src="{{ asset('ASSETS/announce-icon.png') }}" class="icon"> Announcement</a></li>
      <li><a href="{{ route('member.duties') }}" class="menu-link"><img src="{{ asset('ASSETS/viewreport-icon.png') }}" class="icon"> Duties</a></li>
      <li><a href="{{ route('member.duty-history') }}" class="menu-link"><img src="{{ asset('ASSETS/history-icon.png') }}" class="icon"> Duty History</a></li>
    </ul>
    <form method="POST" action="{{ route('student.logout') }}" class="logout-form">
      @csrf
      <button class="logout-btn" type="submit">Logout</button>
    </form>
  </div>

  <div class="container">
    <header>
      <div class="header-left">
        <img src="{{ asset('ASSETS/shield-logo.png') }}" alt="PLV SHIELD Logo" class="logo" />
        <h1>PLV - SHIELD</h1>
      </div>
    </header>

    <div class="main-content">
      <div class="sidebar">
        <h3 class="sidebar-title">Dashboard</h3>
        <ul class="menu">
          <li><a href="{{ route('member.profile') }}" class="menu-link"><img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon">Profile</a></li>
          <li class="active"><a href="{{ route('member.announcement') }}" class="menu-link"><img src="{{ asset('ASSETS/announce-icon.png') }}" class="icon">Announcement</a></li>
          <li><a href="{{ route('member.duties') }}" class="menu-link"><img src="{{ asset('ASSETS/viewreport-icon.png') }}" class="icon">Duties</a></li>
          <li><a href="{{ route('member.duty-history') }}" class="menu-link"><img src="{{ asset('ASSETS/history-icon.png') }}" class="icon">Duty History</a></li>
        </ul>
        <form method="POST" action="{{ route('student.logout') }}" class="logout-form">
          @csrf
          <button class="logout-btn" type="submit">Logout</button>
        </form>
      </div>

      <main class="content-area">
        <div class="announcement-header">Announcements</div>
        @php use Illuminate\Support\Str; @endphp
        <div class="announcement-list">
          @if(isset($duties) && count($duties))
            @php $colorIdx = 1; @endphp
            @foreach($duties as $duty)
              <div class="duty-box" role="button" tabindex="0"
                   style="animation-delay: {{ $loop->index * 80 }}ms;"
                   data-event-id="{{ $duty->event_id }}"
                   data-title="{{ e($duty->title) }}"
                   data-date="{{ optional($duty->duty_date)->format('M d, Y') }}"
                   data-time="{{ $duty->formatted_start_time }} - {{ $duty->formatted_end_time }}"
                   data-capacity="{{ $duty->number_of_participants }}"
                   data-registered-count="{{ $duty->registered_count ?? 0 }}"
                   data-registered="{{ isset($duty->is_registered) && $duty->is_registered ? '1' : '0' }}"
                   data-participants="{{ $duty->number_of_participants }}"
                   data-description="{{ e($duty->description) }}">
                <div class="duty-box-header color-{{ $colorIdx }}">
                  <span class="duty-title">{{ $duty->title }}</span>
                  <span class="duty-avatar">{{ strtoupper(substr($duty->title,0,1)) }}</span>
                </div>
                <div class="duty-box-content">
                  <div class="duty-meta">
                    <span class="duty-date">{{ optional($duty->duty_date)->format('M d, Y') }}</span>
                    <span class="duty-time">{{ $duty->formatted_start_time }} - {{ $duty->formatted_end_time }}</span>
                  </div>
                  <div class="duty-desc">{{ Str::limit($duty->description, 100) }}</div>
                  <div class="duty-participants">Participants: {{ $duty->registered_count ?? 0 }}/{{ $duty->number_of_participants }}</div>
                </div>
              </div>
              @php $colorIdx = $colorIdx >= 5 ? 1 : $colorIdx + 1; @endphp
            @endforeach
          @else
            <div class="announce-item">
              <h3>No Open Duties</h3>
              <p>There are currently no open duties for registration.</p>
            </div>
          @endif
        </div>

        <!-- Duty Details Modal -->
        <div class="modal fade" id="dutyDetailsModal" tabindex="-1" aria-labelledby="dutyDetailsModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-duty-header">
                <div class="modal-duty-avatar" id="modalDutyAvatar">S</div>
                <div class="modal-duty-titlewrap">
                  <h5 class="modal-duty-title" id="modalDutyTitle">Duty Title</h5>
                  <div class="modal-duty-subtitle" id="modalDutyDateSubtitle">Date • Time</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body modal-duty-body">
                <div class="meta-grid">
                  <div class="meta-item">
                    <div><strong>Date</strong></div>
                    <div id="modalDutyDate"></div>
                  </div>
                  <div class="meta-item">
                    <div><strong>Time</strong></div>
                    <div id="modalDutyTime"></div>
                  </div>
                  <div class="meta-item">
                    <div><strong>Participants</strong></div>
                    <div id="modalDutyParticipants"></div>
                  </div>
                </div>
                <hr />
                <div class="modal-duty-description" id="modalDutyDescription"></div>
              </div>
              <div class="modal-footer">
                <div class="left-actions">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                <div class="right-actions">
                  <form id="registerForm" method="POST" style="display:inline-block;margin:0;">
                    @csrf
                    <button type="submit" class="btn btn-primary" id="registerBtn">Register</button>
                  </form>
                  <form id="cancelForm" method="POST" style="display:none;margin:0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger" id="cancelBtn">Cancel Registration</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      console.log('Page loaded, initializing modal functionality...');
      
      function openDutyModal(el) {
        var eventId = el.dataset.eventId || '';
        var title = el.dataset.title || '';
        var date = el.dataset.date || '';
        var time = el.dataset.time || '';
        var description = el.dataset.description || '';
        var regCount = el.dataset.registeredCount || '0';
        var capacity = el.dataset.capacity || '0';
        var isRegistered = el.dataset.registered === '1' || el.dataset.registered === 'true';
        
        console.log('Opening modal for duty:', title);
        console.log('Event ID:', eventId);
        console.log('Is registered:', isRegistered);

        // Set modal content
        document.getElementById('modalDutyTitle').innerText = title;
        document.getElementById('modalDutyDate').innerText = date;
        document.getElementById('modalDutyTime').innerText = time;
        document.getElementById('modalDutyParticipants').innerText = regCount + '/' + capacity;
        document.getElementById('modalDutyDescription').innerText = description;

        // Set avatar and subtitle
        var avatar = title ? title.trim().charAt(0).toUpperCase() : 'S';
        document.getElementById('modalDutyAvatar').innerText = avatar;
        var subtitleEl = document.getElementById('modalDutyDateSubtitle');
        if (subtitleEl) subtitleEl.innerText = date && time ? (date + ' • ' + time) : (date || time);

        // Set form actions
        var registerForm = document.getElementById('registerForm');
        var cancelForm = document.getElementById('cancelForm');
        
        if (registerForm) {
          registerForm.action = '/member/duties/' + eventId + '/register';
          console.log('Register form action set to:', registerForm.action);
        }
        
        if (cancelForm) {
          cancelForm.action = '/member/duties/' + eventId + '/cancel';
          console.log('Cancel form action set to:', cancelForm.action);
        }

        // Toggle Register/Cancel buttons
        if (isRegistered) {
          console.log('User is registered - showing cancel button');
          if (registerForm) registerForm.style.display = 'none';
          if (cancelForm) cancelForm.style.display = 'inline-block';
        } else {
          console.log('User is not registered - showing register button');
          if (registerForm) registerForm.style.display = 'inline-block';
          if (cancelForm) cancelForm.style.display = 'none';
        }

        // Show modal
        var modal = new bootstrap.Modal(document.getElementById('dutyDetailsModal'));
        modal.show();
      }

      // Attach event listeners to duty cards
      document.querySelectorAll('.duty-box').forEach(function(box) {
        box.addEventListener('click', function(e) {
          openDutyModal(this);
        });
        box.addEventListener('keydown', function(e) {
          if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            openDutyModal(this);
          }
        });
      });

      // Close button handler
      var dutyModalEl = document.getElementById('dutyDetailsModal');
      if (dutyModalEl) {
        var closeBtn = dutyModalEl.querySelector('.btn-secondary[data-bs-dismiss]');
        if (closeBtn) {
          closeBtn.addEventListener('click', function (e) {
            var m = bootstrap.Modal.getInstance(dutyModalEl) || new bootstrap.Modal(dutyModalEl);
            m.hide();
          });
        }
      }

      // Log form submissions
      var registerForm = document.getElementById('registerForm');
      if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
          console.log('Submitting registration to:', this.action);
        });
      }

      var cancelForm = document.getElementById('cancelForm');
      if (cancelForm) {
        cancelForm.addEventListener('submit', function(e) {
          console.log('Submitting cancellation to:', this.action);
        });
      }
    });
  </script>
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