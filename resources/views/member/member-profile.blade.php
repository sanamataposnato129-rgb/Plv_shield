<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PLV - SHIELD Member Profile</title>

  <!-- Fonts & Icons -->
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <!-- Your existing profile CSS + our unified layout -->
  <link rel="stylesheet" href="/css/member/member-profile.css" />

  <style>
    /* ==================== UNIFIED LAYOUT (SAME AS ALL PAGES) ==================== */
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

    .profile-header {
      background: linear-gradient(to right, #000066, #191970);
      color: #FFD700;
      text-align: center;
      font-size: 24px;
      font-weight: bold;
      padding: 18px;
      border-radius: 10px;
      margin-bottom: 30px;
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
      <li class="active"><a href="{{ route('member.profile') }}" class="menu-link"><img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon"> Profile</a></li>
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
          <li class="active"><a href="{{ route('member.profile') }}" class="menu-link"><img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon">Profile</a></li>
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
        <div class="profile-header">Profile</div>

        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
          <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <div class="profile-container">
          <div class="profile-summary">
            <div class="profile-avatar">
              {{ strtoupper(substr(($student->first_name ?? 'S'),0,1)) }}
            </div>
            <div class="profile-details">
              <h3>{{ trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? '')) ?: 'Student' }}</h3>
              <div class="profile-meta">
                <div class="meta-item"><div class="label">PLV Student ID</div><div class="value">{{ $student->plv_student_id ?? '-' }}</div></div>
                <div class="meta-item"><div class="label">Email</div><div class="value">{{ $student->email ?? '-' }}</div></div>
                <div class="meta-item"><div class="label">First Name</div><div class="value">{{ $student->first_name ?? '-' }}</div></div>
                <div class="meta-item"><div class="label">Last Name</div><div class="value">{{ $student->last_name ?? '-' }}</div></div>
              </div>
              <div style="margin-top:16px;">
                <button id="openEditBtn" class="btn btn-primary">Edit Profile</button>
                <a href="{{ route('member.duties') }}" class="btn btn-secondary">View Duties</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Edit Modal -->
        <div id="editModal" class="modal" aria-hidden="true">
          <div class="modal-backdrop" id="editBackdrop"></div>
          <div class="modal-body" role="dialog" aria-modal="true" aria-labelledby="editProfileTitle">
            <h3 id="editProfileTitle">Edit Profile</h3>
            <form id="editProfileForm" method="POST" action="{{ route('member.profile.update') }}">
              @csrf
              @method('PUT')
              <div class="form-grid">
                <div class="form-row">
                  <label for="plv_student_id">PLV Student ID</label>
                  <input type="text" id="plv_student_id" name="plv_student_id" value="{{ $student->plv_student_id ?? '' }}" readonly />
                </div>
                <div class="form-row">
                  <label for="first_name">First Name</label>
                  <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $student->first_name ?? '') }}" required />
                  <div id="firstNameError" style="color:#d32f2f; font-size:0.95rem; margin-top:4px; display:none;">No numbers or symbols allowed.</div>
                </div>
                <div class="form-row">
                  <label for="last_name">Last Name</label>
                  <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $student->last_name ?? '') }}" required />
                  <div id="lastNameError" style="color:#d32f2f; font-size:0.95rem; margin-top:4px; display:none;">No numbers or symbols allowed.</div>
                </div>
                <div class="form-row">
                  <label for="email">Email</label>
                  <input type="email" id="email" name="email" value="{{ old('email', $student->email ?? '') }}" required />
                  <div id="emailError" style="color:#d32f2f; font-size:0.95rem; margin-top:4px; display:none;">Email must be valid Gmail format.</div>
                </div>
                <div class="form-row">
                  <label for="password">New Password (leave blank to keep current)</label>
                  <div style="position:relative;">
                    <input type="password" id="password" name="password" style="padding-right:40px;" />
                    <i class="fas fa-eye" id="togglePassword" style="position:absolute;top:50%;right:12px;transform:translateY(-50%);cursor:pointer;color:#888;"></i>
                  </div>
                </div>
                <div class="form-row">
                  <label for="password_confirmation">Confirm Password</label>
                  <div style="position:relative;">
                    <input type="password" id="password_confirmation" name="password_confirmation" style="padding-right:40px;" />
                    <i class="fas fa-eye" id="togglePasswordConfirm" style="position:absolute;top:50%;right:12px;transform:translateY(-50%);cursor:pointer;color:#888;"></i>
                  </div>
                  <div id="passwordMatchError" style="color:#d32f2f; font-size:0.95rem; margin-top:4px; display:none;">Passwords do not match.</div>
                </div>
              </div>
              <div class="modal-actions">
                <button type="button" id="cancelEdit" class="btn btn-light">Cancel</button>
                <button type="submit" id="saveBtn" class="btn btn-primary" style="transition:opacity 0.2s, background 0.2s;">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </main>

      <!-- Confirmation Overlay (shows summary of changes before actual submit) -->
      <div id="confirmOverlay" class="confirm-overlay" aria-hidden="true">
        <div class="confirm-backdrop" id="confirmBackdrop"></div>
        <div class="confirm-card" role="dialog" aria-modal="true" aria-labelledby="confirmTitle">
          <h4 id="confirmTitle">Confirm account changes</h4>
          <div class="confirm-note">Please review the updated information below. Click "Confirm" to save changes or "Back" to edit.</div>
          <div id="confirmList" class="confirm-list" aria-live="polite"></div>
          <div class="confirm-actions">
            <button id="backToEdit" type="button" class="btn btn-light">Back</button>
            <button id="confirmSubmit" type="button" class="btn btn-primary">Confirm</button>
          </div>
        </div>
      </div>

      <!-- Success popup (redesigned to match example) -->
      <div id="successOverlay" class="success-overlay" aria-hidden="true">
        <div class="confirm-backdrop" id="successBackdrop"></div>
        <div class="success-card" role="dialog" aria-modal="true" aria-labelledby="successTitle">
          <div class="success-art">✓</div>
          <div class="success-title" id="successMessage">Profile Updated Successfully</div>
          <div class="success-desc" id="successSub">Your account information has been saved.</div>
          <div class="success-actions">
            <a href="{{ route('member.profile') }}" class="btn-outline">View Profile</a>
            <button id="successOk" type="button" class="btn-accent">OK</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Hamburger Menu Script -->
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
        if (e.key === 'Escape' && mobileSidebar.classList.contains('active')) closeMenu();
      });
    });
  </script>
  <script>
    // Profile edit modal behavior
    (function(){
      const openBtn = document.getElementById('openEditBtn');
      const modal = document.getElementById('editModal');
      const backdrop = document.getElementById('editBackdrop');
      const cancel = document.getElementById('cancelEdit');
      const form = document.getElementById('editProfileForm');

      const confirmOverlay = document.getElementById('confirmOverlay');
      const confirmBackdrop = document.getElementById('confirmBackdrop');
      const confirmList = document.getElementById('confirmList');
      const backToEdit = document.getElementById('backToEdit');
      const confirmSubmit = document.getElementById('confirmSubmit');

      function openModal() {
        modal.classList.add('show');
        modal.setAttribute('aria-hidden','false');
      }
      function closeModal() {
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden','true');
      }

      function showConfirmOverlay(itemsHtml) {
        confirmList.innerHTML = itemsHtml;
        confirmOverlay.classList.add('show');
        confirmOverlay.setAttribute('aria-hidden','false');
      }
      function hideConfirmOverlay() {
        confirmOverlay.classList.remove('show');
        confirmOverlay.setAttribute('aria-hidden','true');
      }

      if (openBtn) openBtn.addEventListener('click', openModal);
      if (cancel) cancel.addEventListener('click', closeModal);
      if (backdrop) backdrop.addEventListener('click', closeModal);

      // Eye toggles for password fields
      document.getElementById('togglePassword')?.addEventListener('click', function() {
        const input = document.getElementById('password');
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
      });
      document.getElementById('togglePasswordConfirm')?.addEventListener('click', function() {
        const input = document.getElementById('password_confirmation');
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
      });

      // Name validation (letters, spaces, hyphens, apostrophes only)
      function validateNameField(inputId, errorId) {
        const input = document.getElementById(inputId);
        const error = document.getElementById(errorId);
        if (!input || !error) return;
        input.addEventListener('input', function() {
          const value = input.value;
          const regex = /^[A-Za-z\s\-']+$/;
          if (value.length === 0 || regex.test(value)) {
            error.style.display = 'none';
          } else {
            error.style.display = 'block';
          }
          updateSaveBtnState();
        });
      }
      validateNameField('first_name', 'firstNameError');
      validateNameField('last_name', 'lastNameError');

      // Email validation (Gmail only)
      const emailInput = document.getElementById('email');
      const emailError = document.getElementById('emailError');
      if (emailInput && emailError) {
        emailInput.addEventListener('input', function() {
          const value = emailInput.value.trim();
          const gmailRegex = /^[A-Za-z0-9._%+-]+@gmail\.com$/;
          if (value.length === 0 || gmailRegex.test(value)) {
            emailError.style.display = 'none';
          } else {
            emailError.style.display = 'block';
          }
          updateSaveBtnState();
        });
      }

      // Password confirmation validation
      const passwordInput = document.getElementById('password');
      const confirmPasswordInput = document.getElementById('password_confirmation');
      const passwordMatchError = document.getElementById('passwordMatchError');
      function checkPasswordMatch() {
        if (!passwordInput.value && !confirmPasswordInput.value) {
          passwordMatchError.style.display = 'none';
          return;
        }
        if (passwordInput.value !== confirmPasswordInput.value) {
          passwordMatchError.style.display = 'block';
        } else {
          passwordMatchError.style.display = 'none';
        }
        updateSaveBtnState();
      }
      if (passwordInput && confirmPasswordInput) {
        passwordInput.addEventListener('input', checkPasswordMatch);
        confirmPasswordInput.addEventListener('input', checkPasswordMatch);
      }

      // Disable Save button if any error is present
      function hasEditErrors() {
        return (
          (document.getElementById('firstNameError')?.style.display === 'block') ||
          (document.getElementById('lastNameError')?.style.display === 'block') ||
          (document.getElementById('emailError')?.style.display === 'block') ||
          (document.getElementById('passwordMatchError')?.style.display === 'block')
        );
      }
      const saveBtn = document.getElementById('saveBtn');
      function updateSaveBtnState() {
        if (!saveBtn) return;
        const hasError = hasEditErrors();
        saveBtn.disabled = hasError;
        if (hasError) {
          saveBtn.style.background = '#bbb';
          saveBtn.style.opacity = '0.6';
          saveBtn.style.cursor = 'not-allowed';
        } else {
          saveBtn.style.background = '';
          saveBtn.style.opacity = '1';
          saveBtn.style.cursor = '';
        }
      }
      ['first_name','last_name','email','password','password_confirmation'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('input', updateSaveBtnState);
      });
      setInterval(updateSaveBtnState, 200);
      document.addEventListener('keydown', function(e){ if (e.key === 'Escape') { hideConfirmOverlay(); closeModal(); } });

      // Intercept form submit to show confirm overlay with the updated values
      if (form) {
        form.addEventListener('submit', function(e){
          if (hasEditErrors()) {
            e.preventDefault();
            return;
          }
          e.preventDefault();
          // build summary based on form inputs
          const data = new FormData(form);
          const rows = [];
          // order: plv_student_id, first_name, last_name, email
          const fields = [
            { key: 'plv_student_id', label: 'PLV Student ID' },
            { key: 'first_name', label: 'First Name' },
            { key: 'last_name', label: 'Last Name' },
            { key: 'email', label: 'Email' }
          ];
          fields.forEach(f => {
            const val = (data.get(f.key) || '').toString();
            rows.push(`<div class=\"confirm-row\"><div class=\"label\">${f.label}</div><div class=\"value\">${escapeHtml(val) || '-'}</div></div>`);
          });
          showConfirmOverlay(rows.join('\n'));
        });
      }

      // Back button from confirm -> close overlay and keep modal open
      if (backToEdit) backToEdit.addEventListener('click', function(){ hideConfirmOverlay(); });

      // Confirm submit -> actually submit the form
      if (confirmSubmit) confirmSubmit.addEventListener('click', function(){
        // hide overlay and submit
        hideConfirmOverlay();
        // close modal UI (optional)
        closeModal();
        form.submit();
      });

      // small html escape helper
      function escapeHtml(str) {
        return String(str)
          .replace(/&/g, '&amp;')
          .replace(/</g, '&lt;')
          .replace(/>/g, '&gt;')
          .replace(/"/g, '&quot;')
          .replace(/'/g, '&#39;');
      }

      // Success overlay handling
      const successOverlay = document.getElementById('successOverlay');
      const successOk = document.getElementById('successOk');
      const successMessage = document.getElementById('successMessage');
      const successSub = document.getElementById('successSub');

      function showSuccessOverlay(msg, sub) {
        if (!successOverlay) return;
        // map texts
        const title = msg || 'Profile Updated Successfully';
        const desc = sub || 'Your account information has been saved.';
        const titleEl = document.getElementById('successMessage');
        const descEl = document.getElementById('successSub');
        if (titleEl) titleEl.innerText = title;
        if (descEl) descEl.innerText = desc;
        successOverlay.classList.add('show');
        successOverlay.setAttribute('aria-hidden','false');
      }
      function hideSuccessOverlay() {
        if (!successOverlay) return;
        successOverlay.classList.remove('show');
        successOverlay.setAttribute('aria-hidden','true');
      }
      if (successOk) successOk.addEventListener('click', hideSuccessOverlay);

      // expose globally so server-rendered script can trigger it after page load
      window.showSuccessOverlay = showSuccessOverlay;
      window.hideSuccessOverlay = hideSuccessOverlay;
    })();
  </script>
  @if(session('success'))
    <script>
      document.addEventListener('DOMContentLoaded', function(){
        // Use the session message as the overlay text (escaped via blade json encoding)
        if (window.showSuccessOverlay) {
          window.showSuccessOverlay({{ json_encode(session('success')) }});
        }
      });
    </script>
  @endif
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