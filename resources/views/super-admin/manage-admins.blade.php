<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PLV - SHIELD | Admin Accounts</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root {
      --header-height: 90px;
      --sidebar-width: 240px;
      --primary: #000066;
      --accent: #FFD700;
      --danger: #dc3545;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', Arial, sans-serif;
      background: #fff8dc;
      min-height: 100vh;
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

    /* HAMBURGER */
    .hamburger {
      position: fixed;
      top: 20px;
      left: 16px;
      z-index: 3000;
      background: #191970;
      border: none;
      width: 52px;
      height: 52px;
      border-radius: 50%;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(0,0,0,0.4);
      display: none;
      align-items: center;
      justify-content: center;
    }
    /* CONTENT */
    .content-area {
      margin-left: var(--sidebar-width);
      margin-top: var(--header-height);
      padding: 30px 20px;
      min-height: calc(100vh - var(--header-height));
    }
    .card {
      background: white;
      border-radius: 18px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.12);
      padding: 30px;
      max-width: 1400px;
      margin: 0 auto;
    }
    .delete-form { display: inline; }

    .button {
      background: var(--danger);
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
    }

    .admin-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      flex-wrap: wrap;
      gap: 15px;
    }
    .admin-header h2 {
      font-size: 28px;
      color: #191970;
    }
    .create-account-btn {
      background: var(--accent);
      color: black;
      border: none;
      padding: 14px 32px;
      border-radius: 30px;
      font-weight: bold;
      cursor: pointer;
    }

    /* TABLE - DESKTOP */
    .desktop-table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    }
    .desktop-table th {
      background: var(--primary);
      color: var(--accent);
      padding: 18px;
      text-align: left;
    }
    .desktop-table td {
      padding: 18px;
      border-bottom: 1px solid #eee;
    }
    .desktop-table tr:hover { background: #f8f9fa; }

    /* MOBILE CARDS */
    .mobile-cards { display: none; }
    .admin-card {
      background: white;
      border-radius: 14px;
      padding: 20px;
      margin-bottom: 16px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      border-left: 5px solid var(--primary);
    }
    .admin-card strong { color: #191970; }
    .delete-form { display: inline; }

    .delete-btn {
      background: var(--danger);
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
    }

    /* RESPONSIVE */
    @media (max-width: 992px) {
      .hamburger { display: flex !important; }
      .sidebar { display: none !important; }
      header { padding-left: 80px !important; }
      .content-area { margin-left: 0 !important; padding: 25px 15px !important; }
      .card { padding: 25px 20px; border-radius: 16px; }

      .admin-header { flex-direction: column; text-align: center; }
      .create-account-btn { width: 100%; max-width: 300px; }

      .desktop-table { display: none; }
      .mobile-cards { display: block; }
    }

    @media (max-width: 480px) {
      header h1 { font-size: 21px; }
      .logo { height: 48px; }
      .card { padding: 20px 15px; }
      .admin-header h2 { font-size: 24px; }
    }
    /* ────────────────────── MODAL STYLES (ADD/REPLACE THIS) ────────────────────── */
.modal {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.75);
  backdrop-filter: blur(8px);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
  z-index: 3000;
  opacity: 0;
  visibility: hidden;
  transition: all 0.35s ease;
  overflow-y: auto;
}

.modal.active {
  opacity: 1;
  visibility: visible;
}

.modal-content {
  background: white;
  border-radius: 20px;
  padding: 35px;
  width: 100%;
  max-width: 560px;
  box-shadow: 0 25px 70px rgba(0, 0, 0, 0.3);
  position: relative;
  animation: modalPop 0.4s cubic-bezier(0.2, 0.8, 0.3, 1);
}

@keyframes modalPop {
  from { opacity: 0; transform: scale(0.92) translateY(40px); }
  to { opacity: 1; transform: scale(1); }
}

.modal h2 {
  color: #191970;
  font-size: 28px;
  text-align: center;
  margin-bottom: 28px;
  font-weight: 700;
}

.form-row {
  display: flex;
  gap: 18px;
  margin-bottom: 20px;
}

.form-group {
  flex: 1;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
  font-weight: 600;
  color: #333;
}

.form-group input {
  width: 100%;
  padding: 14px 16px;
  border: 2px solid #ddd;
  border-radius: 12px;
  font-size: 15px;
  transition: all 0.3s;
}

.form-group input:focus {
  outline: none;
  border-color: #8000FF;
  box-shadow: 0 0 0 4px rgba(128, 0, 255, 0.15);
}

.form-actions {
  display: flex;
  gap: 15px;
  justify-content: flex-end;
  margin-top: 30px;
}

.btn-cancel,
.btn-create {
  padding: 14px 32px;
  border: none;
  border-radius: 12px;
  font-weight: bold;
  cursor: pointer;
  transition: all 0.3s;
  font-size: 15px;
}

.btn-cancel {
  background: #6b7280;
  color: white;
}

.btn-create {
  background: #16a34a;
  color: white;
}

.btn-cancel:hover { background: #555; }
.btn-create:hover { background: #138843; transform: translateY(-2px); }

/* Mobile Form Fix */
@media (max-width: 640px) {
  .form-row {
    flex-direction: column;
    gap: 16px;
  }
  .form-actions {
    flex-direction: column;
  }
  .btn-cancel,
  .btn-create {
    width: 100%;
  }
  .modal-content {
    padding: 30px 20px;
    border-radius: 16px;
  }
}
  </style>
</head>
<body>

  <!-- Hamburger -->
  <button class="hamburger" id="hamburgerBtn">
    <svg width="30" height="30" viewBox="0 0 100 100">
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
      <li><a href="{{ route('super-admin.dashboard') }}" class="menu-link">
        <img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon"> Profile
      </a></li>
      <li class="active"><a href="{{ route('super-admin.manage-admins') }}" class="menu-link">
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
      <li><a href="{{ route('super-admin.dashboard') }}" class="menu-link">
        <img src="{{ asset('ASSETS/profile-icon.png') }}" class="icon"> Profile
      </a></li>
      <li class="active"><a href="{{ route('super-admin.manage-admins') }}" class="menu-link">
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
    <div class="card">
      <div class="admin-header">
        <h2>Admin Accounts</h2>
        <button class="create-account-btn" id="openCreate">Create Account</button>
      </div>
      @if(session('success'))
        <div style="background:#d4ade80;color:#166534;padding:16px;border-radius:12px;margin-bottom:25px;">
          {{ session('success') }}
        </div>
      @endif

      @if($errors->any())
        <div style="background:#ffebee;color:#c62828;padding:12px;border-radius:8px;margin-bottom:20px;">
          <ul style="list-style:none;margin:0;padding:0;">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Desktop Table -->
      <table class="desktop-table">
        <thead>
          <tr>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Date Created</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($admins as $a)
            <tr>
              <td>{{ $a->last_name }}</td>
              <td>{{ $a->first_name }}</td>
              <td>{{ $a->username }}</td>
              <td>{{ $a->email }}</td>
              <td>{{ optional($a->created_at)->format('M d, Y') }}</td>
              <td>
                @if(strtolower($a->admin_type ?? '') !== 'superadmin')
                  <form method="POST" action="{{ route('super-admin.manage-admins.destroy', $a->admin_id) }}" class="delete-form" onsubmit="return confirm('Delete this admin?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="delete-btn">Delete</button>
                  </form>
                @else
                  <span style="color:#666;font-size:0.95rem;">Protected</span>
                @endif
              </td>
            </tr>
          @empty
            <tr><td colspan="6" style="text-align:center;padding:50px;color:#666;">No admin accounts found.</td></tr>
          @endforelse
        </tbody>
      </table>

      <!-- Mobile Cards -->
      <div class="mobile-cards">
        @forelse($admins as $a)
          <div class="admin-card">
            <p><strong>Last Name:</strong> {{ $a->last_name }}</p>
            <p><strong>First Name:</strong> {{ $a->first_name }}</p>
            <p><strong>Username:</strong> {{ $a->username }}</p>
            <p><strong>Email:</strong> {{ $a->email }}</p>
            <p><strong>Date Created:</strong> {{ optional($a->created_at)->format('M d, Y') }}</p>
            <form method="POST" action="{{ route('super-admin.manage-admins.destroy', $a->admin_id) }}" style="margin-top:12px;" onsubmit="return confirm('Delete this admin?');">
              @csrf @method('DELETE')
              <button type="submit" class="delete-btn">Delete</button>
            </form>
          </div>
        @empty
          <p style="text-align:center;padding:40px;color:#666;font-style:italic;">No admin accounts found.</p>
        @endforelse
      </div>
    </div>
  </div>

  <!-- Create Account Modal -->
<div class="modal" id="createAccountModal">
  <div class="modal-content">
    <h2>Create Admin Account</h2>
    <form method="POST" action="{{ route('super-admin.manage-admins.store') }}">
      @csrf
      <div class="form-row">
        <div class="form-group">
          <label>First Name</label>
          <input id="createFirstName" name="first_name" type="text" required placeholder="Enter first name">
          <div id="createFirstNameError" style="color:#d32f2f; font-size:0.95rem; margin-top:6px; display:none;">No numbers or symbols allowed.</div>
        </div>
        <div class="form-group">
          <label>Last Name</label>
          <input id="createLastName" name="last_name" type="text" required placeholder="Enter last name">
          <div id="createLastNameError" style="color:#d32f2f; font-size:0.95rem; margin-top:6px; display:none;">No numbers or symbols allowed.</div>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Username</label>
          <input id="createUsername" name="username" type="text" required placeholder="Choose a username">
          <div id="createUsernameExistsError" style="color:#d32f2f; font-size:0.95rem; margin-top:6px; display:none;">Username already exists.</div>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input id="createEmail" name="email" type="email" required placeholder="Email">
          <div id="createEmailFormatError" style="color:#d32f2f; font-size:0.95rem; margin-top:6px; display:none;">Email must be @gmail.com or @plv.edu.ph.</div>
          <div id="createEmailExistsError" style="color:#d32f2f; font-size:0.95rem; margin-top:6px; display:none;">Email is already used by another admin.</div>
        </div>
      </div>

      <!-- Passwords are generated and emailed automatically. No password inputs here. -->

      <div class="form-actions">
        <button type="button" class="btn-cancel" id="cancelCreate">Cancel</button>
        <button type="submit" class="btn-create" id="createAccountBtn">Create Account</button>
      </div>
    </form>
  </div>
</div>

  <script>
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

// MODAL - PERFECT ON MOBILE & DESKTOP
  const modal = document.getElementById('createAccountModal');
  const openBtn = document.getElementById('openCreate');
  const cancelBtn = document.getElementById('cancelCreate');

  openBtn.onclick = () => {
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
  };

  cancelBtn.onclick = () => {
    modal.classList.remove('active');
    document.body.style.overflow = '';
  };

  // Close when clicking backdrop
  modal.onclick = (e) => {
    if (e.target === modal) {
      modal.classList.remove('active');
      document.body.style.overflow = '';
    }
  };

  // Close with Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modal.classList.contains('active')) {
      modal.classList.remove('active');
      document.body.style.overflow = '';
    }
  });
  // If validation errors occurred, open the create modal so user can see messages
  @if($errors->any())
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
  @endif
  // --- Validation and UI for Create Account Modal ---
  // Name field validation (no numbers/symbols)
  function validateCreateNameField(inputId, errorId) {
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
      updateCreateBtnState();
    });
  }
  validateCreateNameField('createFirstName', 'createFirstNameError');
  validateCreateNameField('createLastName', 'createLastNameError');

  // Email validation for gmail and plv.edu.ph only + availability check
  const createEmailInput = document.getElementById('createEmail');
  const createEmailFormatError = document.getElementById('createEmailFormatError');
  const createEmailExistsError = document.getElementById('createEmailExistsError');
  const createUsernameExistsError = document.getElementById('createUsernameExistsError');

  function debounce(fn, delay){
    let t;
    return function(...args){ clearTimeout(t); t = setTimeout(()=>fn.apply(this,args), delay); }
  }

  const checkEmailAvailability = debounce(function(value){
    if (!value) { createEmailExistsError.style.display = 'none'; updateCreateBtnState(); return; }
    fetch('{{ route('super-admin.manage-admins.checkEmail') }}?email=' + encodeURIComponent(value))
      .then(r => r.json())
      .then(data => {
        if (data.exists) createEmailExistsError.style.display = 'block'; else createEmailExistsError.style.display = 'none';
        updateCreateBtnState();
      }).catch(()=>{});
  }, 350);

  if (createEmailInput) {
    createEmailInput.addEventListener('input', function() {
      const value = createEmailInput.value.trim();
      const gmailRegex = /^[A-Za-z0-9._%+-]+@gmail\.com$/;
      const plvRegex = /^[A-Za-z0-9._%+-]+@plv\.edu\.ph$/;
      if (value.length === 0 || gmailRegex.test(value) || plvRegex.test(value)) {
        createEmailFormatError.style.display = 'none';
        // only check availability when format OK and has characters
        if (value.length) checkEmailAvailability(value);
      } else {
        createEmailFormatError.style.display = 'block';
        createEmailExistsError.style.display = 'none';
      }
      updateCreateBtnState();
    });
  }

  // Username availability check
  const createUsernameInput = document.getElementById('createUsername');
  const checkUsernameAvailability = debounce(function(value){
    if (!value) { createUsernameExistsError.style.display = 'none'; updateCreateBtnState(); return; }
    fetch('{{ route('super-admin.manage-admins.checkUsername') }}?username=' + encodeURIComponent(value))
      .then(r => r.json())
      .then(data => {
        if (data.exists) createUsernameExistsError.style.display = 'block'; else createUsernameExistsError.style.display = 'none';
        updateCreateBtnState();
      }).catch(()=>{});
  }, 350);
  if (createUsernameInput) {
    createUsernameInput.addEventListener('input', function(){ checkUsernameAvailability(this.value.trim()); });
  }

  // No password inputs — passwords are created server-side and emailed to the admin.

  // Disable Create Account button when errors exist
  function hasCreateErrors() {
    return (
      (document.getElementById('createFirstNameError') && document.getElementById('createFirstNameError').style.display === 'block') ||
      (document.getElementById('createLastNameError') && document.getElementById('createLastNameError').style.display === 'block') ||
      (document.getElementById('createEmailFormatError') && document.getElementById('createEmailFormatError').style.display === 'block') ||
      (document.getElementById('createEmailExistsError') && document.getElementById('createEmailExistsError').style.display === 'block') ||
      (document.getElementById('createUsernameExistsError') && document.getElementById('createUsernameExistsError').style.display === 'block')
    );
  }
  const createBtn = document.getElementById('createAccountBtn');
  function updateCreateBtnState() {
    if (!createBtn) return;
    const err = hasCreateErrors();
    createBtn.disabled = err;
    if (err) {
      createBtn.style.background = '#999';
      createBtn.style.opacity = '0.6';
      createBtn.style.cursor = 'not-allowed';
    } else {
      createBtn.style.background = '';
      createBtn.style.opacity = '1';
      createBtn.style.cursor = '';
    }
  }
  // wire inputs to update state
  ['createFirstName','createLastName','createEmail'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.addEventListener('input', updateCreateBtnState);
  });
  setInterval(updateCreateBtnState, 200);
  </script>
</body>
</html>