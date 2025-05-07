<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login and Register to Resortsphere</title>
  <link rel="icon" href="{{ asset('images/Logo.png') }}" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #1E1E1E;
      background-size: 400% 400%;
      animation: backgroundAnimation 20s ease infinite;
    }

    .auth-container {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .auth-card {
      display: flex;
      border-radius: 20px;
      overflow: hidden;
      width: 900px;
      max-width: 100%;
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.3);
      background-color: #fff;
    }

    .auth-image {
      width: 50%;
      background: url('/images/login.png') center/cover no-repeat;
    }

    .auth-form {
      width: 50%;
      padding: 40px;
      position: relative;
    }

    .form-wrapper {
      display: none;
      transform: translateX(100%);
      transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out;
      opacity: 0;
      position: absolute;
      width: 100%;
    }

    .form-wrapper.active {
      display: block;
      transform: translateX(0);
      opacity: 1;
      position: relative;
    }

    .toggle-btn {
      background: none;
      border: none;
      color: #0d6efd;
      text-decoration: underline;
      cursor: pointer;
      font-size: 0.9rem;
      margin-top: 10px;
    }

    .form-control {
      border-radius: 10px;
    }

    .btn-primary {
      border-radius: 10px;
    }

    .eye-icon {
      position: absolute;
      top: 50%;
      right: 15px;
      transform: translateY(-50%);
      cursor: pointer;
      color: #6c757d;
    }

    .helper-text-sm {
      font-size: 0.75rem;
    }

    .modal-body {
      max-height: 400px;
      overflow-y: auto;
    }

    /* Custom Checkbox Styling */
    .form-check-input {
      width: 1.25em;
      height: 1.25em;
      border-radius: 4px;
      border: 2px solid #ddd;
      background-color: #fff;
      appearance: none;
      cursor: pointer;
    }

    .form-check-input:checked {
      background-color: #007bff;
      border-color: #007bff;
    }

    .form-check-input:focus {
      outline: none;
      box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
    }

    .form-check-label {
      font-size: 1rem;
      margin-left: 0.5em;
    }

    #passwordError,
    #confirmPasswordError {
      min-height: 1em; /* or more, depending on how tall your messages get */
    }
  </style>
