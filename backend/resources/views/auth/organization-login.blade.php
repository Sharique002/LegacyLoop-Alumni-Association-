<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Login - LegacyLoop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=DM+Serif+Display:wght@400&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a1f3a;
            --primary-light: #2d3561;
            --gold: #d4af37;
            --cream: #f5f1e8;
            --gray: #a0a9b8;
            --dark: #0f1419;
            --university-accent: #4f46e5;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--cream);
        }

        .login-container {
            width: 100%;
            max-width: 440px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border: 1px solid rgba(79, 70, 229, 0.25);
            border-radius: 16px;
            padding: 48px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            display: inline-block;
            margin-bottom: 16px;
        }

        .logo-icon img {
            width: 100%;
            height: 100%;
        }

        .logo-text {
            font-size: 28px;
            font-weight: 700;
            color: var(--cream);
            margin: 0;
        }

        .logo-subtext {
            font-size: 14px;
            color: var(--university-accent);
            margin-top: 4px;
        }

        h2 {
            font-family: 'DM Serif Display', serif;
            font-size: 28px;
            color: var(--cream);
            margin-bottom: 8px;
            text-align: center;
        }

        .subheading {
            text-align: center;
            color: var(--gray);
            margin-bottom: 24px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            color: var(--cream);
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(79, 70, 229, 0.3);
            color: var(--cream);
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--university-accent);
            color: var(--cream);
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
        }

        .form-control::placeholder {
            color: var(--gray);
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, var(--university-accent) 0%, #6366f1 100%);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            margin-top: 8px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(79, 70, 229, 0.3);
            color: white;
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            margin-bottom: 24px;
            margin-top: 16px;
        }

        .form-footer a {
            color: var(--university-accent);
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
        }

        .checkbox-wrapper input {
            margin-right: 8px;
            accent-color: var(--university-accent);
        }

        .signup-link {
            text-align: center;
            margin-top: 24px;
            color: var(--gray);
            font-size: 14px;
        }

        .signup-link a {
            color: var(--university-accent);
            text-decoration: none;
            font-weight: 600;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        .alert {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 24px;
            font-size: 13px;
        }

        .alert-warning {
            background: rgba(251, 191, 36, 0.1);
            border: 1px solid rgba(251, 191, 36, 0.3);
            color: #fcd34d;
        }

        .error-text {
            color: #fca5a5;
            font-size: 12px;
            margin-top: 4px;
        }

        .divider {
            display: flex;
            align-items: center;
            color: var(--gray);
            margin: 24px 0;
            font-size: 14px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(79, 70, 229, 0.2);
        }

        .divider::before {
            margin-right: 12px;
        }

        .divider::after {
            margin-left: 12px;
        }

        .alumni-login-link {
            text-align: center;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid rgba(79, 70, 229, 0.15);
        }

        .alumni-login-link a {
            color: var(--gold);
            text-decoration: none;
            font-size: 14px;
        }

        .alumni-login-link a:hover {
            text-decoration: underline;
        }

        .feature-badges {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .feature-badge {
            background: rgba(79, 70, 229, 0.15);
            color: var(--university-accent);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .feature-badge svg {
            width: 14px;
            height: 14px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <div class="logo-icon">
                <img src="{{ asset('images/legacyloop-logo.svg') }}" alt="LegacyLoop">
            </div>
            <p class="logo-text">LegacyLoop</p>
            <p class="logo-subtext">University Portal</p>
        </div>

        <h2>University Login</h2>
        <p class="subheading">Access your institution's alumni network</p>

        <div class="feature-badges">
            <span class="feature-badge">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                View Alumni
            </span>
            <span class="feature-badge">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Create Events
            </span>
            <span class="feature-badge">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Analytics
            </span>
        </div>

        @if ($errors->any())
        <div class="alert">
            <strong>Login failed!</strong>
            @foreach ($errors->all() as $error)
                {{ $error }} <br>
            @endforeach
        </div>
        @endif

        @if (session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
        @endif

        <form method="POST" action="{{ route('organization.login.submit') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">University Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="admin@university.edu" value="{{ old('email') }}" required>
                @error('email')
                <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
                @error('password')
                <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-footer">
                <div class="checkbox-wrapper">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember" style="margin: 0; cursor: pointer;">Remember me</label>
                </div>
                <a href="#forgot">Forgot password?</a>
            </div>

            <button type="submit" class="btn-login">Sign In to University Portal</button>
        </form>

        <div class="signup-link">
            New university? <a href="{{ route('organization.register') }}">Register your institution</a>
        </div>

        <div class="alumni-login-link">
            <a href="{{ route('login') }}">← Back to Alumni Login</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
