<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - PLV SHIELD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/signup-style.css') }}">
</head>
<body>
    <img src="{{ asset('ASSETS/bgLanding.png') }}" alt="Background" class="background">
    
    <div class="overlay">
        <div class="content">
            <img src="{{ asset('ASSETS/shield-logo.png') }}" alt="PLV Shield Logo" class="logo">
            <h1 class="welcome">Join PLV - SHIELD</h1>
            <p class="tagline">Track, Report, Accomplish</p>
            <div class="left-section-btn">
                <p>Already have an account?</p>
                <a href="{{ route('student.login') }}" class="secondary-btn">LOG IN</a>
            </div>
        </div>
        
        <div class="right-section">
            <div class="signup-box">
                <h2>Create Account</h2>
                
                <div id="messageContainer">
                    @if ($errors->any())
                        <div class="error-message" style="background-color: #ffebee; color: #c62828; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                            <ul style="list-style: none; margin: 0; padding: 0;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                
                <form id="signupForm" action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label for="studentId">Student ID *</label>
                                <input type="text" id="studentId" name="studentId" required placeholder="2X-XXXX">
                                <div id="studentIdError" style="color:#d32f2f; font-size:0.95rem; margin-top:4px; display:none;">Invalid student ID format. Use 2x-xxxx.</div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="lastName">Last Name *</label>
                            <input type="text" id="lastName" name="lastName" required placeholder="Enter last name">
                            <div id="lastNameError" style="color:#d32f2f; font-size:0.95rem; margin-top:4px; display:none;">No numbers or symbols allowed.</div>
                        </div>
                        <div class="form-group">
                            <label for="firstName">First Name *</label>
                            <input type="text" id="firstName" name="firstName" required placeholder="Enter first name">
                            <div id="firstNameError" style="color:#d32f2f; font-size:0.95rem; margin-top:4px; display:none;">No numbers or symbols allowed.</div>
                        </div>
                    </div>
                    
                    <!-- Middle name removed because database does not store it -->
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" required placeholder="Email">
                            <div id="emailError" style="color:#d32f2f; font-size:0.95rem; margin-top:4px; display:none;">Email must be @gmail.com or @plv.edu.ph.</div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">Password *</label>
                            <div class="input-group">
                                <input type="password" id="password" name="password" required placeholder="Enter password">
                                <i class="fas fa-eye" id="togglePassword"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword">Confirm Password *</label>
                            <div class="input-group">
                                <input type="password" id="confirmPassword" name="confirmPassword" required placeholder="Confirm password">
                                <i class="fas fa-eye" id="toggleConfirmPassword"></i>
                            </div>
                            <div id="passwordMatchMessage" style="color:#d32f2f; font-size:0.95rem; margin-top:4px; display:none;"></div>
                        </div>
                    </div>
                    
                    <button type="submit" class="primary-btn" id="signupSubmitBtn">CREATE ACCOUNT</button>
                    
                    <div class="login-link">
                        Already have an account? <a href="{{ route('student.login') }}">Log In</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Password toggle functionality
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Instant password match validation
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirmPassword');
        const passwordMatchMessage = document.getElementById('passwordMatchMessage');

        function checkPasswordMatch() {
            if (confirmPasswordInput.value.length === 0) {
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

        // Student ID format validation (2x-xxxx)
        const studentIdInput = document.getElementById('studentId');
        const studentIdError = document.getElementById('studentIdError');
        studentIdInput.addEventListener('input', function() {
            // Format: 2 digits, dash, 4 digits (e.g., 23-1234)
            const value = studentIdInput.value;
            const regex = /^\d{2}-\d{4}$/;
            if (value.length === 0 || regex.test(value)) {
                studentIdError.style.display = 'none';
            } else {
                studentIdError.style.display = 'block';
            }
        });

        // Name field validation (no numbers/symbols)
        function validateNameField(inputId, errorId) {
            const input = document.getElementById(inputId);
            const error = document.getElementById(errorId);
            input.addEventListener('input', function() {
                // Only letters, spaces, hyphens, apostrophes allowed
                const value = input.value;
                const regex = /^[A-Za-z\s\-']+$/;
                if (value.length === 0 || regex.test(value)) {
                    error.style.display = 'none';
                } else {
                    error.style.display = 'block';
                }
            });
        }
        validateNameField('lastName', 'lastNameError');
        validateNameField('firstName', 'firstNameError');

        // Email validation for gmail and plv.edu.ph only
        const emailInput = document.getElementById('email');
        const emailError = document.getElementById('emailError');
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
        // Disable submit button if any error is present
        function hasSignupErrors() {
            return (
                document.getElementById('studentIdError').style.display === 'block' ||
                document.getElementById('lastNameError').style.display === 'block' ||
                document.getElementById('firstNameError').style.display === 'block' ||
                document.getElementById('emailError').style.display === 'block' ||
                document.getElementById('passwordMatchMessage').style.display === 'block'
            );
        }
        const signupBtn = document.getElementById('signupSubmitBtn');
        function updateSignupBtnState() {
            signupBtn.disabled = hasSignupErrors();
        }
        ['studentId','lastName','firstName','email','password','confirmPassword'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.addEventListener('input', updateSignupBtnState);
        });
        setInterval(updateSignupBtnState, 200);
    </script>
</body>
</html>