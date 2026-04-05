<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register University - LegacyLoop</title>
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
            padding: 40px 20px;
        }

        .register-container {
            width: 100%;
            max-width: 520px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border: 1px solid rgba(79, 70, 229, 0.25);
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .logo {
            text-align: center;
            margin-bottom: 24px;
        }

        .logo-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--university-accent) 0%, #6366f1 100%);
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }

        .logo-icon svg {
            width: 32px;
            height: 32px;
            color: white;
        }

        .logo-text {
            font-size: 24px;
            font-weight: 700;
            color: var(--cream);
            margin: 0;
        }

        .logo-subtext {
            font-size: 13px;
            color: var(--university-accent);
            margin-top: 4px;
        }

        h2 {
            font-family: 'DM Serif Display', serif;
            font-size: 26px;
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

        .form-row {
            display: flex;
            gap: 16px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            color: var(--cream);
            font-weight: 500;
            margin-bottom: 6px;
            font-size: 13px;
        }

        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(79, 70, 229, 0.3);
            color: var(--cream);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-select {
            cursor: pointer;
        }

        .form-select option {
            background: var(--primary);
            color: var(--cream);
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--university-accent);
            color: var(--cream);
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
        }

        .form-control::placeholder {
            color: var(--gray);
        }

        .btn-register {
            width: 100%;
            background: linear-gradient(135deg, var(--university-accent) 0%, #6366f1 100%);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            padding: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            margin-top: 8px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(79, 70, 229, 0.3);
            color: white;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: var(--gray);
            font-size: 14px;
        }

        .login-link a {
            color: var(--university-accent);
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .alert {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #86efac;
        }

        .error-text {
            color: #fca5a5;
            font-size: 12px;
            margin-top: 4px;
        }

        .info-note {
            background: rgba(79, 70, 229, 0.1);
            border: 1px solid rgba(79, 70, 229, 0.2);
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #a5b4fc;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .info-note svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            margin-top: 2px;
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

        .section-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--university-accent);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 16px;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo">
            <div class="logo-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <p class="logo-text">LegacyLoop</p>
            <p class="logo-subtext">University Registration</p>
        </div>

        <h2>Register Your Institution</h2>
        <p class="subheading">Create a university portal to connect with your alumni</p>

        <div class="info-note">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>After registration, your account will be reviewed and verified by our team within 24-48 hours.</span>
        </div>

        @if ($errors->any())
        <div class="alert">
            <strong>Registration failed!</strong>
            @foreach ($errors->all() as $error)
                {{ $error }} <br>
            @endforeach
        </div>
        @endif

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('organization.register.submit') }}">
            @csrf

            <div class="section-title">Institution Details</div>

            <div class="form-group">
                <label class="form-label">Institution Name *</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g., Stanford University" value="{{ old('name') }}" required>
                @error('name')
                <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Type *</label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                        <option value="university" {{ old('type') == 'university' ? 'selected' : '' }}>University</option>
                        <option value="college" {{ old('type') == 'college' ? 'selected' : '' }}>College</option>
                        <option value="institute" {{ old('type') == 'institute' ? 'selected' : '' }}>Institute</option>
                        <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('type')
                    <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Website</label>
                    <input type="url" name="website" class="form-control @error('website') is-invalid @enderror" placeholder="https://university.edu" value="{{ old('website') }}">
                    @error('website')
                    <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="2" placeholder="Brief description of your institution">{{ old('description') }}</textarea>
                @error('description')
                <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" placeholder="City" value="{{ old('city') }}">
                    @error('city')
                    <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Country</label>
                    <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" placeholder="Country" value="{{ old('country') }}">
                    @error('country')
                    <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="section-title">Account Credentials</div>

            <div class="form-group">
                <label class="form-label">Official Email *</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="admin@university.edu" value="{{ old('email') }}" required>
                @error('email')
                <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Password *</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Min 8 characters" required>
                    @error('password')
                    <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm Password *</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Contact Phone</label>
                <input type="tel" name="contact_phone" class="form-control @error('contact_phone') is-invalid @enderror" placeholder="+1 (555) 123-4567" value="{{ old('contact_phone') }}">
                @error('contact_phone')
                <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-register">Register Institution</button>
        </form>

        <div class="login-link">
            Already registered? <a href="{{ route('organization.login') }}">Sign in here</a>
        </div>

        <div class="alumni-login-link">
            <a href="{{ route('login') }}">← Back to Alumni Login</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
