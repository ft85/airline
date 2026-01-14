<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I-AirSoft | Sign In</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22%233b82f6%22><path d=%22M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z%22/></svg>">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #1f2937;
        }

        .login-container {
            width: 100%;
            max-width: 440px;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .logo-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2);
        }

        .logo-text {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            letter-spacing: -0.025em;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: 1px solid #bfdbfe;
            border-radius: 9999px;
            margin-bottom: 24px;
        }

        .badge-dot {
            width: 6px;
            height: 6px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border-radius: 50%;
            margin-right: 8px;
            animation: pulse 2s infinite;
        }

        .badge-text {
            font-size: 12px;
            font-weight: 500;
            color: #1e40af;
        }

        .title {
            font-size: 32px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .subtitle {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .login-card {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            border: 1px solid #e5e7eb;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            width: 18px;
            height: 18px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px 12px 42px;
            border: 1.5px solid #d1d5db;
            border-radius: 10px;
            font-size: 14px;
            color: #111827;
            background: #f9fafb;
            transition: all 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .checkbox-input {
            display: none;
        }

        .checkbox-custom {
            width: 18px;
            height: 18px;
            border: 2px solid #d1d5db;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            transition: all 0.2s;
        }

        .checkbox-input:checked + .checkbox-custom {
            background: #3b82f6;
            border-color: #3b82f6;
        }

        .checkbox-input:checked + .checkbox-custom::after {
            content: '';
            width: 10px;
            height: 10px;
            background: white;
            border-radius: 2px;
        }

        .checkbox-label {
            font-size: 14px;
            color: #4b5563;
        }

        .forgot-link {
            font-size: 14px;
            font-weight: 500;
            color: #3b82f6;
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #2563eb;
        }

        .login-button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
        }

        .login-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 12px -2px rgba(59, 130, 246, 0.4);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .button-icon {
            width: 18px;
            height: 18px;
            margin-left: 8px;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 28px 0;
        }

        .divider-line {
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .divider-text {
            padding: 0 16px;
            font-size: 13px;
            color: #6b7280;
            font-weight: 500;
        }

        .social-login {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 12px;
        }

        .social-button {
            padding: 12px;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            background: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .social-button:hover {
            border-color: #d1d5db;
            background: #f9fafb;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .social-icon {
            width: 20px;
            height: 20px;
        }

        .signup-link {
            text-align: center;
            margin-bottom: 24px;
        }

        .signup-text {
            font-size: 14px;
            color: #6b7280;
        }

        .signup-link {
            font-weight: 600;
            color: #3b82f6;
            text-decoration: none;
            transition: color 0.2s;
        }

        .signup-link:hover {
            color: #2563eb;
        }

        .demo-card {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 1px solid #bae6fd;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
        }

        .demo-header {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }

        .demo-icon {
            width: 24px;
            height: 24px;
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }

        .demo-title {
            font-size: 14px;
            font-weight: 600;
            color: #0369a1;
        }

        .demo-credentials {
            display: grid;
            gap: 8px;
        }

        .demo-row {
            display: flex;
            align-items: center;
        }

        .demo-label {
            font-size: 13px;
            font-weight: 500;
            color: #0c4a6e;
            width: 60px;
        }

        .demo-value {
            font-family: 'SF Mono', 'Monaco', 'Inconsolata', monospace;
            font-size: 13px;
            background: rgba(255, 255, 255, 0.8);
            padding: 4px 8px;
            border-radius: 6px;
            border: 1px solid #7dd3fc;
            color: #075985;
        }

        .footer {
            text-align: center;
        }

        .footer-text {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.5;
        }

        .footer-link {
            font-weight: 500;
            color: #3b82f6;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-link:hover {
            color: #2563eb;
            text-decoration: underline;
        }

        .error-message {
            color: #dc2626;
            font-size: 13px;
            margin-top: 4px;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 24px;
            }
            
            .social-login {
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
            }
            
            .social-login button:nth-child(4),
            .social-login button:nth-child(5) {
                grid-column: span 1;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Brand Header -->
        <div class="brand-header">
            <div class="brand-logo">
                <div class="logo-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" fill="white"/>
                        <path d="M2 17L12 22L22 17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 12L12 17L22 12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <span class="logo-text">I-Solutions </span>
            </div>
            
            <div class="badge">
                <span class="badge-dot"></span>
                <span class="badge-text">New look • Inspired by I-Solutions</span>
            </div>
            
            <h1 class="title">Welcome back</h1>
            <p class="subtitle">New to I-Solutions App? <a href="#" class="signup-link">Sign up</a></p>
        </div>

        <!-- Login Card -->
        <div class="login-card">
            <!-- Login Form -->
            <form id="loginForm" class="login-form" method="POST" action="{{ route('login') }}">
                @csrf
                <!-- Email Field -->
                <div class="form-group">
                    <label class="form-label">Your email address</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input type="email" name="email" class="form-input" placeholder="admin@airlineagency.com" value="{{ old('email') }}" required autofocus>
                    </div>
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label class="form-label">Your password</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <input type="password" name="password" class="form-input" placeholder="********" required>
                    </div>
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember & Forgot -->
                <div class="form-footer">
                    <label class="checkbox-wrapper">
                        <input type="checkbox" name="remember" class="checkbox-input">
                        <span class="checkbox-custom"></span>
                        <span class="checkbox-label">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                    @endif
                </div>

                <!-- Login Button -->
                <button type="submit" class="login-button">
                    Log in
                    <svg class="button-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </form>

            <!-- Divider -->
            <div class="divider">
                <div class="divider-line"></div>
                <span class="divider-text">Or log in with</span>
                <div class="divider-line"></div>
            </div>

            <!-- Social Login -->
            <div class="social-login">
                <!-- Gmail -->
                <button class="social-button" onclick="socialLogin('gmail')">
                    <svg class="social-icon" viewBox="0 0 24 24">
                        <path fill="#EA4335" d="M5.266 9.765A7.077 7.077 0 0 1 12 4.909c1.69 0 3.218.6 4.418 1.582L19.91 3C17.782 1.145 15.055 0 12 0 7.27 0 3.198 2.698 1.24 6.65l4.026 3.115Z"/>
                        <path fill="#34A853" d="M16.04 18.013c-1.09.703-2.474 1.078-4.04 1.078a7.077 7.077 0 0 1-6.723-4.823l-4.04 3.067A11.965 11.965 0 0 0 12 24c2.933 0 5.735-1.043 7.834-3l-3.793-2.987Z"/>
                        <path fill="#4A90E2" d="M19.834 21c2.195-2.048 3.62-5.096 3.62-9 0-.71-.109-1.473-.272-2.182H12v4.455h6.436c-.317 1.559-1.17 2.766-2.395 3.558L19.834 21Z"/>
                        <path fill="#FBBC05" d="M5.277 14.268A7.12 7.12 0 0 1 4.909 12c0-.782.125-1.533.357-2.235L1.24 6.65A11.934 11.934 0 0 0 0 12c0 1.92.445 3.73 1.237 5.335l4.04-3.067Z"/>
                    </svg>
                </button>

                <!-- Facebook -->
                <button class="social-button" onclick="socialLogin('facebook')">
                    <svg class="social-icon" fill="#1877F2" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </button>

                <!-- LinkedIn -->
                <button class="social-button" onclick="socialLogin('linkedin')">
                    <svg class="social-icon" fill="#0077B5" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                </button>

                <!-- Twitter -->
                <button class="social-button" onclick="socialLogin('twitter')">
                    <svg class="social-icon" fill="#1DA1F2" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.213c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                </button>

                <!-- YouTube -->
                <button class="social-button" onclick="socialLogin('youtube')">
                    <svg class="social-icon" fill="#FF0000" viewBox="0 0 24 24">
                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Sign Up Link -->
        <div class="signup-link">
            <p class="signup-text">Don't have an account? <a href="#" class="signup-link">Sign up</a></p>
        </div>

        <!-- Demo Credentials -->
        <!-- <div class="demo-card">
            <div class="demo-header">
                <div class="demo-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 16H12V12H11M12 8H12.01M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="demo-title">Demo Credentials</div>
            </div>
            <div class="demo-credentials">
                <div class="demo-row">
                    <span class="demo-label">Email:</span>
                    <span class="demo-value">admin@airlineagency.com</span>
                </div>
                <div class="demo-row">
                    <span class="demo-label">Password:</span>
                    <span class="demo-value">password123</span>
                </div>
            </div>
        </div> -->

        <!-- Footer -->
        <div class="footer">
            <p class="footer-text">
                Our fresh new look is inspired by I-Solutions Dev Team — The people  behind this  awasome Project.<br>
                <a href="#" class="footer-link">Why the change? Get the full story</a>
            </p>
        </div>
    </div>

    <script>
        // Add focus effects to inputs
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.01)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>