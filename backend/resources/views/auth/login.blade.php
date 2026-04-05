<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LegacyLoop</title>
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
            max-width: 420px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border: 1px solid rgba(212, 175, 55, 0.15);
            border-radius: 16px;
            padding: 48px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo img {
            width: 80px;
            height: 80px;
            margin-bottom: 8px;
        }

        .logo-text {
            font-size: 32px;
            font-weight: 700;
            color: var(--gold);
            margin: 0;
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
            border: 1px solid rgba(212, 175, 55, 0.2);
            color: var(--cream);
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--gold);
            color: var(--cream);
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        }

        .form-control::placeholder {
            color: var(--gray);
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, var(--gold) 0%, #c9a027 100%);
            border: none;
            color: var(--dark);
            font-weight: 600;
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            margin-top: 8px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(212, 175, 55, 0.3);
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
            background: rgba(212, 175, 55, 0.2);
        }

        .divider::before {
            margin-right: 12px;
        }

        .divider::after {
            margin-left: 12px;
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
            color: var(--gold);
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
        }

        .signup-link {
            text-align: center;
            margin-top: 24px;
            color: var(--gray);
            font-size: 14px;
        }

        .signup-link a {
            color: var(--gold);
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

        .error-text {
            color: #fca5a5;
            font-size: 12px;
            margin-top: 4px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <img src="{{ asset('images/legacyloop-logo.svg') }}" alt="LegacyLoop">
            <p class="logo-text">LegacyLoop</p>
        </div>

        <h2>Welcome Back</h2>
        <p class="subheading">Sign in to your account</p>

        @if ($errors->any())
        <div class="alert">
            <strong>Login failed!</strong>
            {{-- Show first error --}}
            @foreach ($errors->all() as $error)
                {{ $error }} <br>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="yourname@legacyloop.in" value="{{ old('email') }}" required>
                <div style="margin-top:6px; font-size:12px; color: rgba(212,175,55,0.75); display:flex; align-items:center; gap:5px;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Use your <strong style="color:#d4af37;">&nbsp;@legacyloop.in&nbsp;</strong> email to sign in
                </div>
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

            <button type="submit" class="btn-login">Sign In</button>
        </form>

        <div class="signup-link">
            Don't have an account? <a href="{{ route('register') }}">Create one</a>
        </div>

        <div style="text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(212,175,55,0.15);">
            <a href="{{ route('organization.login') }}" style="color: #a5b4fc; text-decoration: none; font-size: 14px;">
                🏛️ University/Organization Login →
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
