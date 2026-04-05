<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LegacyLoop – Perfect for Alumni Connection</title>
    <meta name="description" content="LegacyLoop connects alumni worldwide. Network, find jobs, attend events, share stories and give back — all in one elegant platform built for your legacy.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display:ital,wght@0,400;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #1a1f3a;
            --primary-light: #2d3561;
            --gold: #d4af37;
            --gold-light: #e8cc6a;
            --cream: #f5f1e8;
            --gray: #a0a9b8;
            --dark: #0f1419;
            --surface: rgba(255,255,255,0.04);
            --border: rgba(212,175,55,0.18);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--dark);
            color: var(--cream);
            overflow-x: hidden;
        }

        /* ─── NAVBAR ─── */
        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            padding: 18px 0;
            transition: all 0.4s ease;
            background: transparent;
        }
        .navbar.scrolled {
            background: rgba(15,20,25,0.92);
            backdrop-filter: blur(20px);
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }
        .navbar-brand {
            font-size: 22px;
            font-weight: 700;
            color: var(--gold) !important;
            letter-spacing: -0.3px;
        }
        .navbar-brand span { font-size: 20px; margin-right: 4px; }
        .nav-link {
            color: rgba(245,241,232,0.75) !important;
            font-weight: 500;
            font-size: 14px;
            padding: 6px 14px !important;
            transition: color 0.2s;
        }
        .nav-link:hover { color: var(--gold) !important; }
        .btn-nav-login {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--cream) !important;
            border-radius: 8px;
            padding: 7px 20px !important;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-nav-login:hover {
            border-color: var(--gold);
            color: var(--gold) !important;
        }
        .btn-nav-cta {
            background: linear-gradient(135deg, var(--gold), #c9a027);
            border: none;
            color: var(--dark) !important;
            border-radius: 8px;
            padding: 7px 20px !important;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-nav-cta:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(212,175,55,0.35);
        }

        /* ─── HERO ─── */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 120px 0 80px;
        }
        .hero-bg {
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 80% 70% at 60% 40%, rgba(45,53,97,0.6) 0%, transparent 70%),
                        radial-gradient(ellipse 50% 50% at 20% 70%, rgba(212,175,55,0.06) 0%, transparent 60%),
                        linear-gradient(160deg, var(--dark) 0%, #0a0e1a 100%);
        }
        .hero-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(212,175,55,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(212,175,55,0.04) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse 70% 70% at 50% 50%, black 30%, transparent 100%);
        }
        .hero-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }
        .orb-1 {
            width: 500px; height: 500px;
            background: rgba(45,53,97,0.5);
            top: -100px; right: -100px;
            animation: float 8s ease-in-out infinite;
        }
        .orb-2 {
            width: 300px; height: 300px;
            background: rgba(212,175,55,0.07);
            bottom: 0; left: 5%;
            animation: float 10s ease-in-out infinite reverse;
        }
        @keyframes float {
            0%,100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-30px) scale(1.05); }
        }

        .hero-content { position: relative; z-index: 1; }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(212,175,55,0.1);
            border: 1px solid rgba(212,175,55,0.25);
            border-radius: 50px;
            padding: 6px 16px;
            font-size: 13px;
            color: var(--gold);
            font-weight: 500;
            margin-bottom: 28px;
            animation: fadeInUp 0.6s ease both;
        }
        .hero-badge .dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: var(--gold);
            animation: pulse 2s ease infinite;
        }
        @keyframes pulse {
            0%,100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.4); }
        }

        .hero-title {
            font-family: 'DM Serif Display', serif;
            font-size: clamp(42px, 6vw, 72px);
            line-height: 1.1;
            margin-bottom: 24px;
            animation: fadeInUp 0.7s 0.1s ease both;
        }
        .hero-title .highlight {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 18px;
            color: var(--gray);
            line-height: 1.7;
            max-width: 520px;
            margin-bottom: 40px;
            animation: fadeInUp 0.7s 0.2s ease both;
        }

        .hero-actions {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            animation: fadeInUp 0.7s 0.3s ease both;
        }
        .btn-primary-cta {
            background: linear-gradient(135deg, var(--gold), #c9a027);
            border: none;
            color: var(--dark);
            font-weight: 700;
            border-radius: 10px;
            padding: 14px 32px;
            font-size: 16px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        .btn-primary-cta:hover {
            color: var(--dark);
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(212,175,55,0.4);
        }
        .btn-secondary-cta {
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--cream);
            font-weight: 600;
            border-radius: 10px;
            padding: 14px 32px;
            font-size: 16px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        .btn-secondary-cta:hover {
            color: var(--gold);
            border-color: rgba(212,175,55,0.4);
            transform: translateY(-2px);
        }

        .hero-stats {
            display: flex;
            gap: 40px;
            margin-top: 56px;
            flex-wrap: wrap;
            animation: fadeInUp 0.7s 0.4s ease both;
        }
        .stat-item { text-align: left; }
        .stat-number {
            font-family: 'DM Serif Display', serif;
            font-size: 32px;
            color: var(--gold);
            line-height: 1;
        }
        .stat-label {
            font-size: 13px;
            color: var(--gray);
            margin-top: 4px;
        }

        /* Hero visual card */
        .hero-visual {
            position: relative;
            animation: fadeInRight 0.8s 0.3s ease both;
        }
        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .hero-card {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 30px 80px rgba(0,0,0,0.5);
        }
        .card-header-ll {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }
        .card-avatar {
            width: 44px; height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), #c9a027);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
            flex-shrink: 0;
        }
        .card-user-name { font-weight: 600; font-size: 15px; }
        .card-user-role { font-size: 12px; color: var(--gray); }
        .card-badge {
            margin-left: auto;
            background: rgba(212,175,55,0.12);
            border: 1px solid rgba(212,175,55,0.25);
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 12px;
            color: var(--gold);
        }
        .activity-feed { display: flex; flex-direction: column; gap: 12px; }
        .activity-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 10px;
            font-size: 13px;
            transition: background 0.2s;
        }
        .activity-item:hover { background: rgba(255,255,255,0.06); }
        .activity-icon {
            width: 36px; height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }
        .ai-gold { background: rgba(212,175,55,0.15); }
        .ai-blue { background: rgba(59,130,246,0.15); }
        .ai-green { background: rgba(16,185,129,0.15); }
        .ai-purple { background: rgba(139,92,246,0.15); }
        .activity-text { flex: 1; }
        .activity-text strong { color: var(--cream); }
        .activity-text span { color: var(--gray); }
        .activity-time { font-size: 11px; color: var(--gray); }

        .floating-chip {
            position: absolute;
            background: var(--primary);
            border: 1px solid var(--border);
            border-radius: 50px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            white-space: nowrap;
        }
        .chip-1 { top: -20px; left: -30px; animation: floatChip 5s ease-in-out infinite; }
        .chip-2 { bottom: 30px; right: -30px; animation: floatChip 6s ease-in-out infinite 1.5s; }
        @keyframes floatChip {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ─── FEATURES ─── */
        .section-label {
            display: inline-block;
            background: rgba(212,175,55,0.1);
            border: 1px solid rgba(212,175,55,0.2);
            border-radius: 50px;
            padding: 5px 16px;
            font-size: 12px;
            font-weight: 600;
            color: var(--gold);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }
        .section-title {
            font-family: 'DM Serif Display', serif;
            font-size: clamp(32px, 4vw, 48px);
            line-height: 1.15;
            margin-bottom: 16px;
        }
        .section-subtitle {
            font-size: 17px;
            color: var(--gray);
            line-height: 1.7;
            max-width: 540px;
            margin: 0 auto;
        }

        .features-section {
            padding: 100px 0;
            position: relative;
        }
        .features-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--border), transparent);
        }

        .feature-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 32px;
            height: 100%;
            transition: all 0.35s ease;
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            opacity: 0;
            transition: opacity 0.35s;
        }
        .feature-card::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(212,175,55,0.1), transparent);
            transition: left 0.5s ease;
            pointer-events: none;
        }
        .feature-card:hover {
            border-color: rgba(212,175,55,0.35);
            transform: translateY(-6px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.25);
        }
        .feature-card:hover::before { opacity: 1; }
        .feature-card:hover::after { left: 100%; }

        .feature-icon {
            width: 52px; height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .fi-gold { background: rgba(212,175,55,0.12); }
        .fi-blue { background: rgba(59,130,246,0.12); }
        .fi-green { background: rgba(16,185,129,0.12); }
        .fi-purple { background: rgba(139,92,246,0.12); }
        .fi-red { background: rgba(239,68,68,0.12); }
        .fi-teal { background: rgba(20,184,166,0.12); }

        .feature-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--cream);
        }
        .feature-desc {
            font-size: 14px;
            color: var(--gray);
            line-height: 1.6;
        }

        /* ─── HOW IT WORKS ─── */
        .how-section {
            padding: 100px 0;
            background: linear-gradient(180deg, transparent 0%, rgba(45,53,97,0.08) 50%, transparent 100%);
            position: relative;
        }
        .step-line {
            position: absolute;
            left: 50%;
            top: 0; bottom: 0;
            width: 1px;
            background: linear-gradient(180deg, transparent, var(--border), transparent);
            transform: translateX(-50%);
        }
        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 28px;
            margin-bottom: 48px;
        }
        .step-num {
            width: 48px; height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), #c9a027);
            color: var(--dark);
            font-weight: 800;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 0 0 8px rgba(212,175,55,0.1);
        }
        .step-content h4 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .step-content p {
            color: var(--gray);
            font-size: 14px;
            line-height: 1.6;
        }

        /* ─── CTA SECTION ─── */
        .cta-section {
            padding: 100px 0;
        }
        .cta-card {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 72px 48px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .cta-card::before {
            content: '';
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(ellipse 50% 50% at 50% 50%, rgba(212,175,55,0.06) 0%, transparent 70%);
        }
        .cta-card .section-title { margin-bottom: 16px; }
        .cta-card .section-subtitle { margin-bottom: 36px; }

        /* ─── FOOTER ─── */
        .footer {
            border-top: 1px solid var(--border);
            padding: 32px 0;
            color: var(--gray);
            font-size: 13px;
        }
        .footer-brand {
            font-size: 18px;
            font-weight: 700;
            color: var(--gold);
        }

        /* ─── UTILITIES ─── */
        .text-gold { color: var(--gold); }
        .divider-section {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--border), transparent);
            margin: 0;
        }

        /* ─── SCROLL REVEAL ─── */
        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ─── LOGO ANIMATIONS ─── */
        .logo-svg {
            width: 100%;
            height: 100%;
            filter: drop-shadow(0 4px 15px rgba(212,175,55,0.2));
        }
        .logo-circle {
            animation: rotateCircle 20s linear infinite;
        }
        @keyframes rotateCircle {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .logo-wave {
            animation: waveAnimation 3s ease-in-out infinite;
        }
        @keyframes waveAnimation {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        /* ─── ENHANCED ANIMATIONS ─── */
        .glow-effect {
            animation: glow 3s ease-in-out infinite;
        }
        @keyframes glow {
            0%, 100% { text-shadow: 0 0 20px rgba(212,175,55,0), 0 0 10px rgba(212,175,55,0); }
            50% { text-shadow: 0 0 30px rgba(212,175,55,0.6), 0 0 20px rgba(212,175,55,0.4); }
        }

        .shimmer {
            background: linear-gradient(90deg, rgba(212,175,55,0.1) 0%, rgba(212,175,55,0.3) 50%, rgba(212,175,55,0.1) 100%);
            background-size: 200% 200%;
            animation: shimmer-animation 3s infinite;
        }
        @keyframes shimmer-animation {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        .bounce-in {
            animation: bounceIn 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        @keyframes bounceIn {
            from {
                opacity: 0;
                transform: scale(0.3);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .slide-in-left {
            animation: slideInLeft 0.7s ease-out;
        }
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .slide-in-right {
            animation: slideInRight 0.7s ease-out;
        }
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .pulse-scale {
            animation: pulseScale 2s ease-in-out infinite;
        }
        @keyframes pulseScale {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        /* ─── FEATURE CARD ANIMATIONS ─── */
        .feature-card {
            perspective: 1000px;
        }
        .feature-card:hover {
            animation: cardHover 0.6s ease-out forwards;
        }
        @keyframes cardHover {
            to {
                transform: translateY(-6px) rotateX(2deg);
            }
        }

        /* ─── STAT COUNTER ANIMATION ─── */
        .stat-counter {
            animation: countUp 2s ease-out forwards;
        }
        @keyframes countUp {
            from {
                opacity: 0;
                transform: scale(0.5);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>
<body>

<!-- ═══════════════ NAVBAR ═══════════════ -->
<nav class="navbar" id="navbar">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between w-100">
            <a class="navbar-brand" href="#" style="display: flex; align-items: center; gap: 12px; font-size: 20px;">
                <img src="/images/legacyloop-logo.svg" alt="LegacyLoop" style="height: 40px; width: auto; filter: drop-shadow(0 2px 8px rgba(212,175,55,0.2));">
                <span class="glow-effect">LegacyLoop</span>
            </a>
            <div class="d-none d-md-flex align-items-center gap-2">
                <a href="#features" class="nav-link">Features</a>
                <a href="#how" class="nav-link">How It Works</a>
                <a href="#join" class="nav-link">Join</a>
                <a href="{{ route('login') }}" class="btn-nav-login nav-link">Sign In</a>
                <a href="{{ route('register') }}" class="btn-nav-cta nav-link">Get Started</a>
            </div>
            <!-- Mobile -->
            <div class="d-flex d-md-none gap-2">
                <a href="{{ route('login') }}" class="btn-nav-login nav-link">Sign In</a>
                <a href="{{ route('register') }}" class="btn-nav-cta nav-link">Join</a>
            </div>
        </div>
    </div>
</nav>

<!-- ═══════════════ HERO ═══════════════ -->
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-grid"></div>
    <div class="hero-orb orb-1"></div>
    <div class="hero-orb orb-2"></div>

    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 hero-content">
                <div class="hero-badge">
                    <span class="dot"></span>
                    Alumni Network Platform
                </div>
                <h1 class="hero-title">
                    Where Legacies<br>
                    <span class="highlight">Connect & Grow</span>
                </h1>
                <p class="hero-subtitle">
                    LegacyLoop brings alumni together — network with peers, discover career opportunities, attend exclusive events, and share inspiring stories. Your legacy starts here.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('register') }}" class="btn-primary-cta pulse-scale" id="hero-join">
                        Join the Network <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="{{ route('login') }}" class="btn-secondary-cta" id="hero-signin">
                        <i class="bi bi-box-arrow-in-right"></i> Sign In
                    </a>
                </div>
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number stat-counter">10K+</div>
                        <div class="stat-label">Alumni Connected</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number stat-counter">500+</div>
                        <div class="stat-label">Jobs Posted</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number stat-counter">200+</div>
                        <div class="stat-label">Events Hosted</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 hero-visual d-none d-lg-block">
                <div class="hero-card">
                    <div class="card-header-ll">
                        <div class="card-avatar">A</div>
                        <div>
                            <div class="card-user-name">Alumni Network</div>
                            <div class="card-user-role">Live Activity Feed</div>
                        </div>
                        <div class="card-badge">● Live</div>
                    </div>
                    <div class="activity-feed">
                        <div class="activity-item">
                            <div class="activity-icon ai-gold">🤝</div>
                            <div class="activity-text">
                                <strong>Priya S.</strong> <span>connected with</span> <strong>Arjun M.</strong>
                            </div>
                            <div class="activity-time">2m ago</div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon ai-blue">💼</div>
                            <div class="activity-text">
                                <strong>New Job</strong> <span>— Senior Engineer at Google posted</span>
                            </div>
                            <div class="activity-time">8m ago</div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon ai-green">🎉</div>
                            <div class="activity-text">
                                <strong>Alumni Gala 2026</strong> <span>— 84 registered</span>
                            </div>
                            <div class="activity-time">15m ago</div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon ai-purple">✨</div>
                            <div class="activity-text">
                                <strong>Rahul K.</strong> <span>shared a success story</span>
                            </div>
                            <div class="activity-time">32m ago</div>
                        </div>
                    </div>
                </div>
                <div class="floating-chip chip-1">
                    <span>🌟</span> 2,400 online now
                </div>
                <div class="floating-chip chip-2">
                    <span>💰</span> ₹12L donated
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════ FEATURES ═══════════════ -->
<div class="divider-section"></div>
<section class="features-section" id="features">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <div class="section-label">Everything You Need</div>
            <h2 class="section-title">Built for Every<br>Alumni Journey</h2>
            <p class="section-subtitle">From your first reconnection to your biggest career milestone, LegacyLoop supports every step.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4 reveal">
                <div class="feature-card">
                    <div class="feature-icon fi-gold">🌐</div>
                    <div class="feature-title">Alumni Directory</div>
                    <div class="feature-desc">Discover and connect with thousands of alumni from your batch, department, or city. Smart filters make finding the right connection effortless.</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 reveal">
                <div class="feature-card">
                    <div class="feature-icon fi-blue">💼</div>
                    <div class="feature-title">Job Board</div>
                    <div class="feature-desc">Access exclusive job postings shared by fellow alumni, apply in seconds, and get hired through trust. Post your own opportunities too.</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 reveal">
                <div class="feature-card">
                    <div class="feature-icon fi-green">🎉</div>
                    <div class="feature-title">Events & Reunions</div>
                    <div class="feature-desc">Never miss a reunion, webinar, or networking event. Create and manage events, track registrations, and celebrate milestones together.</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 reveal">
                <div class="feature-card">
                    <div class="feature-icon fi-purple">💬</div>
                    <div class="feature-title">Direct Messaging</div>
                    <div class="feature-desc">Send and receive messages with your connections. Build meaningful professional relationships through private, secure conversations.</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 reveal">
                <div class="feature-card">
                    <div class="feature-icon fi-red">✨</div>
                    <div class="feature-title">Success Stories</div>
                    <div class="feature-desc">Inspire the next generation by sharing your journey. Read remarkable achievements from alumni who made it big — and learn from them.</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 reveal">
                <div class="feature-card">
                    <div class="feature-icon fi-teal">❤️</div>
                    <div class="feature-title">Donations & Giving</div>
                    <div class="feature-desc">Give back to your alma mater with purpose. Support scholarships, infrastructure, and student initiatives — every contribution matters.</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════ HOW IT WORKS ═══════════════ -->
<div class="divider-section"></div>
<section class="how-section" id="how">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <div class="section-label">Simple & Fast</div>
            <h2 class="section-title">Get Started in<br>Three Easy Steps</h2>
            <p class="section-subtitle">Join thousands of alumni who are already connecting, growing, and giving back.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="step-item reveal">
                    <div class="step-num">1</div>
                    <div class="step-content">
                        <h4>Create Your Account</h4>
                        <p>Register with your email in under a minute. Verify your alumni status and set up your profile with your graduation year, department, and professional details.</p>
                    </div>
                </div>
                <div class="step-item reveal">
                    <div class="step-num">2</div>
                    <div class="step-content">
                        <h4>Build Your Network</h4>
                        <p>Discover familiar faces and new connections. Send connection requests, join communities, and start meaningful conversations through direct messages.</p>
                    </div>
                </div>
                <div class="step-item reveal">
                    <div class="step-num">3</div>
                    <div class="step-content">
                        <h4>Explore & Contribute</h4>
                        <p>Browse job opportunities, RSVP to events, share your success story, or make a donation. Be an active part of a thriving alumni ecosystem.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════ CTA ═══════════════ -->
<div class="divider-section"></div>
<section class="cta-section" id="join">
    <div class="container">
        <div class="cta-card reveal">
            <div style="position: relative; z-index: 1;">
                <div class="section-label">Ready to Begin?</div>
                <h2 class="section-title">Your Legacy Awaits</h2>
                <p class="section-subtitle">Join thousands of alumni already on LegacyLoop. Reconnect, grow, and give back — all in one place.</p>
                <div class="hero-actions justify-content-center">
                    <a href="{{ route('register') }}" class="btn-primary-cta" id="cta-join-btn">
                        Create Free Account <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="{{ route('login') }}" class="btn-secondary-cta" id="cta-signin-btn">
                        <i class="bi bi-box-arrow-in-right"></i> Sign In Instead
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════ FOOTER ═══════════════ -->
<footer class="footer">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="footer-brand" style="display: flex; align-items: center; gap: 8px;">
                <img src="/images/legacyloop-logo.svg" alt="LegacyLoop" style="height: 28px; width: auto;">
                <span>LegacyLoop</span>
            </div>
            <div>© {{ date('Y') }} LegacyLoop. All rights reserved. Built with ❤️ for alumni everywhere.</div>
            <div class="d-flex gap-4">
                <a href="{{ route('login') }}" style="color: var(--gray); text-decoration: none;">Sign In</a>
                <a href="{{ route('register') }}" style="color: var(--gray); text-decoration: none;">Register</a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Navbar scroll effect
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 40) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Scroll reveal with staggered animation
    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                setTimeout(() => entry.target.classList.add('visible'), i * 80);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });
    reveals.forEach(el => observer.observe(el));

    // Animated stats counter
    const animateCounter = (el) => {
        const text = el.textContent;
        const number = parseInt(text);
        let count = 0;
        const speed = number / 60;
        const increment = () => {
            count += speed;
            if (count < number) {
                el.textContent = Math.ceil(count) + (text.includes('+') ? '+' : (text.includes('L') ? 'L' : ''));
                requestAnimationFrame(increment);
            } else {
                el.textContent = text;
            }
        };
        increment();
    };

    // Observe stats for animation
    const statCounters = document.querySelectorAll('.stat-counter');
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.dataset.animated) {
                entry.target.dataset.animated = true;
                animateCounter(entry.target);
            }
        });
    }, { threshold: 0.5 });
    statCounters.forEach(el => counterObserver.observe(el));

    // Smooth active link highlight
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // Add hover ripple effect to buttons
    document.querySelectorAll('.btn-primary-cta, .btn-secondary-cta').forEach(btn => {
        btn.addEventListener('mouseenter', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');

            this.appendChild(ripple);

            setTimeout(() => ripple.remove(), 600);
        });
    });

    // Add mouse move parallax effect to hero
    const heroContent = document.querySelector('.hero-content');
    if (heroContent) {
        document.addEventListener('mousemove', (e) => {
            const x = (e.clientX / window.innerWidth - 0.5) * 10;
            const y = (e.clientY / window.innerHeight - 0.5) * 10;
            heroContent.style.transform = `perspective(1000px) rotateY(${x}deg) rotateX(${-y}deg)`;
        });
    }
</script>

<style>
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.6);
        transform: scale(0);
        animation: rippleAnimation 0.6s ease-out;
        pointer-events: none;
    }
    @keyframes rippleAnimation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
</style>
</body>
</html>
