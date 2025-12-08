<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PLV - SHIELD Member Duties</title>
  <link rel="stylesheet" href="{{ asset('css/member/member-announcement.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/member/member-profile.css') }}" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>

   .duty-box {
      background: #ffffff;
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(20,30,40,0.08);
      width: 100% !important;
      max-width: 100% !important;
      margin: 0 !important;       
      display: flex;
      flex-direction: column;
      position: relative;
      overflow: hidden;
      padding: 0;
      transition: transform 0.18s ease, box-shadow 0.18s ease;
      text-decoration: none !important;
    }
    .duty-clickable {
      cursor: pointer;
    }
    .duty-box:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 40px rgba(16,24,40,0.10);
    }
    .duty-box-header {
      height: 80px;
      background: linear-gradient(90deg, #000066, #191970);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1rem 1.5rem;
      color: #fff;
    }
    .duty-title-container {
      flex: 1;
    }
    .duty-title {
      font-size: 1.4rem;
      font-weight: 600;
      margin: 0 0 0.2rem 0;
    }
    .team-leader {
      font-size: 0.9rem;
      color: #FF8C00;  /* Orange color */
      font-weight: 500;
    }
    .duty-avatar {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      background: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-left: 1rem;
      font-size: 1.5rem;
      font-weight: 600;
      color: #4169E1;
    }
    .duty-box-content {
      padding: 1.5rem;
    }
    .duty-meta {
      display: flex;
      gap: 2rem;
      color: #666;
      font-size: 0.95rem;
      margin-bottom: 1rem;
    }
    .duty-meta i {
      color: #4169E1;
      margin-right: 0.5rem;
    }
    .duty-desc {
      color: #333;
      font-size: 1rem;
      margin-bottom: 1rem;
      line-height: 1.5;
    }
    .duty-participants {
      color: #666;
      font-size: 0.95rem;
    }
    .duty-participants i {
      color: #4169E1;
      margin-right: 0.5rem;
    }
    @keyframes cardIn {
      from { opacity: 0; transform: translateY(12px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .duty-box { opacity: 0; animation: cardIn 420ms cubic-bezier(.2,.9,.3,1) forwards; 
    }
    .duty-box-header,
    .duty-box-content {
      width: 100%;
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

    .duties-header {
   background: linear-gradient(to right, #000066, #191970);
    color: #FFD700;
    display: flex;
    justify-content: center;   /* Centers horizontally /
    align-items: center;        / Centers vertically */
    font-size: 24px;
    font-weight: bold;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
    text-align: center;
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

    .duty-box {
      width: 100%;
      max-width: 100%;
      align-items: stretch;
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
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
      transition: all 0.3s ease;
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

      /* Make duty cards taller and more spacious on tablets/phones */
      .announcement-list {
        gap: 1.75rem;
        padding: 0 12px;
      }
      .duty-box {
        min-height: 220px;
        border-radius: 14px;
      }
      .duty-box-header {
        height: 96px;
        padding: 0.9rem 1rem;
      }
      .duty-box-content {
        padding: 1.25rem;
      }
      .duty-title { font-size: 1.25rem; }
      .duty-desc { font-size: 0.98rem; line-height: 1.6; }
      .duty-meta { gap: 1rem; flex-wrap: wrap; }
      .duty-avatar { width: 52px; height: 52px; font-size: 1.6rem; }
    }

    @media (max-width: 480px) {
      .content-area {
        padding: 90px 15px 30px !important;
      }

      /* Slightly taller on small phones for readability */
      .duty-box { min-height: 260px; }
      .duty-box-header { height: 104px; padding: 0.8rem 0.9rem; }
      .duty-title { font-size: 1.2rem; }
      .duty-box-content { padding: 1rem; }
    }
</style>
</head>
<body>
  <!-- Hamburger Button (Mobile Only) -->
  <button class="hamburger" id="hamburgerBtn" aria-label="Open Menu">
    <i class="fas fa-bars"></i>
  </button>

  <!-- Mobile Sidebar Overlay -->
  <div class="mobile-sidebar-overlay" id="mobileOverlay"></div>

  <!-- Mobile Sidebar -->
  <div class="mobile-sidebar" id="mobileSidebar">
    <h3 class="sidebar-title">Dashboard</h3>
    <ul class="menu">
      <li><a href="{{ route('member.profile') }}" class="menu-link"><img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon"> Profile</a></li>
      <li><a href="{{ route('member.announcement') }}" class="menu-link"><img src="{{ asset('ASSETS/announce-icon.png') }}" class="icon"> Announcement</a></li>
      <li class="active"><a href="{{ route('member.duties') }}" class="menu-link"><img src="{{ asset('ASSETS/viewreport-icon.png') }}" class="icon"> Duties</a></li>
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
          <li><a href="{{ route('member.profile') }}" class="menu-link"><img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon"> Profile</a></li>
          <li><a href="{{ route('member.announcement') }}" class="menu-link"><img src="{{ asset('ASSETS/announce-icon.png') }}" class="icon"> Announcement</a></li>
          <li class="active"><a href="{{ route('member.duties') }}" class="menu-link"><img src="{{ asset('ASSETS/viewreport-icon.png') }}" class="icon"> Duties</a></li>
          <li><a href="{{ route('member.duty-history') }}" class="menu-link"><img src="{{ asset('ASSETS/history-icon.png') }}" class="icon"> Duty History</a></li>
        </ul>
        <form method="POST" action="{{ route('student.logout') }}" class="logout-form">
          @csrf
          <button class="logout-btn" type="submit">Logout</button>
        </form>
      </div>

    <!-- CONTENT AREA -->
    <main class="content-area">
      <div class="duties-header">Duties</div>
      @php use Illuminate\Support\Str; @endphp
      <div class="announcement-list">
        @if(isset($duties) && count($duties))
          @foreach($duties as $duty)
            <a href="{{ $duty->is_team_leader ? route('member.teamleader', ['duty_id' => $duty->event_id]) : route('member.report', ['duty_id' => $duty->event_id]) }}" 
                 class="duty-box duty-clickable" 
                 style="text-decoration: none; display: block; animation-delay: {{ $loop->index * 80 }}ms;">
              <div class="duty-box-header">
                <div class="duty-title-container">
                  <h3 class="duty-title">{{ $duty->title }}</h3>
                  @if($duty->team_leader_name)
                    <div class="team-leader">Team Leader: {{ $duty->team_leader_name }}</div>
                  @endif
                </div>
                <div class="duty-avatar">{{ Str::upper(substr($duty->title, 0, 1)) }}</div>
              </div>
              <div class="duty-box-content">
                <div class="duty-meta">
                  <span><i class="far fa-calendar"></i> {{ optional($duty->duty_date)->format('M d, Y') }}</span>
                  <span><i class="far fa-clock"></i> {{ $duty->formatted_start_time }} - {{ $duty->formatted_end_time }}</span>
                </div>
                <div class="duty-desc">{{ Str::limit($duty->description, 100) }}</div>
                <div class="duty-participants">
                  <i class="fas fa-users"></i> Participants: {{ $duty->registered_count }}/{{ $duty->number_of_participants }}
                </div>
              </div>
            </a>
          @endforeach
        @else
          <div class="duty-box">
            <h3>No Duties Found</h3>
            <p>You don't have any duties currently in progress.</p>
          </div>
        @endif
      </div>
    </main>
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
