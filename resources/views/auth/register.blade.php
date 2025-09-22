<x-guest-layout>
    <div class="auth-container">
        <div class="auth-background"></div>
        
        <div class="container-fluid min-vh-100">
            <div class="row min-vh-100">
                <!-- Left Side - Registration Form -->
                <div class="col-lg-6 auth-form-section">
                    <div class="auth-form-container">
                        <div class="auth-header">
                            <div class="auth-logo d-lg-none">
                                <i class="bi bi-shop"></i>
                                <span>Sweet Delights</span>
                            </div>
                            <h2 class="auth-title">Join Sweet Delights</h2>
                            <p class="auth-subtitle">Create your account and start your sweet journey with us</p>
                        </div>

                        <div class="auth-card">
                            <form method="POST" action="{{ route('register') }}" id="registerForm" class="auth-form">
                                @csrf

                                <!-- Name -->
                                <div class="form-group">
                                    <label for="name" class="form-label">
                                        <i class="bi bi-person me-2"></i>Full Name
                                    </label>
                                    <div class="input-wrapper">
                                        <input id="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               type="text"
                                               name="name"
                                               value="{{ old('name') }}"
                                               required
                                               autofocus
                                               autocomplete="name"
                                               placeholder="Enter your full name">
                                        <div class="input-icon">
                                            <i class="bi bi-person"></i>
                                        </div>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email Address -->
                                <div class="form-group">
                                    <label for="email" class="form-label">
                                        <i class="bi bi-envelope me-2"></i>Email Address
                                    </label>
                                    <div class="input-wrapper">
                                        <input id="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               type="email"
                                               name="email"
                                               value="{{ old('email') }}"
                                               required
                                               autocomplete="username"
                                               placeholder="Enter your email address">
                                        <div class="input-icon">
                                            <i class="bi bi-envelope"></i>
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback">
                                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <label for="password" class="form-label">
                                        <i class="bi bi-lock me-2"></i>Password
                                    </label>
                                    <div class="input-wrapper">
                                        <input id="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               type="password"
                                               name="password"
                                               required
                                               autocomplete="new-password"
                                               placeholder="Create a strong password">
                                        <div class="input-icon">
                                            <i class="bi bi-lock"></i>
                                        </div>
                                        <button type="button" class="password-toggle" id="togglePassword">
                                            <i class="bi bi-eye" id="passwordIcon"></i>
                                        </button>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="password-strength" id="passwordStrength">
                                        <div class="strength-bar">
                                            <div class="strength-fill" id="strengthFill"></div>
                                        </div>
                                        <small class="strength-text" id="strengthText">Password strength</small>
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label">
                                        <i class="bi bi-lock-fill me-2"></i>Confirm Password
                                    </label>
                                    <div class="input-wrapper">
                                        <input id="password_confirmation"
                                               class="form-control @error('password_confirmation') is-invalid @enderror"
                                               type="password"
                                               name="password_confirmation"
                                               required
                                               autocomplete="new-password"
                                               placeholder="Confirm your password">
                                        <div class="input-icon">
                                            <i class="bi bi-lock-fill"></i>
                                        </div>
                                        <button type="button" class="password-toggle" id="toggleConfirmPassword">
                                            <i class="bi bi-eye" id="confirmPasswordIcon"></i>
                                        </button>
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">
                                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Terms and Privacy -->
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                                        <label class="form-check-label" for="agreeTerms">
                                            I agree to the
                                            <a href="#" class="auth-link">Terms of Service</a>
                                            and
                                            <a href="#" class="auth-link">Privacy Policy</a>
                                        </label>
                                    </div>
                                </div>

                                <!-- Newsletter Subscription -->
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter" checked>
                                        <label class="form-check-label" for="newsletter">
                                            <i class="bi bi-envelope-heart me-1"></i>
                                            Subscribe to our newsletter for baking tips and exclusive offers
                                        </label>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn-auth" id="registerBtn">
                                    <span class="btn-content">
                                        <i class="bi bi-person-plus me-2"></i>
                                        Create Account
                                    </span>
                                    <span class="btn-loading">
                                        <span class="spinner"></span>
                                        Creating Account...
                                    </span>
                                </button>

                                <!-- Divider -->
                                <div class="auth-divider">
                                    <span>Or register with</span>
                                </div>

                                <!-- Social Registration -->
                                <div class="social-login">
                                    <button type="button" class="social-btn google-btn">
                                        <i class="bi bi-google"></i>
                                        <span>Google</span>
                                    </button>
                                    <button type="button" class="social-btn facebook-btn">
                                        <i class="bi bi-facebook"></i>
                                        <span>Facebook</span>
                                    </button>
                                </div>

                                <!-- Login Link -->
                                <div class="auth-footer">
                                    <p>Already have an account?
                                        <a href="{{ route('login') }}" class="auth-link">
                                            Sign in here
                                        </a>
                                    </p>
                                </div>
                            </form>
                        </div>

                        <!-- Security Info -->
                        <div class="security-info">
                            <i class="bi bi-shield-check me-2"></i>
                            Your data is protected with enterprise-grade security
                        </div>
                    </div>
                </div>

                <!-- Right Side - Hero Content -->
                <div class="col-lg-6 d-none d-lg-flex auth-hero">
                    <div class="hero-content">
                        <div class="hero-animation mb-5">
                            <div class="floating-elements">
                                <div class="floating-item item-1">
                                    <i class="bi bi-gift-fill"></i>
                                </div>
                                <div class="floating-item item-2">
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <div class="floating-item item-3">
                                    <i class="bi bi-heart-fill"></i>
                                </div>
                            </div>
                            <div class="main-icon">
                                <i class="bi bi-cake2"></i>
                            </div>
                        </div>
                        
                        <h1 class="hero-title">Welcome to Our Bakery Family</h1>
                        <p class="hero-subtitle">Join thousands of pastry lovers who have made Sweet Delights their daily ritual</p>
                        
                        <div class="benefits-grid">
                            <div class="benefit-item">
                                <div class="benefit-icon">
                                    <i class="bi bi-gift-fill"></i>
                                </div>
                                <div class="benefit-content">
                                    <h6>Welcome Bonus</h6>
                                    <small>Free pastry on your first order</small>
                                </div>
                            </div>
                            <div class="benefit-item">
                                <div class="benefit-icon">
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <div class="benefit-content">
                                    <h6>Loyalty Rewards</h6>
                                    <small>Earn points with every purchase</small>
                                </div>
                            </div>
                            <div class="benefit-item">
                                <div class="benefit-icon">
                                    <i class="bi bi-bell-fill"></i>
                                </div>
                                <div class="benefit-content">
                                    <h6>Exclusive Offers</h6>
                                    <small>Get notified about special deals</small>
                                </div>
                            </div>
                            <div class="benefit-item">
                                <div class="benefit-icon">
                                    <i class="bi bi-calendar-check-fill"></i>
                                </div>
                                <div class="benefit-content">
                                    <h6>Easy Reservations</h6>
                                    <small>Book your table in advance</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .benefits-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .benefit-item {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .benefit-item:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-5px);
        }

        .benefit-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.5rem;
            color: #FFD700;
        }

        .benefit-content h6 {
            color: white;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .benefit-content small {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.4;
        }

        .password-strength {
            margin-top: 0.5rem;
        }

        .strength-bar {
            height: 4px;
            background: rgba(212, 165, 116, 0.2);
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak { background: #dc3545; width: 25%; }
        .strength-fair { background: #fd7e14; width: 50%; }
        .strength-good { background: #ffc107; width: 75%; }
        .strength-strong { background: #28a745; width: 100%; }

        .strength-text {
            color: #6c757d;
            font-size: 0.8rem;
        }

        /* All other styles from login.blade.php apply here as well */
        .auth-container {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
        }

        .auth-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, 
                rgba(212, 165, 116, 0.1) 0%, 
                rgba(244, 228, 193, 0.1) 50%, 
                rgba(232, 180, 184, 0.1) 100%);
            z-index: -1;
        }

        .auth-hero {
            background: linear-gradient(135deg,
                        rgba(212, 165, 116, 0.95),
                        rgba(244, 228, 193, 0.9)),
                        url('https://images.unsplash.com/photo-1517433670267-08bbd4be890f?w=1200&h=800&fit=crop') center/cover;
            position: relative;
            align-items: center;
            justify-content: center;
        }

        .auth-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.2);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
            padding: 3rem;
            max-width: 500px;
        }

        .hero-animation {
            position: relative;
            margin-bottom: 3rem;
        }

        .floating-elements {
            position: relative;
            width: 200px;
            height: 200px;
            margin: 0 auto;
        }

        .floating-item {
            position: absolute;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .item-1 {
            top: 20px;
            left: 20px;
            animation: float 3s ease-in-out infinite;
        }

        .item-2 {
            top: 20px;
            right: 20px;
            animation: float 3s ease-in-out infinite 1s;
        }

        .item-3 {
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            animation: float 3s ease-in-out infinite 2s;
        }

        .main-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, var(--bakery-primary), var(--bakery-secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            animation: pulse 2s ease-in-out infinite;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            line-height: 1.6;
        }

        .auth-form-section {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
        }

        .auth-form-container {
            width: 100%;
            max-width: 450px;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
            color: var(--bakery-primary);
            font-size: 1.5rem;
            font-weight: 700;
        }

        .auth-logo i {
            font-size: 2rem;
        }

        .auth-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--bakery-primary);
            margin-bottom: 0.5rem;
        }

        .auth-subtitle {
            color: #6c757d;
            font-size: 1rem;
            margin-bottom: 0;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 2.5rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--bakery-primary);
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.8);
            border: 2px solid rgba(212, 165, 116, 0.2);
            border-radius: 15px;
            padding: 1rem 1rem 1rem 3rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.95);
            border-color: var(--bakery-primary);
            box-shadow: 0 0 0 0.2rem rgba(212, 165, 116, 0.25);
            transform: translateY(-2px);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--bakery-primary);
            font-size: 1.1rem;
            opacity: 0.7;
            transition: all 0.3s ease;
        }

        .form-control:focus + .input-icon {
            opacity: 1;
            color: var(--bakery-primary);
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--bakery-primary);
            font-size: 1.1rem;
            cursor: pointer;
            opacity: 0.7;
            transition: all 0.3s ease;
        }

        .password-toggle:hover {
            opacity: 1;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .form-check {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            border: 2px solid var(--bakery-primary);
            border-radius: 4px;
            margin-top: 0.125rem;
            flex-shrink: 0;
        }

        .form-check-input:checked {
            background-color: var(--bakery-primary);
            border-color: var(--bakery-primary);
        }

        .form-check-label {
            color: #6c757d;
            font-size: 0.9rem;
            cursor: pointer;
            line-height: 1.4;
        }

        .btn-auth {
            width: 100%;
            background: linear-gradient(45deg, var(--bakery-primary), var(--bakery-secondary));
            border: none;
            border-radius: 15px;
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1.1rem;
            color: white;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .btn-auth::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: all 0.6s;
        }

        .btn-auth:hover::before {
            left: 100%;
        }

        .btn-auth:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(212, 165, 116, 0.4);
        }

        .btn-auth:active {
            transform: translateY(-1px);
        }

        .btn-content {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-loading {
            display: none;
            align-items: center;
            justify-content: center;
        }

        .btn-auth.loading .btn-content {
            display: none;
        }

        .btn-auth.loading .btn-loading {
            display: flex;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 0.5rem;
        }

        .auth-divider {
            position: relative;
            text-align: center;
            margin: 2rem 0;
        }

        .auth-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(212, 165, 116, 0.3), transparent);
        }

        .auth-divider span {
            background: rgba(255, 255, 255, 0.9);
            padding: 0 1.5rem;
            color: #6c757d;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .social-login {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .social-btn {
            flex: 1;
            background: rgba(255, 255, 255, 0.8);
            border: 2px solid rgba(212, 165, 116, 0.2);
            border-radius: 12px;
            padding: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .google-btn {
            color: #db4437;
        }

        .google-btn:hover {
            background: #db4437;
            color: white;
            border-color: #db4437;
            transform: translateY(-2px);
        }

        .facebook-btn {
            color: #4267B2;
        }

        .facebook-btn:hover {
            background: #4267B2;
            color: white;
            border-color: #4267B2;
            transform: translateY(-2px);
        }

        .auth-footer {
            text-align: center;
            margin-bottom: 0;
        }

        .auth-footer p {
            color: #6c757d;
            margin-bottom: 0;
        }

        .auth-link {
            color: var(--bakery-primary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .auth-link:hover {
            color: var(--bakery-secondary);
            text-decoration: underline;
        }

        .security-info {
            text-align: center;
            margin-top: 2rem;
            color: #6c757d;
            font-size: 0.85rem;
            background: rgba(255, 255, 255, 0.6);
            padding: 1rem;
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }

        .alert-modern {
            background: rgba(25, 135, 84, 0.1);
            border: 1px solid rgba(25, 135, 84, 0.2);
            border-radius: 15px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
        }

        /* Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        @keyframes pulse {
            0%, 100% { transform: translate(-50%, -50%) scale(1); }
            50% { transform: translate(-50%, -50%) scale(1.05); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive Design */
        @media (max-width: 991.98px) {
            .auth-form-section {
                background: linear-gradient(135deg, 
                    rgba(255, 255, 255, 0.95), 
                    rgba(248, 249, 250, 0.95));
            }

            .auth-card {
                margin: 1rem;
                padding: 2rem;
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-content {
                padding: 2rem;
            }

            .benefits-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }

        @media (max-width: 575.98px) {
            .auth-card {
                padding: 1.5rem;
                margin: 0.5rem;
            }

            .social-login {
                flex-direction: column;
            }

            .hero-title {
                font-size: 1.8rem;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle functionality
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');

            if (togglePassword) {
                togglePassword.addEventListener('click', function() {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    passwordIcon.classList.toggle('bi-eye');
                    passwordIcon.classList.toggle('bi-eye-slash');
                });
            }

            // Confirm password toggle
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const confirmPassword = document.getElementById('password_confirmation');
            const confirmPasswordIcon = document.getElementById('confirmPasswordIcon');

            if (toggleConfirmPassword) {
                toggleConfirmPassword.addEventListener('click', function() {
                    const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                    confirmPassword.setAttribute('type', type);
                    confirmPasswordIcon.classList.toggle('bi-eye');
                    confirmPasswordIcon.classList.toggle('bi-eye-slash');
                });
            }

            // Form submission with loading state
            const registerForm = document.getElementById('registerForm');
            const registerBtn = document.getElementById('registerBtn');

            if (registerForm) {
                registerForm.addEventListener('submit', function() {
                    registerBtn.classList.add('loading');
                    registerBtn.disabled = true;
                });
            }

            // Password strength checker
            const passwordInput = document.getElementById('password');
            if (passwordInput) {
                passwordInput.addEventListener('input', function() {
                    checkPasswordStrength(this.value);
                });
            }

            // Real-time password validation
            const confirmPasswordInput = document.getElementById('password_confirmation');

            function validatePasswords() {
                if (confirmPasswordInput && passwordInput && 
                    confirmPasswordInput.value && passwordInput.value !== confirmPasswordInput.value) {
                    confirmPasswordInput.setCustomValidity('Passwords do not match');
                    confirmPasswordInput.classList.add('is-invalid');
                } else if (confirmPasswordInput) {
                    confirmPasswordInput.setCustomValidity('');
                    confirmPasswordInput.classList.remove('is-invalid');
                }
            }

            if (passwordInput && confirmPasswordInput) {
                passwordInput.addEventListener('input', validatePasswords);
                confirmPasswordInput.addEventListener('input', validatePasswords);
            }

            // Enhanced form validation
            const form = document.getElementById('loginForm') || document.getElementById('registerForm');
            if (form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                });
            }

            // Social login handlers
            document.querySelectorAll('.social-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const platform = this.querySelector('span').textContent.trim();
                    
                    // Add loading state
                    const originalContent = this.innerHTML;
                    this.innerHTML = `<span class="spinner"></span> Connecting...`;
                    this.disabled = true;
                    
                    setTimeout(() => {
                        this.innerHTML = originalContent;
                        this.disabled = false;
                        alert(`${platform} login integration coming soon!`);
                    }, 1500);
                });
            });

            // Input focus effects
            document.querySelectorAll('.form-control').forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });
        });

        function checkPasswordStrength(password) {
            const strengthFill = document.getElementById('strengthFill');
            const strengthText = document.getElementById('strengthText');
            
            if (!password) {
                strengthFill.className = 'strength-fill';
                strengthText.textContent = 'Password strength';
                strengthText.style.color = '#6c757d';
                return;
            }

            let score = 0;
            
            // Length check
            if (password.length >= 8) score++;
            if (password.length >= 12) score++;
            
            // Character variety checks
            if (/[a-z]/.test(password)) score++;
            if (/[A-Z]/.test(password)) score++;
            if (/[0-9]/.test(password)) score++;
            if (/[^A-Za-z0-9]/.test(password)) score++;

            // Update strength indicator
            strengthFill.className = 'strength-fill';
            
            if (score < 3) {
                strengthFill.classList.add('strength-weak');
                strengthText.textContent = 'Weak password';
                strengthText.style.color = '#dc3545';
            } else if (score < 4) {
                strengthFill.classList.add('strength-fair');
                strengthText.textContent = 'Fair password';
                strengthText.style.color = '#fd7e14';
            } else if (score < 5) {
                strengthFill.classList.add('strength-good');
                strengthText.textContent = 'Good password';
                strengthText.style.color = '#ffc107';
            } else {
                strengthFill.classList.add('strength-strong');
                strengthText.textContent = 'Strong password';
                strengthText.style.color = '#28a745';
            }
        }
    </script>
    @endpush
</x-guest-layout>