</head>
<body>
  <div class="auth-container">
    <div class="auth-card">
      <div class="auth-image"></div>
      <div class="auth-form">

        <!-- Register Form -->
        <div id="registerForm" class="form-wrapper">
            <h4 class="mb-4 text-center">Create an Account</h4>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Enter username" value="{{ old('username') }}">
                    @error('username') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Firstname</label>
                    <input type="text" name="firstname" class="form-control" placeholder="Enter firstname" value="{{ old('firstname') }}" required>
                    @error('firstname') <div class="text-danger small">{{ $message }}</div> @enderror
                  </div>
                  
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Lastname</label>
                    <input type="text" name="lastname" class="form-control" placeholder="Enter lastname" value="{{ old('lastname') }}" required>
                    @error('lastname') <div class="text-danger small">{{ $message }}</div> @enderror
                  </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="example@gmail.com" value="{{ old('email') }}" pattern="^[a-zA-Z0-9._%+-]+@gmail\.com$" required>
                    @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="position-relative">
                        <input type="password" name="password" class="form-control pe-5" placeholder="Enter at least 8 characters." id="password" required>
                        <span class="eye-icon" onclick="togglePasswordVisibility('password')">
                            <i class="bi bi-eye" id="password-eye"></i>
                        </span>
                    </div>
                    <div id="passwordError" class="text-danger small"></div>
                    @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter password" id="confirmPassword" required>
                    <small class="text-muted" id="passwordMatch"></small>
                    <div id="confirmPasswordError" class="text-danger small"></div>
                </div>

                <div class="form-check mt-3 mb-3">
                  <input class="form-check-input" type="checkbox" id="termsCheckbox">
                  <label class="form-check-label" for="termsCheckbox">
                    I agree to the <a href="#" id="termsLink">Terms and Conditions</a>
                  </label>
                </div>

                <button type="submit" class="btn btn-primary w-100" id="registerBtn">
                  <span id="registerText">Register</span>
                  <span id="registerSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
                <div class="text-center">
                    <button type="button" class="toggle-btn" onclick="toggleForms()">Already have an account? Login</button>
                </div>
            </form>
        </div>

      <!-- Login Form -->
      <div id="loginForm" class="form-wrapper active">
        <h4 class="mb-4 text-center">Login</h4>
        
        @if(session('error'))
          <div class="alert alert-danger text-center">
            {{ session('error') }}
          </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
          @csrf

          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Enter username" value="{{ old('username') }}">
            @error('username') 
              <div class="text-danger small">{{ $message }}</div> 
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="position-relative">
              <input type="password" name="password" class="form-control pe-5" id="loginPassword" value="{{ old('password') }}">
              <span class="eye-icon" onclick="togglePasswordVisibility('loginPassword')">
                <i class="bi bi-eye" id="loginPassword-eye"></i>
              </span>
            </div>
            @error('password') 
              <div class="text-danger small">{{ $message }}</div> 
            @enderror
          </div>

          <button type="submit" class="btn btn-primary w-100">Login</button>

          <div class="text-center">
            <button type="button" class="toggle-btn" onclick="toggleForms()">Don’t have an account? Register</button>
          </div>
        </form>
      </div>
      </div>
    </div>
  </div>

  <!-- Terms and Conditions Modal -->
  <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <p class="mb-3">Please read our terms and conditions carefully before registering:</p>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla in nisl eu enim imperdiet vulputate. Morbi in nunc vitae turpis egestas mattis.</p>
          <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Etiam tincidunt sem in diam tincidunt, sed lobortis ligula hendrerit.</p>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

    <script>
        if (window.history.replaceState) {
          window.history.replaceState(null, null, window.location.href);
        }
        window.addEventListener('pageshow', function(event) {
            if (event.persisted || window.performance && window.performance.navigation.type === 2) {
                window.location.reload();
            }
        });
        // Optional email validation (for Gmail only)
        const emailInput = document.querySelector('input[name="email"]');
        emailInput.addEventListener('blur', function () {
          const emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
          if (!emailPattern.test(emailInput.value)) {
            emailInput.setCustomValidity("Please enter a valid Gmail address.");
            emailInput.reportValidity();
          } else {
            emailInput.setCustomValidity("");
          }
        });

        document.addEventListener('DOMContentLoaded', function () {
          const termsCheckbox = document.getElementById('termsCheckbox');
          const registerBtn = document.getElementById('registerBtn');
          const termsLink = document.getElementById('termsLink');
          const agreeBtn = document.getElementById('agreeBtn');
          const disagreeBtn = document.getElementById('disagreeBtn');
          const termsModal = new bootstrap.Modal(document.getElementById('termsModal'));

          // Initial state
          registerBtn.disabled = !termsCheckbox.checked;

          // Enable/disable register button on checkbox toggle
          termsCheckbox.addEventListener('change', function () {
              registerBtn.disabled = !this.checked;
          });

          // Show modal only if checkbox is NOT already checked
          termsLink.addEventListener('click', function (e) {
              e.preventDefault(); // Prevent default link behavior
              if (!termsCheckbox.checked) {
                  termsModal.show();
              }
          });

          // Agree action
          agreeBtn.addEventListener('click', function () {
              termsCheckbox.checked = true;
              registerBtn.disabled = false;
              termsModal.hide();
          });

          // Disagree action
          disagreeBtn.addEventListener('click', function () {
              termsCheckbox.checked = false;
              registerBtn.disabled = true;
              termsModal.hide();
          });
      });

          const passwordInput = document.getElementById('password');
          const confirmPasswordInput = document.getElementById('confirmPassword');
          const passwordError = document.getElementById('passwordError');
          const confirmPasswordError = document.getElementById('confirmPasswordError');

          passwordInput.addEventListener('blur', function () {
            const password = passwordInput.value.trim();
            const passwordStrengthPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?`~])[A-Za-z\d!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?`~]{8,}$/;
            if (password === '') {
              passwordError.textContent = 'Password is required.';
            } else if (!passwordStrengthPattern.test(password)) {
              passwordError.textContent = 'Password must be at least 8 characters, with an uppercase letter, a number, and a special character.';
            } else {
              passwordError.textContent = '';
            }
          });

          confirmPasswordInput.addEventListener('blur', function () {
            if (confirmPasswordInput.value.trim() === '') {
              confirmPasswordError.textContent = 'Please confirm your password.';
            } else if (passwordInput.value !== confirmPasswordInput.value) {
              confirmPasswordError.textContent = 'Passwords do not match.';
            } else {
              confirmPasswordError.textContent = '';
            }
          });

        function togglePasswordVisibility(id) {
          const input = document.getElementById(id);
          const icon = document.getElementById(`${id}-eye`);

          if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
          } else {
            input.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
          }
        }

        function toggleForms() {
          const registerForm = document.getElementById('registerForm');
          const loginForm = document.getElementById('loginForm');
          const isRegisterFormActive = registerForm.classList.contains('active');
          
          function toggleForms() {
            const registerForm = document.getElementById('registerForm');
            const loginForm = document.getElementById('loginForm');
            const isRegisterFormActive = registerForm.classList.contains('active');

            if (!isRegisterFormActive) {
              registerForm.classList.toggle('active');
              loginForm.classList.toggle('active');
            } else {
              
            }
          }

          function validateLogin() {
          const username = document.getElementById('username').value.trim();
          const password = document.getElementById('password').value.trim();
          const passwordStrengthPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

          if (username === '' || password === '') {
            alert('Please enter both username and password.');
            console.log("Username:", username);
            console.log("Password:", password);
            return false;  
          }
          if (username === 'Admin' && password === 'Admin246') {
            alert('Admin logged in successfully!');
            console.log("Username:", username);
            console.log("Password:", password);
            window.location.href = '/welcome';  
            return false;  
          }

          if (!passwordStrengthPattern.test(password)) {
            alert('Please enter a valid password. Ensure it meets the required strength.');
            console.log("Username:", username);
            console.log("Password:", password);
            return false;  
          }
          return true;  
        }
          registerForm.classList.toggle('active');
          loginForm.classList.toggle('active');
        }
        @if(session('success'))
              document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                  icon: 'success',
                  title: 'Registered Successfully!',
                  text: '{{ session("success") }}',
                  confirmButtonColor: '#0d6efd'
                });
              });
          @endif

          document.addEventListener('DOMContentLoaded', function() {
            const registerForm = document.querySelector('#registerForm form');
            const registerBtn = document.getElementById('registerBtn');
            const registerText = document.getElementById('registerText');
            const registerSpinner = document.getElementById('registerSpinner');
            
            if (registerForm) {
              registerForm.addEventListener('submit', function(e) {
                // Check terms checkbox again (in case user unchecked during submission)
                const termsCheckbox = document.getElementById('termsCheckbox');
                if (!termsCheckbox.checked) {
                  e.preventDefault();
                  return;
                }
                
                // Set loading state
                registerBtn.disabled = true;
                registerText.textContent = 'Registering...';
                registerSpinner.classList.remove('d-none');
              });
            }
            
            // Reset button state if form validation fails
            window.addEventListener('pageshow', function() {
              if (registerBtn) {
                registerBtn.disabled = !document.getElementById('termsCheckbox').checked;
                registerText.textContent = 'Register';
                registerSpinner.classList.add('d-none');
              }
            });
          });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
