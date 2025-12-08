<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PLV - SHIELD | Super Admin</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root { 
      --header-height: 90px; 
      --container-max-width: 1200px;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { 
      font-family: 'Segoe UI', Arial, sans-serif; 
      background: #fff8dc; 
      overflow-x: hidden; 
    }

    /* ────────────────────── HEADER & SIDEBARS (unchanged) ────────────────────── */
    header {
      position: fixed; top: 0; left: 0; right: 0; height: var(--header-height);
      background: linear-gradient(to right, #000066, #191970); color: #FFD700;
      display: flex; align-items: center; justify-content: space-between;
      padding: 15px 40px; border-bottom: 3px solid #000066; z-index: 2000;
      box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }
    .header-left { display: flex; align-items: center; gap: 15px; }
    .logo { height: 60px; }
    header h1 { font-size: 28px; font-weight: 800; }

    .hamburger { display: none; position: fixed; top: 20px; left: 20px; z-index: 3000;
      background: #191970; color: #FFD700; border: none; width: 50px; height: 50px;
      border-radius: 50%; cursor: pointer; box-shadow: 0 4px 15px rgba(0,0,0,0.3);
      transition: all .3s; align-items:center; justify-content:center;
    }
    .hamburger svg rect { fill:#FFD700; }

    .mobile-sidebar-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:2500;
      opacity:0; visibility:hidden; transition:all .3s;
    }
    .mobile-sidebar-overlay.active { opacity:1; visibility:visible; }

    .mobile-sidebar { position:fixed; top:0; left:-280px; width:280px; height:100vh;
      background:linear-gradient(to bottom,#000066,#0A0A40); z-index:2600;
      padding:100px 20px 20px; transition:left .35s cubic-bezier(.25,.8,.25,1);
      box-shadow:4px 0 20px rgba(0,0,0,.3); display:flex; flex-direction:column;
    }
    .mobile-sidebar.active { left:0; }

    .sidebar { position:fixed; top:var(--header-height); left:0; width:240px;
      height:calc(100vh - var(--header-height)); background:linear-gradient(to bottom,#000066,#0A0A40);
      padding:20px 0; z-index:1000; display:flex; flex-direction:column;
    }

    .sidebar-title, .mobile-sidebar .sidebar-title { color:#FFD700; font-weight:bold;
      text-align:center; margin-bottom:20px; font-size:20px;
    }
    .menu { list-style:none; flex:1; }
    .menu li a.menu-link { display:flex; align-items:center; gap:12px; padding:14px 25px;
      color:white; text-decoration:none; border-radius:12px; margin:0 15px;
    }
    .menu li a.menu-link img.icon { width:22px; height:22px; filter:brightness(0) invert(1); }
    .menu li.active a.menu-link, .menu li:hover a.menu-link { background:#FFD700; color:black; font-weight:bold; }

    .logout-form { margin-top:auto; padding:20px; text-align:center; }
    .logout-btn { background:#FFD700; color:black; font-weight:bold; border:none;
      padding:12px 40px; border-radius:30px; cursor:pointer; transition:all .3s;
    }
    .logout-btn:hover { background:#ffea00; transform:scale(1.05); box-shadow:0 0 15px rgba(255,215,0,.8); }

    /* ────────────────────── CONTENT ────────────────────── */
    .content-area { margin-left:240px; margin-top:var(--header-height);
      min-height:calc(100vh - var(--header-height)); padding:40px 20px;
      display:flex; justify-content:center;
    }
    .main-container { background:#fff; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,.08);
      width:100%; max-width:var(--container-max-width); padding:40px;
    }

    .admin-header { display:flex; justify-content:space-between; align-items:center;
      margin-bottom:30px; flex-wrap:wrap; gap:15px;
    }
    .admin-header h2 { font-size:28px; color:#191970; font-weight:700; }
    .create-account-btn { padding:12px 28px; background:#FFD700; color:black;
      font-weight:bold; border:none; border-radius:30px; cursor:pointer;
    }

    .info-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
      gap:20px;
    }
    .info-item { background:#f8f9fa; padding:18px; border-radius:12px;
      border-left:4px solid #000066;
    }
    .info-item .label { display:block; color:#666; font-size:.9rem; margin-bottom:6px; }
    .info-item .value { font-weight:600; color:#1e293b; font-size:1.05rem; }
    .highlight { color:#8000FF !important; font-weight:bold; }

    /* ────────────────────── MODAL (mobile fixed) ────────────────────── */
    .modal-backdrop { position:fixed; inset:0; background:rgba(0,0,0,.65);
      backdrop-filter:blur(4px); z-index:2998; opacity:0; visibility:hidden; transition:all .3s;
    }
    .modal-backdrop.show { opacity:1; visibility:visible; }
    .modal { position:fixed; inset:0; z-index:2999; display:flex; align-items:center;
      justify-content:center; padding:20px; opacity:0; visibility:hidden; transition:all .3s;
      overflow-y:auto;
    }
    .modal.show { opacity:1; visibility:visible; }
    .modal-dialog { width:100%; max-width:500px; }
    .modal-content { background:#fff; border-radius:16px; padding:30px;
      box-shadow:0 20px 60px rgba(0,0,0,.3); position:relative;
      animation:modalPop .35s cubic-bezier(.2,.8,.3,1);
    }
    @keyframes modalPop { from{opacity:0;transform:scale(.92) translateY(30px)} to{opacity:1;transform:scale(1)} }
    .modal-close { position:absolute; top:15px; right:15px; background:none; border:none;
      font-size:28px; color:#999; cursor:pointer; width:40px; height:40px;
      border-radius:50%; display:flex; align-items:center; justify-content:center;
    }
    .modal-close:hover { background:#f0f0f0; color:#333; }

    .form-row { display:flex; gap:15px; margin-bottom:18px; }
    .form-group { flex:1; }
    .form-group label { display:block; margin-bottom:6px; color:#444; font-weight:500; }
    .form-group input { width:100%; padding:12px 14px; border:1px solid #ddd;
      border-radius:8px; font-size:15px;
    }
    .form-group input:focus { outline:none; border-color:#8000FF;
      box-shadow:0 0 0 3px rgba(128,0,255,.15);
    }
    .modal-footer { margin-top:30px; display:flex; gap:12px; justify-content:flex-end; }
    .btn { padding:12px 28px; border:none; border-radius:8px; font-weight:bold; cursor:pointer; }
    .btn-success { background:#16a34a; color:#fff; }
    .btn-secondary { background:#6b7280; color:#fff; }

    /* ────────────────────── RESPONSIVE ────────────────────── */
    @media (max-width:992px) {
      .hamburger { display:flex; }
      .sidebar { display:none !important; }
      header { padding-left:80px !important; }
      .content-area { margin-left:0 !important; padding:110px 15px 50px !important; }
    }
    @media (max-width:480px) {
      .content-area { padding:100px 10px 40px !important; }
      .form-row { flex-direction:column; }
      .modal-footer { flex-direction:column; }
      .btn { width:100%; }
    }
  </style>
</head>
<body>

  <!-- Hamburger -->
  <button class="hamburger" id="hamburgerBtn">
    <svg width="28" height="28" viewBox="0 0 100 100">
      <rect width="80" height="12" x="10" y="20" rx="6" fill="#FFD700"></rect>
      <rect width="80" height="12" x="10" y="44" rx="6" fill="#FFD700"></rect>
      <rect width="80" height="12" x="10" y="68" rx="6" fill="#FFD700"></rect>
    </svg>
  </button>

  <!-- Mobile Overlay & Sidebar -->
  <div class="mobile-sidebar-overlay" id="mobileOverlay"></div>
  <div class="mobile-sidebar" id="mobileSidebar">
    <h3 class="sidebar-title">Super Admin</h3>
    <ul class="menu">
      <li class="active"><a href="{{ route('super-admin.dashboard') }}" class="menu-link">
        <img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon"> Profile
      </a></li>
      <li><a href="{{ route('super-admin.manage-admins') }}" class="menu-link">
        <img src="{{ asset('ASSETS/admin-icon.png') }}" class="icon"> Admin Accounts
      </a></li>
    </ul>
    <form method="POST" action="{{ route('admin.logout') }}" class="logout-form">
      @csrf
      <button type="submit" class="logout-btn">Logout</button>
    </form>
  </div>

  <!-- Header -->
  <header>
    <div class="header-left">
      <img src="{{ asset('ASSETS/shield-logo.png') }}" alt="Logo" class="logo">
      <h1>PLV - SHIELD</h1>
    </div>
  </header>

  <!-- Desktop Sidebar -->
  <div class="sidebar">
    <h3 class="sidebar-title">Super Admin</h3>
    <ul class="menu">
      <li class="active"><a href="{{ route('super-admin.dashboard') }}" class="menu-link">
        <img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon"> Profile
      </a></li>
      <li><a href="{{ route('super-admin.manage-admins') }}" class="menu-link">
        <img src="{{ asset('ASSETS/admin-icon.png') }}" class="icon"> Admin Accounts
      </a></li>
    </ul>
    <form method="POST" action="{{ route('admin.logout') }}" class="logout-form">
      @csrf
      <button type="submit" class="logout-btn">Logout</button>
    </form>
  </div>

  <!-- Main Content -->
  <div class="content-area">
    <div class="main-container">

      <!-- Define $admin here (fixes the error) -->
      @php $admin = auth('admin')->user(); @endphp

      <div class="admin-header">
        <h2>Super Admin Profile</h2>
        <button class="create-account-btn" id="openEditProfile">Edit Profile</button>
      </div>

      @if(session('success'))
        <div style="background:#d4edda;color:#155724;padding:15px;border-radius:8px;margin-bottom:20px;">
          {{ session('success') }}
        </div>
      @endif

      @if($errors->any())
        <div style="background:#f8d7da;color:#721c24;padding:15px;border-radius:8px;margin-bottom:20px;">
          <ul style="margin:10px 0;padding-left:20px;">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
          </ul>
        </div>
      @endif

      <div class="info-section">
        <h3 style="margin-bottom:20px;color:#191970;font-size:22px;">Account Information</h3>
        <div class="info-grid">
          <div class="info-item"><span class="label">Full Name</span><span class="value">{{ $admin?->first_name }} {{ $admin?->last_name }}</span></div>
          <div class="info-item"><span class="label">Username</span><span class="value">{{ $admin?->username ?? 'N/A' }}</span></div>
          <div class="info-item"><span class="label">Email Address</span><span class="value">{{ $admin?->email ?? 'N/A' }}</span></div>
          <div class="info-item"><span class="label">Role</span><span class="value highlight">{{ $admin?->admin_type ?? 'N/A' }}</span></div>
          <div class="info-item"><span class="label">Account Created</span><span class="value">
            {{ $admin?->created_at ? \Carbon\Carbon::parse($admin->created_at)->format('M d, Y') : 'N/A' }}
          </span></div>
          <div class="info-item"><span class="label">Last Login</span><span class="value">
            {{ $admin?->last_login ? \Carbon\Carbon::parse($admin->last_login)->format('M d, Y h:i A') : 'Never' }}
          </span></div>
        </div>
      </div>

      <div style="margin-top:40px;text-align:center;">
        <a href="{{ route('super-admin.manage-admins') }}" style="display:inline-flex;align-items:center;gap:12px;padding:14px 32px;background:#000066;color:#FFD700;text-decoration:none;border-radius:30px;font-weight:bold;">
          <img src="{{ asset('ASSETS/admin-icon.png') }}" style="width:24px;height:24px;filter:brightness(0)invert(1);" alt=""> Manage Administrators
        </a>
      </div>
    </div>
  </div>

  <!-- Modal (mobile fixed) -->
  <div class="modal-backdrop" id="modalBackdrop"></div>
  <div class="modal" id="editProfileModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <button class="modal-close" id="closeModal">×</button>
        <div class="modal-header"><h2>Edit Profile</h2></div>

        <form method="POST" action="{{ route('super-admin.profile.update') }}">
          @csrf @method('PUT')

          <div class="form-row">
            <div class="form-group">
              <label>First Name</label>
                <input type="text" name="first_name" id="editFirstName" value="{{ $admin?->first_name }}" required placeholder="Enter first name" />
                <div id="editFirstNameError" style="color:#d32f2f; font-size:0.95rem; margin-top:4px; display:none;">No numbers or symbols allowed.</div>
            </div>
            <div class="form-group">
              <label>Last Name</label>
                <input type="text" name="last_name" id="editLastName" value="{{ $admin?->last_name }}" required placeholder="Enter last name" />
                <div id="editLastNameError" style="color:#d32f2f; font-size:0.95rem; margin-top:4px; display:none;">No numbers or symbols allowed.</div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Username</label>
              <input type="text" name="username" value="{{ $admin?->username }}" required />
            </div>
            <div class="form-group">
              <label>Email</label>
                <input type="email" name="email" id="editEmail" value="{{ $admin?->email }}" required placeholder="Email" />
                <div id="editEmailError" style="color:#d32f2f; font-size:0.95rem; margin-top:4px; display:none;">Email must be @gmail.com or @plv.edu.ph.</div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>New Password <small>(leave blank to keep current)</small></label>
              <div class="input-group" style="position:relative;">
                <input type="password" name="password" id="editPassword" />
                <i class="fas fa-eye" id="toggleEditPassword" style="position:absolute;top:50%;right:12px;transform:translateY(-50%);cursor:pointer;color:#888;"></i>
              </div>
            </div>
            <div class="form-group">
              <label>Confirm Password</label>
                <div class="input-group" style="position:relative;">
                  <input type="password" name="password_confirmation" id="editConfirmPassword" placeholder="Confirm password" />
                  <i class="fas fa-eye" id="toggleEditConfirmPassword" style="position:absolute;top:50%;right:12px;transform:translateY(-50%);cursor:pointer;color:#888;"></i>
                </div>
                <div id="editPasswordMatchMessage" style="color:#d32f2f; font-size:0.95rem; margin-top:4px; display:none;"></div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="cancelModal">Cancel</button>
            <button type="submit" class="btn btn-success" id="editProfileSaveBtn" style="transition:opacity 0.2s, background 0.2s;">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
        // Eye button for password fields
        document.getElementById('toggleEditPassword').addEventListener('click', function() {
          const passwordInput = document.getElementById('editPassword');
          const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
          passwordInput.setAttribute('type', type);
          this.classList.toggle('fa-eye');
          this.classList.toggle('fa-eye-slash');
        });
        document.getElementById('toggleEditConfirmPassword').addEventListener('click', function() {
          const confirmPasswordInput = document.getElementById('editConfirmPassword');
          const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
          confirmPasswordInput.setAttribute('type', type);
          this.classList.toggle('fa-eye');
          this.classList.toggle('fa-eye-slash');
        });
    // Mobile menu
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

    // Modal
    const modal = document.getElementById('editProfileModal');
    const backdrop = document.getElementById('modalBackdrop');
    function openModal() { modal.classList.add('show'); backdrop.classList.add('show'); document.body.style.overflow='hidden'; }
    function closeModal() { modal.classList.remove('show'); backdrop.classList.remove('show'); document.body.style.overflow=''; }
    document.getElementById('openEditProfile').onclick = openModal;
    document.getElementById('closeModal').onclick = closeModal;
    document.getElementById('cancelModal').onclick = closeModal;
    backdrop.onclick = closeModal;
    document.addEventListener('keydown', e => { if(e.key==='Escape' && modal.classList.contains('show')) closeModal(); });

    // Name field validation (no numbers/symbols)
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
    validateNameField('editFirstName', 'editFirstNameError');
    validateNameField('editLastName', 'editLastNameError');

    // Email validation for gmail and plv.edu.ph only
    const emailInput = document.getElementById('editEmail');
    const emailError = document.getElementById('editEmailError');
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
    const passwordInput = document.querySelector('input[name="password"]');
    const confirmPasswordInput = document.getElementById('editConfirmPassword');
    const passwordMatchMessage = document.getElementById('editPasswordMatchMessage');
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

    // Disable Save Changes button if any error is present
    function hasEditProfileErrors() {
      return (
        document.getElementById('editFirstNameError').style.display === 'block' ||
        document.getElementById('editLastNameError').style.display === 'block' ||
        document.getElementById('editEmailError').style.display === 'block' ||
        document.getElementById('editPasswordMatchMessage').style.display === 'block'
      );
    }
    const editProfileSaveBtn = document.getElementById('editProfileSaveBtn');
    function updateEditProfileBtnState() {
      const hasError = hasEditProfileErrors();
      editProfileSaveBtn.disabled = hasError;
      if (hasError) {
        editProfileSaveBtn.style.background = '#bbb';
        editProfileSaveBtn.style.opacity = '0.6';
        editProfileSaveBtn.style.cursor = 'not-allowed';
      } else {
        editProfileSaveBtn.style.background = '';
        editProfileSaveBtn.style.opacity = '1';
        editProfileSaveBtn.style.cursor = '';
      }
    }
    ['editFirstName','editLastName','editEmail','password','editConfirmPassword'].forEach(id => {
      const el = document.getElementById(id);
      if (el) el.addEventListener('input', updateEditProfileBtnState);
    });
    setInterval(updateEditProfileBtnState, 200);
  </script>
</body>
</html>