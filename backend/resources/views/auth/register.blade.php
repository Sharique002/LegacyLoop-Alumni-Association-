<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - LegacyLoop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Serif+Display:wght@400&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a1f3a;
            --primary-light: #2d3561;
            --gold: #d4af37;
            --gold-light: #e8cc6a;
            --cream: #f5f1e8;
            --gray: #a0a9b8;
            --dark: #0f1419;
            --input-bg: rgba(255, 255, 255, 0.06);
            --input-border: rgba(212, 175, 55, 0.22);
            --input-focus-bg: rgba(255, 255, 255, 0.1);
            --dropdown-bg: #1e2444;
            --dropdown-hover: #2a3060;
            --dropdown-selected: rgba(212, 175, 55, 0.2);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            color: var(--cream);
        }

        /* ── CARD ── */
        .register-container {
            width: 100%;
            max-width: 500px;
            background: linear-gradient(160deg, #1e2444 0%, #252d5c 100%);
            border: 1px solid rgba(212, 175, 55, 0.18);
            border-radius: 20px;
            padding: 40px 44px;
            box-shadow:
                0 0 0 1px rgba(255,255,255,0.03),
                0 24px 64px rgba(0, 0, 0, 0.45);
        }

        /* ── LOGO ── */
        .logo {
            text-align: center;
            margin-bottom: 22px;
        }
        .logo-text {
            font-size: 26px;
            font-weight: 700;
            color: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        /* ── HEADINGS ── */
        h2 {
            font-family: 'DM Serif Display', serif;
            font-size: 26px;
            color: var(--cream);
            margin-bottom: 6px;
            text-align: center;
        }
        .subheading {
            text-align: center;
            color: var(--gray);
            margin-bottom: 26px;
            font-size: 13.5px;
        }

        /* ── FORM STRUCTURE ── */
        .form-group { margin-bottom: 16px; }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }
        .form-label {
            display: block;
            color: rgba(245, 241, 232, 0.9);
            font-weight: 600;
            margin-bottom: 7px;
            font-size: 13px;
            letter-spacing: 0.2px;
        }

        /* ── INPUTS ── */
        .form-control {
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            color: var(--cream);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            transition: all 0.25s ease;
            width: 100%;
            outline: none;
            -webkit-appearance: none;
        }
        .form-control::placeholder { color: rgba(160, 169, 184, 0.65); }
        .form-control:focus {
            background: var(--input-focus-bg);
            border-color: var(--gold);
            color: var(--cream);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.18);
        }
        .form-control.is-invalid {
            border-color: rgba(239, 68, 68, 0.6);
        }

        /* ── CUSTOM SELECT DROPDOWN ── */
        .custom-select-wrapper {
            position: relative;
        }
        .custom-select-trigger {
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            color: var(--cream);
            border-radius: 8px;
            padding: 10px 40px 10px 14px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            user-select: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.25s ease;
            width: 100%;
        }
        .custom-select-trigger.placeholder-active {
            color: rgba(160, 169, 184, 0.65);
        }
        .custom-select-trigger:hover {
            border-color: rgba(212, 175, 55, 0.45);
            background: var(--input-focus-bg);
        }
        .custom-select-trigger.open {
            border-color: var(--gold);
            background: var(--input-focus-bg);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.18);
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }
        .select-arrow {
            width: 18px;
            height: 18px;
            color: var(--gray);
            transition: transform 0.25s ease, color 0.2s;
            flex-shrink: 0;
        }
        .custom-select-trigger.open .select-arrow {
            transform: rotate(180deg);
            color: var(--gold);
        }

        /* Dropdown list */
        .custom-select-options {
            position: absolute;
            top: calc(100% - 1px);
            left: 0; right: 0;
            background: var(--dropdown-bg);
            border: 1.5px solid var(--gold);
            border-top: none;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            overflow: hidden;
            z-index: 999;
            display: none;
            box-shadow: 0 12px 32px rgba(0,0,0,0.45);
        }
        .custom-select-options.open {
            display: block;
            animation: dropDown 0.18s ease;
        }
        @keyframes dropDown {
            from { opacity: 0; transform: translateY(-6px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .custom-option {
            padding: 10px 14px;
            font-size: 14px;
            color: var(--cream);
            cursor: pointer;
            transition: background 0.15s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .custom-option:first-child {
            color: var(--gray);
            font-style: italic;
        }
        .custom-option:hover {
            background: var(--dropdown-hover);
        }
        .custom-option.selected {
            background: var(--dropdown-selected);
            color: var(--gold);
            font-weight: 600;
        }
        .custom-option.selected::after {
            content: '✓';
            margin-left: auto;
            font-size: 12px;
        }
        /* the hidden real select */
        .real-select {
            position: absolute;
            opacity: 0;
            pointer-events: none;
            width: 1px;
            height: 1px;
        }

        /* ── BUTTON ── */
        .btn-register {
            width: 100%;
            background: linear-gradient(135deg, var(--gold) 0%, #c9a027 100%);
            border: none;
            color: var(--dark);
            font-weight: 700;
            border-radius: 8px;
            padding: 12px;
            font-size: 15px;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            letter-spacing: 0.2px;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(212, 175, 55, 0.35);
        }
        .btn-register:active { transform: translateY(0); }

        /* ── ALERTS ── */
        .alert {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            border-radius: 8px;
            padding: 11px 14px;
            margin-bottom: 20px;
            font-size: 13px;
        }
        .error-text {
            color: #fca5a5;
            font-size: 12px;
            margin-top: 4px;
        }

        /* ── FOOTER LINK ── */
        .login-link {
            text-align: center;
            margin-top: 22px;
            color: var(--gray);
            font-size: 13.5px;
        }
        .login-link a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 700;
        }
        .login-link a:hover { text-decoration: underline; }

        /* ── DIVIDER ── */
        .field-divider {
            height: 1px;
            background: rgba(212,175,55,0.1);
            margin: 6px 0;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo">
            <p class="logo-text">🎓 LegacyLoop</p>
        </div>

        <h2>Join the Alumni</h2>
        <p class="subheading">Create your account to connect with alumni</p>

        @if ($errors->any())
        <div class="alert">
            <strong>Registration failed!</strong><br>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('register.submit') }}" id="registerForm">
            @csrf

            {{-- Name Row --}}
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name"
                           class="form-control @error('first_name') is-invalid @enderror"
                           placeholder="John"
                           value="{{ old('first_name') }}" required>
                    @error('first_name')
                    <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name"
                           class="form-control @error('last_name') is-invalid @enderror"
                           placeholder="Doe"
                           value="{{ old('last_name') }}" required>
                    @error('last_name')
                    <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <div style="position:relative;">
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="yourname@legacyloop.in"
                           value="{{ old('email') }}" required>
                </div>
                <div style="margin-top:6px; font-size:12px; color: rgba(212,175,55,0.75); display:flex; align-items:center; gap:5px;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Must be a <strong style="color:#d4af37;">&nbsp;@legacyloop.in&nbsp;</strong> institutional email
                </div>
                @error('email')
                <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            {{-- Branch & Year Row --}}
            <div class="form-row">
                {{-- Custom Branch Dropdown --}}
                <div class="form-group">
                    <label class="form-label">Branch</label>
                    <div class="custom-select-wrapper" id="branchWrapper">
                        {{-- Hidden real select for form submission --}}
                        <select name="branch" class="real-select @error('branch') is-invalid @enderror"
                                id="branchSelect" required>
                            <option value="">Select Branch</option>
                            <option value="CS"    @if(old('branch')=='CS')    selected @endif>Computer Science</option>
                            <option value="IT"    @if(old('branch')=='IT')    selected @endif>Information Technology</option>
                            <option value="ME"    @if(old('branch')=='ME')    selected @endif>Mechanical</option>
                            <option value="civil" @if(old('branch')=='civil') selected @endif>Civil</option>
                            <option value="EE"    @if(old('branch')=='EE')    selected @endif>Electrical</option>
                            <option value="EC"    @if(old('branch')=='EC')    selected @endif>Electronics</option>
                            <option value="CH"    @if(old('branch')=='CH')    selected @endif>Chemical</option>
                        </select>

                        {{-- Visual trigger --}}
                        <div class="custom-select-trigger placeholder-active" id="branchTrigger">
                            <span id="branchLabel">Select Branch</span>
                            <svg class="select-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </div>

                        {{-- Dropdown options --}}
                        <div class="custom-select-options" id="branchOptions">
                            <div class="custom-option" data-value="">Select Branch</div>
                            <div class="custom-option" data-value="CS">💻 Computer Science</div>
                            <div class="custom-option" data-value="IT">🖥️ Information Technology</div>
                            <div class="custom-option" data-value="ME">⚙️ Mechanical</div>
                            <div class="custom-option" data-value="civil">🏗️ Civil</div>
                            <div class="custom-option" data-value="EE">⚡ Electrical</div>
                            <div class="custom-option" data-value="EC">📡 Electronics</div>
                            <div class="custom-option" data-value="CH">🧪 Chemical</div>
                        </div>
                    </div>
                    @error('branch')
                    <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Graduation Year --}}
                <div class="form-group">
                    <label class="form-label">Graduation Year</label>
                    <input type="number" name="graduation_year"
                           class="form-control @error('graduation_year') is-invalid @enderror"
                           placeholder="{{ date('Y') }}"
                           min="1950" max="{{ date('Y') + 5 }}"
                           value="{{ old('graduation_year') }}" required>
                    @error('graduation_year')
                    <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Min. 8 characters" required>
                @error('password')
                <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation"
                       class="form-control" placeholder="Repeat your password" required>
            </div>

            <button type="submit" class="btn-register">Create Account</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="{{ route('login') }}">Sign In</a>
        </div>
    </div>

    <script>
    (function () {
        const trigger   = document.getElementById('branchTrigger');
        const options   = document.getElementById('branchOptions');
        const select    = document.getElementById('branchSelect');
        const label     = document.getElementById('branchLabel');
        const optionEls = options.querySelectorAll('.custom-option');

        // Pre-select if old() value exists
        const preVal = select.value;
        if (preVal) {
            const match = options.querySelector('[data-value="' + preVal + '"]');
            if (match) activateOption(match, false);
        }

        trigger.addEventListener('click', function (e) {
            e.stopPropagation();
            const isOpen = options.classList.contains('open');
            closeAll();
            if (!isOpen) {
                options.classList.add('open');
                trigger.classList.add('open');
            }
        });

        optionEls.forEach(function (opt) {
            opt.addEventListener('click', function () {
                activateOption(opt, true);
                closeAll();
            });
        });

        document.addEventListener('click', closeAll);
        options.addEventListener('click', function (e) { e.stopPropagation(); });

        function activateOption(opt, update) {
            const val  = opt.getAttribute('data-value');
            const text = opt.textContent.trim();

            // Update hidden select
            if (update) select.value = val;

            // Update trigger label
            if (!val) {
                label.textContent = 'Select Branch';
                trigger.classList.add('placeholder-active');
            } else {
                label.textContent = text;
                trigger.classList.remove('placeholder-active');
            }

            // Highlight selected option
            optionEls.forEach(function (o) { o.classList.remove('selected'); });
            if (val) opt.classList.add('selected');
        }

        function closeAll() {
            options.classList.remove('open');
            trigger.classList.remove('open');
        }
    })();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
