<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LegacyLoop - Alumni Platform')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=DM+Serif+Display:wght@400&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Color Scheme */
            --primary: #1a1f3a;
            --primary-light: #2d3561;
            --primary-lighter: #3d4575;
            --dark: #0f1419;
            --gold: #d4af37;
            --cream: #f5f1e8;
            --gray: #a0a9b8;
            --gray-light: #e9ecf1;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --blue: #3b82f6;
            --green: #10b981;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--dark);
            color: var(--cream);
            min-height: 100vh;
        }

        .serif {
            font-family: 'DM Serif Display', serif;
        }

        /* Layout */
        .layout-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            padding: 24px;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(212, 175, 55, 0.1);
            max-height: 100vh;
            overflow-y: auto;
            position: sticky;
            top: 0;
        }

        .sidebar-logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--gold);
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-logo img {
            height: 36px;
            width: auto;
            filter: drop-shadow(0 2px 8px rgba(212,175,55,0.2));
        }

        .sidebar-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
            flex: 1;
        }

        .sidebar-menu-item {
            padding: 12px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--gray);
            cursor: pointer;
            text-decoration: none;
            border: 1px solid transparent;
        }

        .sidebar-menu-item:hover {
            background: rgba(212, 175, 55, 0.1);
            color: var(--gold);
            border-color: rgba(212, 175, 55, 0.2);
        }

        .sidebar-menu-item.active {
            background: rgba(212, 175, 55, 0.15);
            color: var(--gold);
            border-color: var(--gold);
            font-weight: 600;
        }

        .sidebar-menu-item i {
            font-size: 18px;
            min-width: 24px;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%);
            padding: 16px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(212, 175, 55, 0.1);
            gap: 20px;
        }

        .topbar-search {
            flex: 1;
            max-width: 400px;
        }

        .topbar-search input {
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(212, 175, 55, 0.2);
            padding: 8px 16px;
            border-radius: 8px;
            color: var(--cream);
            font-size: 14px;
        }

        .topbar-search input::placeholder {
            color: var(--gray);
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .topbar-btn {
            background: none;
            border: none;
            color: var(--gray);
            cursor: pointer;
            font-size: 20px;
            transition: all 0.3s ease;
            position: relative;
        }

        .topbar-btn:hover {
            color: var(--gold);
        }

        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--danger);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
        }

        .content-area {
            flex: 1;
            padding: 28px;
            overflow-y: auto;
        }

        /* Cards */
        .card {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border: 1px solid rgba(212, 175, 55, 0.1);
            border-radius: 16px;
            margin-bottom: 20px;
        }

        .card-header {
            border-bottom: 1px solid rgba(212, 175, 55, 0.1);
            background: rgba(212, 175, 55, 0.05);
        }

        .card-body {
            padding: 20px;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--gold) 0%, #c9a027 100%);
            border: none;
            color: var(--dark);
            font-weight: 600;
            border-radius: 8px;
            padding: 10px 24px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(212, 175, 55, 0.3);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--gold);
            color: var(--gold);
            font-weight: 600;
            border-radius: 8px;
            padding: 10px 24px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-outline:hover {
            background: rgba(212, 175, 55, 0.15);
        }

        /* Stats Display */
        .stat-card {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), rgba(212, 175, 55, 0.05));
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            margin-bottom: 16px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--gold);
            margin: 12px 0;
        }

        .stat-label {
            font-size: 14px;
            color: var(--gray);
        }

        /* Forms */
        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(212, 175, 55, 0.2);
            color: var(--cream);
            border-radius: 8px;
            padding: 10px 16px;
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

        /* Select dropdown options styling */
        .form-control option {
            background-color: var(--primary);
            color: var(--cream);
            padding: 10px;
        }

        .form-control option:hover,
        .form-control option:focus,
        .form-control option:checked {
            background-color: var(--primary-light);
            color: var(--gold);
        }

        .form-label {
            color: var(--cream);
            font-weight: 500;
            margin-bottom: 8px;
        }

        /* Badges */
        .badge-primary {
            background: linear-gradient(135deg, var(--blue) 0%, #1e40af 100%);
            color: white;
        }

        .badge-success {
            background: var(--success);
            color: white;
        }

        .badge-danger {
            background: var(--danger);
            color: white;
        }

        .badge-warning {
            background: var(--warning);
            color: white;
        }

        /* Avatar */
        .avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold) 0%, #c9a027 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--dark);
            font-size: 18px;
        }

        /* Tables */
        .table {
            color: var(--cream);
        }

        .table thead th {
            border-color: rgba(212, 175, 55, 0.2);
            color: var(--gold);
            font-weight: 600;
            background: rgba(212, 175, 55, 0.05);
        }

        .table tbody td {
            border-color: rgba(212, 175, 55, 0.1);
            padding: 16px;
            vertical-align: middle;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .layout-wrapper {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                padding: 16px;
                max-height: none;
                border-right: none;
                border-bottom: 1px solid rgba(212, 175, 55, 0.1);
                display: none;
            }

            .sidebar.active {
                display: flex;
            }

            .topbar {
                flex-wrap: wrap;
            }

            .topbar-search {
                max-width: 100%;
            }

            .content-area {
                padding: 16px;
            }
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(212, 175, 55, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(212, 175, 55, 0.3);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(212, 175, 55, 0.5);
        }
    </style>

    @yield('styles')
</head>
<body>
    <div class="layout-wrapper">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <img src="/images/legacyloop-logo.svg" alt="LegacyLoop">
                <span>LegacyLoop</span>
            </div>

            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('dashboard') }}" class="sidebar-menu-item @if(request()->routeIs('dashboard')) active @endif">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('alumni.index') }}" class="sidebar-menu-item @if(request()->routeIs('alumni.*')) active @endif">
                        <i class="fas fa-users"></i>
                        <span>Alumni Directory</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('jobs.index') }}" class="sidebar-menu-item @if(request()->routeIs('jobs.*')) active @endif">
                        <i class="fas fa-briefcase"></i>
                        <span>Job Portal</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('events.index') }}" class="sidebar-menu-item @if(request()->routeIs('events.*')) active @endif">
                        <i class="fas fa-calendar"></i>
                        <span>Events</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('networking.index') }}" class="sidebar-menu-item @if(request()->routeIs('networking.*')) active @endif">
                        <i class="fas fa-comments"></i>
                        <span>Networking</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('stories.index') }}" class="sidebar-menu-item @if(request()->routeIs('stories.*')) active @endif">
                        <i class="fas fa-book"></i>
                        <span>Success Stories</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('donations.index') }}" class="sidebar-menu-item @if(request()->routeIs('donations.*')) active @endif">
                        <i class="fas fa-heart"></i>
                        <span>Donations</span>
                    </a>
                </li>

                @if(auth()->user() && auth()->user()->is_admin)
                <li style="margin-top: 16px; border-top: 1px solid rgba(212, 175, 55, 0.1); padding-top: 16px;">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-item @if(request()->routeIs('admin.*')) active @endif">
                        <i class="fas fa-shield-alt"></i>
                        <span>Admin Panel</span>
                    </a>
                </li>
                @endif
            </ul>

            <div style="border-top: 1px solid rgba(212, 175, 55, 0.1); padding-top: 16px;">
                <a href="{{ route('profile.edit') }}" class="sidebar-menu-item @if(request()->routeIs('profile.*')) active @endif">
                    <i class="fas fa-user-circle"></i>
                    <span>Profile</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" style="margin-top: 12px;">
                    @csrf
                    <button type="submit" class="sidebar-menu-item" style="width: 100%; text-align: left; padding: 12px 16px; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #ef4444;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Topbar -->
            <header class="topbar">
                <div class="topbar-search">
                    <input type="text" placeholder="Search alumni, jobs, events...">
                </div>

                <div class="topbar-actions">
                    <button class="topbar-btn" title="Notifications">
                        <i class="fas fa-bell"></i>
                        @if(auth()->user() && auth()->user()->unreadNotificationsCount() > 0)
                        <span class="notification-badge">{{ auth()->user()->unreadNotificationsCount() }}</span>
                        @endif
                    </button>

                    <button class="topbar-btn" title="Messages">
                        <i class="fas fa-envelope"></i>
                    </button>

                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Profile" class="avatar" style="object-fit: cover;">
                    @else
                        <div class="avatar">{{ auth()->user()->getInitials() ?? 'AL' }}</div>
                    @endif
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Oops!</strong> Something went wrong.
                    <ul class="mb-0" style="margin-top: 8px;">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
