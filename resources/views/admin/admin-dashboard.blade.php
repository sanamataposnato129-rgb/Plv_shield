<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PLV - SHIELD Admin Dashboard</title>
  <link rel="stylesheet" href="{{ asset('css/admin/admin-dashboard.css') }}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* Ensure hamburger only visible on small screens for this view */
    .hamburger { display: none !important; }
    @media (max-width: 768px) {
      .hamburger { display: flex !important; align-items: center !important; justify-content: center !important; }
    }
  </style>
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
        <li class="active"><a href="{{ route('admin.dashboard') }}" class="menu-link"><img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon">Profile</a></li>
        <li><a href="{{ route('admin.approvals') }}" class="menu-link"><img src="{{ asset('ASSETS/checkreport-icon.png') }}" class="icon">Approvals</a></li>
        <li><a href="{{ route('admin.students.index') }}" class="menu-link"><img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon">Students</a></li>
        <li><a href="{{ route('admin.create-duties') }}" class="menu-link"><img src="{{ asset('ASSETS/createduty-icon.png') }}" class="icon">Duties</a></li>
        <li><a href="{{ route('admin.in-progress') }}" class="menu-link"><img src="{{ asset('ASSETS/in-progress-icon.png') }}" class="icon">In Progress</a></li>
        <li><a href="{{ route('admin.view-reports') }}" class="menu-link"><img src="{{ asset('ASSETS/viewreport-icon.png') }}" class="icon">View Reports</a></li>
        <li><a href="{{ route('admin.history') }}" class="menu-link"><img src="{{ asset('ASSETS/history-icon.png') }}" class="icon">History</a></li>
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

    <div class="main-content">
      <!-- SIDEBAR -->
      <div class="sidebar">
        <h3 class="sidebar-title">Dashboard</h3>
          <ul class="menu">
          <li class="active"><a href="{{ route('admin.dashboard') }}" class="menu-link"><img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon">Profile</a></li>
          <li><a href="{{ route('admin.approvals') }}" class="menu-link"><img src="{{ asset('ASSETS/checkreport-icon.png') }}" class="icon">Approvals</a></li>
          <li><a href="{{ route('admin.students.index') }}" class="menu-link"><img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon">Students</a></li>
          <li><a href="{{ route('admin.create-duties') }}" class="menu-link"><img src="{{ asset('ASSETS/createduty-icon.png') }}" class="icon">Duties</a></li>
          <li><a href="{{ route('admin.in-progress') }}" class="menu-link"><img src="{{ asset('ASSETS/in-progress-icon.png') }}" class="icon">In Progress</a></li>
          <li><a href="{{ route('admin.view-reports') }}" class="menu-link"><img src="{{ asset('ASSETS/viewreport-icon.png') }}" class="icon">View Reports</a></li>
          <li><a href="{{ route('admin.history') }}" class="menu-link"><img src="{{ asset('ASSETS/history-icon.png') }}" class="icon">History</a></li>
        </ul>

        <form method="POST" action="{{ route('admin.logout') }}" class="logout-form">
          @csrf
          <button type="submit" class="logout-btn">Logout</button>
        </form>
      </div>

      <!-- CONTENT -->
      <div class="content-area">
        <div class="admin-container">
          <div class="admin-header">
            <h2>Admin Profile</h2>
            <button class="create-account-btn" id="openEditProfile">Edit Profile</button>
          </div>

          <!-- SUCCESS & ERROR MESSAGES -->
          @if(session('success'))
            <div style="background:#e6ffed;color:#046b24;padding:10px;border-radius:6px;margin-bottom:12px;">{{ session('success') }}</div>
          @endif
          @if($errors->any())
            <div style="background:#ffe6e6;color:#8a1f1f;padding:10px;border-radius:6px;margin-bottom:12px;"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
          @endif

          @php $admin = auth('admin')->user(); @endphp
          <div class="profile-info-container">
            <div class="info-section">
              <h3>Account Information</h3>
              <div class="info-grid">
                <div class="info-item">
                  <span class="label">Full Name</span>
                  <span class="value">{{ $admin ? ($admin->first_name . ' ' . $admin->last_name) : 'N/A' }}</span>
                </div>
                <div class="info-item">
                  <span class="label">Username</span>
                  <span class="value">{{ $admin ? $admin->username : 'N/A' }}</span>
                </div>
                <div class="info-item">
                  <span class="label">Email Address</span>
                  <span class="value">{{ $admin ? $admin->email : 'N/A' }}</span>
                </div>
                <div class="info-item">
                  <span class="label">Role</span>
                  <span class="value highlight">{{ $admin ? $admin->admin_type : 'N/A' }}</span>
                </div>
                <div class="info-item">
                  <span class="label">Account Created</span>
                  <span class="value">{{ $admin && $admin->created_at ? \Carbon\Carbon::parse($admin->created_at)->format('M d, Y') : 'N/A' }}</span>
                </div>
                <div class="info-item">
                  <span class="label">Last Login</span>
                  <span class="value">{{ $admin && $admin->last_login ? \Carbon\Carbon::parse($admin->last_login)->format('M d, Y h:i A') : 'Never' }}</span>
                </div>
              </div>
            </div>

            <div class="quick-actions">
              <a href="{{ route('admin.create-duties') }}" class="action-btn">
                <img src="{{ asset('ASSETS/createduty-icon.png') }}" class="icon" alt="" />
                Manage Duties
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- EDIT PROFILE MODAL -->
  <div id="editProfileModal" class="modal">
    <div class="modal-content">
      <h2>Edit Profile</h2>
      <form id="editProfileForm" method="POST" action="{{ route('admin.profile.update') }}">
        @csrf
        @method('PUT')
        <div class="form-row">
          <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" id="adminFirstName" value="{{ $admin ? $admin->first_name : '' }}" required />
            <div id="adminFirstNameError" style="color:#d32f2f; font-size:0.95rem; margin-top:4px; display:none;">No numbers or symbols allowed.</div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" id="adminLastName" value="{{ $admin ? $admin->last_name : '' }}" required />
            <div id="adminLastNameError" style="color:#d32f2f; font-size:0.95rem; margin-top:4px; display:none;">No numbers or symbols allowed.</div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" id="adminUsername" value="{{ $admin ? $admin->username : '' }}" required />
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" id="adminEmail" value="{{ $admin ? $admin->email : '' }}" required />
            <div id="adminEmailError" style="color:#d32f2f; font-size:0.95rem; margin-top:4px; display:none;">Email must be @gmail.com or @plv.edu.ph.</div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group" style="grid-column: 1 / -1;">
            <label>New Password (leave blank to keep current)</label>
            <div style="position:relative;">
              <input type="password" name="password" id="adminPassword" style="padding-right:40px;" />
              <i class="fas fa-eye" id="toggleAdminPassword" style="position:absolute;top:50%;right:12px;transform:translateY(-50%);cursor:pointer;color:#888;"></i>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group" style="grid-column: 1 / -1;">
            <label>Confirm Password</label>
            <div style="position:relative;">
              <input type="password" name="password_confirmation" id="adminConfirmPassword" style="padding-right:40px;" />
              <i class="fas fa-eye" id="toggleAdminConfirmPassword" style="position:absolute;top:50%;right:12px;transform:translateY(-50%);cursor:pointer;color:#888;"></i>
            </div>
            <div id="adminPasswordMatchMessage" style="color:#d32f2f; font-size:0.95rem; margin-top:4px; display:none;"></div>
          </div>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn-save" id="adminProfileSaveBtn" style="transition:opacity 0.2s, background 0.2s;">Save Changes</button>
          <button type="button" class="btn-cancel" id="closeEditProfile">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    const editProfileModal = document.getElementById('editProfileModal');
    const openEditProfile = document.getElementById('openEditProfile');
    const closeEditProfile = document.getElementById('closeEditProfile');

    if (openEditProfile) openEditProfile.addEventListener('click', () => { editProfileModal.style.display = 'flex'; });
    if (closeEditProfile) closeEditProfile.addEventListener('click', () => { editProfileModal.style.display = 'none'; });
    window.addEventListener('click', (e) => { if (e.target === editProfileModal) editProfileModal.style.display = 'none'; });

    // Eye toggles for password fields
    document.getElementById('toggleAdminPassword').addEventListener('click', function() {
      const input = document.getElementById('adminPassword');
      const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
      input.setAttribute('type', type);
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });
    document.getElementById('toggleAdminConfirmPassword').addEventListener('click', function() {
      const input = document.getElementById('adminConfirmPassword');
      const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
      input.setAttribute('type', type);
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });

    // Name validation (letters, spaces, hyphens, apostrophes only)
    function validateNameField(inputId, errorId) {
      const input = document.getElementById(inputId);
      const error = document.getElementById(errorId);
      input.addEventListener('input', function() {
        const value = input.value;
        const regex = /^[A-Za-z\s\-']+$/;
        if (value.length === 0 || regex.test(value)) {
          error.style.display = 'none';
        } else {
          error.style.display = 'block';
        }
      });
    }
    validateNameField('adminFirstName', 'adminFirstNameError');
    validateNameField('adminLastName', 'adminLastNameError');

    // Email validation
    const emailInput = document.getElementById('adminEmail');
    const emailError = document.getElementById('adminEmailError');
    emailInput.addEventListener('input', function() {
      const value = emailInput.value.trim();
      const gmailRegex = /^[A-Za-z0-9._%+-]+@gmail\.com$/;
      const plvRegex = /^[A-Za-z0-9._%+-]+@plv\.edu\.ph$/;
      if (value.length === 0 || gmailRegex.test(value) || plvRegex.test(value)) {
        emailError.style.display = 'none';
      } else {
        emailError.style.display = 'block';
      }
    });

    // Password confirmation validation
    const passwordInput = document.getElementById('adminPassword');
    const confirmPasswordInput = document.getElementById('adminConfirmPassword');
    const passwordMatchMessage = document.getElementById('adminPasswordMatchMessage');
    function checkPasswordMatch() {
      if (!passwordInput.value && !confirmPasswordInput.value) {
        passwordMatchMessage.style.display = 'none';
        passwordMatchMessage.textContent = '';
        return;
      }
      if (passwordInput.value !== confirmPasswordInput.value) {
        passwordMatchMessage.style.display = 'block';
        passwordMatchMessage.textContent = 'Passwords do not match.';
      } else {
        passwordMatchMessage.style.display = 'none';
        passwordMatchMessage.textContent = '';
      }
    }
    passwordInput.addEventListener('input', checkPasswordMatch);
    confirmPasswordInput.addEventListener('input', checkPasswordMatch);

    // Disable Save button if any error is present
    function hasAdminProfileErrors() {
      return (
        document.getElementById('adminFirstNameError').style.display === 'block' ||
        document.getElementById('adminLastNameError').style.display === 'block' ||
        document.getElementById('adminEmailError').style.display === 'block' ||
        document.getElementById('adminPasswordMatchMessage').style.display === 'block'
      );
    }
    const saveBtn = document.getElementById('adminProfileSaveBtn');
    function updateSaveBtnState() {
      const hasError = hasAdminProfileErrors();
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
    ['adminFirstName','adminLastName','adminEmail','adminPassword','adminConfirmPassword'].forEach(id => {
      const el = document.getElementById(id);
      if (el) el.addEventListener('input', updateSaveBtnState);
    });
    setInterval(updateSaveBtnState, 200);

    // Mobile menu toggle
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
  </script>
</body>
</html>