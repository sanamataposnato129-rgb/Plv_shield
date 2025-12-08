<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PLV - SHIELD Report</title>
  <link rel="stylesheet" href="{{ asset('css/member/member-announcement.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/member/member-profile.css') }}" />
<style>
    /* ==================== UNIFIED LAYOUT (SAME AS EVERY PAGE) ==================== */
    header {
      background: linear-gradient(to right, #000066, #191970);
      color: #FFD700;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 15px 40px;
      border-bottom: 3px solid #8000FF;
      flex-shrink: 0;
      position: relative;
      z-index: 1000;
    }
    .logo { height: 60px; margin-right: 15px; }
    .header-left { display: flex; align-items: center; }
    header h1 { font-size: 28px; font-weight: 800; }

    .main-content {
      display: flex;
      min-height: calc(100vh - 90px);
      overflow: hidden;
    }

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
      top: 0;
      overflow-y: auto;
    }

    .content-area {
      flex: 1;
      background: #FFF8DC;
      padding: 50px 80px;
      overflow-y: auto;
      height: calc(100vh - 90px);
    }

    /* ==================== SIDEBAR MENU ==================== */
    .sidebar-title { color: #FFD700; font-weight: bold; margin-bottom: 20px; font-size: 18px; text-align: center; }
    .menu { list-style: none; width: 100%; padding: 0; margin: 0; }
    .menu li { padding: 12px 25px; transition: 0.3s; cursor: pointer; }
    .menu li a.menu-link {
      text-decoration: none; color: white; display: flex; align-items: center; width: 100%;
    }
    .menu li a.menu-link img.icon {
      width: 22px; height: 22px; margin-right: 12px; filter: brightness(0) invert(1);
    }
    .menu li:hover, .menu li.active {
      background-color: #FFD700; color: black; font-weight: bold;
    }
    .menu li.active img.icon, .menu li:hover img.icon { filter: brightness(0); }

    .logout-form { margin-top: auto; margin-bottom: 20px; width: 100%; display: flex; justify-content: center; }
    .logout-btn {
      background-color: #FFD700; color: black; font-weight: bold; border: none;
      padding: 10px 30px; border-radius: 30px; cursor: pointer; transition: all 0.3s ease; font-size: 14px;
    }
    .logout-btn:hover { background-color: #ffea00; transform: scale(1.05); box-shadow: 0 0 15px rgba(255, 215, 0, 0.8); }

    /* ==================== PAGE-SPECIFIC STYLES ==================== */
    .report-container {
      background: #ffffff; border-radius: 12px; box-shadow: 0 6px 18px rgba(20,30,40,0.08);
      padding: 2rem; width: 100%; max-width: 100%;
    }

    .info-box {
      background: linear-gradient(90deg, #000066, #191970); border-radius: 10px; padding: 1.5rem; color: #fff; margin-bottom: 2rem;
    }
    .info-box h3 { margin: 0; font-size: 1.2rem; font-weight: 600; }
    .duty-meta { display: flex; gap: 1.5rem; font-size: 0.95rem; opacity: 0.9; }

    .participants-section {
      background: #f8f9fa; border-radius: 10px; padding: 1.5rem; margin-bottom: 2rem;
    }
    .participants-section h3 { margin: 0; font-size: 1.2rem; color: #2c3e50; font-weight: 600; }
    .participants-list { display: flex; flex-direction: column; gap: 0.75rem; margin-top: 1rem; }
    .participant-item {
      background: #fff; padding: 1rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      transition: transform 0.2s ease;
    }
    .participant-item:hover { transform: translateX(5px); }

    .create-report-btn {
      background: #191970; color: white; border: none; padding: 0.9rem 2rem; border-radius: 8px;
      font-size: 1rem; font-weight: 500; cursor: pointer; transition: all 0.3s ease;
      display: inline-flex; align-items: center; gap: 0.5rem; float: right;
    }
    .create-report-btn:hover {
      background: #000066; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(25, 25, 150, 0.3);
    }

    /* Utility */
    .d-flex { display: flex; }
    .justify-content-between { justify-content: space-between; }
    .align-items-center { align-items: center; }
    .mb-4 { margin-bottom: 1.5rem; }
    .text-warning { color: #ffc107; }
    .text-primary { color: #4169E1; }
    .fw-bold { font-weight: 600; }
    .text-muted { color: #6c757d; }
    .small { font-size: 0.875rem; }
    .badge { padding: 0.5em 1em; font-weight: 500; background-color: #191970; color: white; border-radius: 20px; }

    /* Title box and back button placement (desktop left, mobile centered) */
    .page-title-box { display: inline-block; padding: 12px 18px; background: #fff; border-radius: 10px; box-shadow: 0 6px 18px rgba(20,30,40,0.06); }
    .back-to-duties { white-space: nowrap; }
    .header-row { align-items: center; justify-content: flex-start; gap: 1rem; }
    @media (max-width: 768px) {
      .header-row { flex-direction: column; align-items: stretch; gap: 0.5rem; }
      .back-to-duties { order: -1; width: 100%; display: block; }
      .page-title-box { width: 100%; text-align: center; }
      .page-title-box h2 { margin: 0; }
    }
    /* Force desktop stacking if earlier rules were reverted */
    @media (min-width: 769px) {
      .header-row { flex-direction: column !important; align-items: flex-start !important; gap: 0.6rem !important; }
      .page-title-box { width: auto !important; text-align: left !important; margin-left: 0 !important; }
    }
    /* ==================== HAMBURGER MENU (MOBILE) ==================== */
    .hamburger {
      display: none; position: fixed; top: 20px; left: 20px; z-index: 3000;
      background: #191970; color: #FFD700; border: none; width: 50px; height: 50px;
      border-radius: 50%; font-size: 24px; cursor: pointer; box-shadow: 0 4px 15px rgba(0,0,0,0.3);
      align-items: center; justify-content: center;
    }
    .hamburger:active { transform: scale(0.95); }

    .mobile-sidebar-overlay {
      position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 2500;
      opacity: 0; visibility: hidden; transition: all 0.3s ease;
    }
    .mobile-sidebar-overlay.active { opacity: 1; visibility: visible; }

    .mobile-sidebar {
      position: fixed; top: 0; left: -280px; width: 280px; height: 100vh;
      background: linear-gradient(to bottom, #000066, #0A0A40); z-index: 2600;
      padding: 80px 20px 20px; transition: left 0.35s cubic-bezier(0.25, 0.8, 0.25, 1);
      box-shadow: 4px 0 20px rgba(0,0,0,0.3); overflow-y: auto;
    }
    .mobile-sidebar.active { left: 0; }

    .mobile-sidebar .sidebar-title { color: #FFD700; font-size: 20px; font-weight: bold; margin-bottom: 30px; text-align: center; }
    .mobile-sidebar .menu li a.menu-link {
      padding: 14px 20px; border-radius: 12px; margin-bottom: 8px; color: white;
      display: flex; align-items: center;
    }
    .mobile-sidebar .menu li a.menu-link img.icon {
      width: 22px; height: 22px; margin-right: 12px; filter: brightness(0) invert(1);
    }
    .mobile-sidebar .menu li.active a.menu-link,
    .mobile-sidebar .menu li:hover a.menu-link {
      background: #FFD700; color: black; border-radius: 12px;
    }

    /* Mobile Adjustments */
    @media (max-width: 768px) {
      .hamburger { display: flex !important; }
      .sidebar { display: none !important; }
      header { padding-left: 80px !important; }
      .content-area { padding: 100px 20px 40px !important; }
      .create-report-btn { float: none; margin-top: 1rem; width: 100%; justify-content: center; }
    }
    @media (max-width: 480px) {
      .content-area { padding: 90px 15px 30px !important; }
      .duty-meta { flex-direction: column; gap: 0.5rem; }
    }
    /* Floating Modals (ensure report modal displays correctly) */
    .floating-modal { display: none; position: fixed; inset: 0; z-index: 4000; }
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
    /* Image modal styles so previews open correctly above floating modal */
    .image-modal {
      display: none;
      position: fixed;
      z-index: 1000000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.95);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 12px;
    }
    .image-modal-content {
      max-width: calc(100vw - 32px);
      max-height: calc(100vh - 64px);
      object-fit: contain;
      border-radius: 8px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.7);
      display: block;
      margin: 0 auto;
    }
    .image-modal-close {
      position: absolute;
      right: 12px;
      top: 10px;
      color: #fff;
      font-size: 34px;
      font-weight: 700;
      cursor: pointer;
      z-index: 1000001;
      background: rgba(0,0,0,0.24);
      padding: 6px 10px;
      border-radius: 8px;
    }
    .attachment-preview img { cursor: pointer; border: 1px solid #e6e6e6; border-radius: 6px; }
    /* Hide images that have empty src to avoid stray placeholders */
    img[src=""] { display: none !important; }

    /* Mobile-friendly floating dialog: centered, internal scroll, sticky header/footer */
    @media (max-width: 768px) {
      .floating-dialog {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: calc(100% - 32px);
        max-width: 640px;
        max-height: calc(100vh - 80px);
        margin: 0 auto;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        background: #fff;
        overflow: hidden;
      }
      .floating-header {
        position: sticky;
        top: 0;
        z-index: 20;
        padding: 0.85rem 1rem;
      }
      .floating-body {
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
        flex: 1 1 auto;
        padding: 0.9rem 1rem;
      }
      .modal-footer {
        position: sticky;
        bottom: 0;
        z-index: 20;
        background: #fff;
        padding: 0.75rem 1rem;
        display: flex;
        gap: 0.5rem;
        flex-direction: column;
      }
      .modal-footer .btn { width: 100%; }
      .floating-close { right: 0.8rem; }
      .floating-body .form-control { font-size: 0.98rem; }
    }
  </style>
  <!-- Fonts & Icons -->
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
<!-- Hamburger Button (Mobile Only) -->
  <button class="hamburger" id="hamburgerBtn" aria-label="Open Menu">
    <i class="fas fa-bars"></i>
  </button>

  <!-- Mobile Overlay & Sidebar -->
  <div class="mobile-sidebar-overlay" id="mobileOverlay"></div>
  <div class="mobile-sidebar" id="mobileSidebar">
    <h3 class="sidebar-title">Dashboard</h3>
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

  <div class="container">
    <header>
      <div class="header-left">
        <img src="{{ asset('ASSETS/shield-logo.png') }}" alt="PLV SHIELD Logo" class="logo" />
        <h1>PLV - SHIELD</h1>
      </div>
    </header>

    <div class="main-content">
      <!-- Desktop Sidebar -->
      <div class="sidebar">
        <h3 class="sidebar-title">Dashboard</h3>
        <ul class="menu">
          <li><a href="{{ route('member.profile') }}" class="menu-link"><img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon">Profile</a></li>
          <li><a href="{{ route('member.announcement') }}" class="menu-link"><img src="{{ asset('ASSETS/announce-icon.png') }}" class="icon">Announcement</a></li>
          <li><a href="{{ route('member.duties') }}" class="menu-link"><img src="{{ asset('ASSETS/viewreport-icon.png') }}" class="icon">Duties</a></li>
          <li><a href="{{ route('member.duty-history') }}" class="menu-link"><img src="{{ asset('ASSETS/history-icon.png') }}" class="icon">Duty History</a></li>
        </ul>
        <form method="POST" action="{{ route('student.logout') }}" class="logout-form">
          @csrf
          <button class="logout-btn" type="submit">Logout</button>
        </form>
      </div>

      <!-- Main Content -->
      <main class="content-area">
        <div class="d-flex header-row align-items-center mb-4">
          <button type="button" class="btn btn-outline-secondary back-to-duties" aria-label="Back to Duties" onclick="window.location='{{ route('member.duties') }}'">
            <i class="fas fa-arrow-left" style="margin-right:8px;"></i> Back to Duties
          </button>
          <div class="page-title-box">
            <h2 style="color: #000066; margin: 0;">{{ $dutyTitle ?? 'Duty Report' }}</h2>
          </div>
        </div>

        <div class="report-container">
          <!-- Team Leader Info -->
          <div class="info-box">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h3>Team Leader</h3>
                <p class="mb-0" style="margin-top: 0.5rem; font-size: 1.1rem;">
                  @if($teamLeader)
                    {{ $teamLeader }}
                  @else
                    <span class="text-warning">Team Leader not yet assigned</span>
                  @endif
                </p>
              </div>
              @if($duty)
                <div class="duty-meta text-white">
                  <div>{{ $duty->duty_date?->format('M d, Y') ?? 'Date not set' }}</div>
                  <div>{{ $duty->formatted_start_time }} - {{ $duty->formatted_end_time }}</div>
                </div>
              @endif
            </div>
          </div>

          <!-- Participants -->
          <div class="participants-section">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h3>Participants</h3>
              @if($participants)
                <span class="badge">{{ count($participants) }} Member{{ count($participants) !== 1 ? 's' : '' }}</span>
              @endif
            </div>
            <div class="participants-list">
              @forelse($participants ?? [] as $participant)
                @php
                  $student = $participant->student ?? null;
                  $name = $student?->name ?? trim(($participant->first_name ?? '') . ' ' . ($participant->last_name ?? ''));
                  $plvId = $student?->plv_id ?? $participant->plv_student_id ?? 'N/A';
                @endphp
                <div class="participant-item">
                  <div class="d-flex align-items-center">
                    <div>
                      <div class="fw-bold">{{ $name ?: 'Unknown' }}</div>
                      <div class="text-muted small">PLV ID: {{ $plvId }}</div>
                    </div>
                  </div>
                </div>
              @empty
                <div class="no-participants">No participants found</div>
              @endforelse
            </div>
          </div>

          <!-- Report Button -->
          @if(empty($historyMode))
            <button class="create-report-btn" id="showReportFormBtn" type="button">
              {{ $existingReport ? 'Edit Report' : 'Create Report' }}
            </button>
          @endif
        </div>
      </main>
    </div>
  </div>

  @if(empty($historyMode))
  <!-- Floating Report Modal -->
  <div id="reportModal" class="floating-modal" aria-hidden="true">
    <div class="floating-backdrop" id="reportModalBackdrop"></div>
    <div class="floating-dialog" role="dialog" aria-modal="true" aria-labelledby="reportModalTitle">
      <div class="floating-header">
        <h3 id="reportModalTitle">{{ $existingReport ? 'Edit Report Details' : 'Add Report Details' }}</h3>
        <button type="button" class="floating-close" id="closeReportModal" aria-label="Close">&times;</button>
      </div>
      <div class="floating-body">
        <form action="{{ route('member.report.store') }}" method="POST" enctype="multipart/form-data" class="report-form">
          @csrf
          <input type="hidden" name="event_id" value="{{ $duty->event_id ?? '' }}">

          <div class="form-group">
            <label for="summary">Summary:</label>
            <input
              class="form-control"
              id="summary"
              name="summary"
              type="text"
              placeholder="Short summary (max 255 chars)"
              required
              maxlength="255"
              value="{{ $existingReport->summary ?? '' }}"
            />
          </div>

          <div class="form-group">
            <label for="details">Details / Narrative:</label>
            <textarea
              class="form-control"
              id="details"
              name="details"
              placeholder="Enter full narrative about your activity..."
              required
            >{{ $existingReport->details ?? '' }}</textarea>
          </div>

          <div class="form-group">
            <label>Attach Images (optional):</label>
            @if($existingReport && $existingReport->attachments)
              <div class="mb-3">
                <p class="small text-muted">Current attachments:</p>
                <div class="d-flex flex-wrap gap-2 mb-3">
                  @foreach($existingReport->attachments as $attachment)
                    <div class="attachment-preview">
                      <img src="{{ asset('storage/' . $attachment) }}" 
                           alt="Current attachment" 
                           class="img-thumbnail image-preview" 
                           style="height: 60px;"
                           onclick="openImageModal(this.src)">
                    </div>
                  @endforeach
                </div>
                <p class="small text-muted">Upload new images to replace the existing ones:</p>
              </div>
            @endif
            <div class="file-input-wrapper">
              <input
                type="file"
                id="attachments"
                name="attachments[]"
                accept="image/*"
                multiple
                class="form-control"
              >
            </div>
            <div class="file-format-hint">Supported formats: JPG, PNG, GIF. Multiple files allowed (each max ~5MB).</div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="cancelReport">Cancel</button>
            <button type="submit" class="btn btn-primary">
              {{ $existingReport ? 'Update Report' : 'Submit Report' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endif

  <!-- Image Preview Modal -->
  <div id="imageModal" class="image-modal">
    <span class="image-modal-close" onclick="closeImageModal()">&times;</span>
    <img id="modalImage" class="image-modal-content">
  </div>

  <script>
// Hamburger Menu
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
      document.querySelectorAll('.mobile-sidebar .menu-link').forEach(link => link.addEventListener('click', closeMenu));
      document.addEventListener('keydown', e => { if (e.key === 'Escape' && mobileSidebar.classList.contains('active')) closeMenu(); });
    });
    // Floating modal controls
    document.addEventListener('DOMContentLoaded', function(){
      var openBtn = document.getElementById('showReportFormBtn');
      var modal = document.getElementById('reportModal');
      var backdrop = document.getElementById('reportModalBackdrop');
      var closeBtn = document.getElementById('closeReportModal');
      var cancelBtn = document.getElementById('cancelReport');
      var hamburgerBtn = document.getElementById('hamburgerBtn');

      function showModal(){
        if(!modal) return;
        modal.style.display = 'block';
        modal.setAttribute('aria-hidden','false');
        // hide hamburger to avoid it overlapping the modal on small screens
        try { if(hamburgerBtn) hamburgerBtn.style.visibility = 'hidden'; } catch(e){}
      }
      function hideModal(){
        if(!modal) return;
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden','true');
        try { if(hamburgerBtn) hamburgerBtn.style.visibility = ''; } catch(e){}
      }

      if(openBtn) openBtn.addEventListener('click', showModal);
      if(closeBtn) closeBtn.addEventListener('click', hideModal);
      if(cancelBtn) cancelBtn.addEventListener('click', hideModal);
      if(backdrop) backdrop.addEventListener('click', hideModal);
      document.addEventListener('keydown', function(e){ if(e.key === 'Escape'){ hideModal(); } });
    });

    // Image modal controls
    function openImageModal(imageSrc) {
      var modal = document.getElementById('imageModal');
      var modalImg = document.getElementById('modalImage');
      if (!modal || !modalImg) return;
      // ensure modal is a child of body so it stacks above other positioned parents
      if (modal.parentNode !== document.body) document.body.appendChild(modal);
      modal.style.zIndex = 1000000;
      modalImg.src = imageSrc;
      modal.style.display = 'block';
      // prevent body scroll while image modal is open
      document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
      var modal = document.getElementById('imageModal');
      var modalImg = document.getElementById('modalImage');
      if (!modal) return;
      modal.style.display = 'none';
      if (modalImg) modalImg.src = '';
      document.body.style.overflow = '';
    }

    // Close when user clicks the backdrop or close control
    document.addEventListener('click', function (e) {
      var modal = document.getElementById('imageModal');
      if (!modal) return;
      if (e.target === modal) closeImageModal();
      var closeControl = document.querySelector('.image-modal-close');
      if (closeControl && e.target === closeControl) closeImageModal();
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeImageModal();
      }
    });

    // Attach click handlers to thumbnails (in case onclick attributes are missing)
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.attachment-preview img, .image-preview').forEach(function(img) {
        img.style.cursor = 'pointer';
        img.addEventListener('click', function(ev) {
          var src = img.dataset.src || img.src || img.getAttribute('src');
          if (src) openImageModal(src);
        });
      });
      // Ensure image modal is hidden on initial load (prevents stray placeholders)
      try {
        var im = document.getElementById('imageModal');
        var imImg = document.getElementById('modalImage');
        if (im) { im.style.display = 'none'; im.setAttribute('aria-hidden','true'); }
        if (imImg) { imImg.src = ''; }
      } catch(e){}
    });
  </script>
</body>
</html>