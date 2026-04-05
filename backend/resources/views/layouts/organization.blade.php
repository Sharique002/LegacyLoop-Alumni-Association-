<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ Auth::guard('organization')->user()->name }} | LegacyLoop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Serif+Display:wght@400&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a1f3a;
            --primary-light: #2d3561;
            --gold: #d4af37;
            --cream: #f5f1e8;
            --gray: #a0a9b8;
            --dark: #0f1419;
            --university-accent: #4f46e5;
            --accent-glow: rgba(79, 70, 229, 0.4);
            --sidebar-width: 260px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            min-height: 100vh;
            color: var(--cream);
            overflow-x: hidden;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes glow {
            0%, 100% { box-shadow: 0 0 5px var(--accent-glow); }
            50% { box-shadow: 0 0 20px var(--accent-glow), 0 0 30px var(--accent-glow); }
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        @keyframes bounceIn {
            0% { transform: scale(0.9); opacity: 0; }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); opacity: 1; }
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary) 0%, var(--primary-light) 100%);
            border-right: 1px solid rgba(79, 70, 229, 0.15);
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            z-index: 100;
            animation: slideInLeft 0.5s ease-out;
            backdrop-filter: blur(10px);
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 200px;
            background: radial-gradient(ellipse at top left, rgba(79, 70, 229, 0.15) 0%, transparent 70%);
            pointer-events: none;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 24px;
            border-bottom: 1px solid rgba(79, 70, 229, 0.15);
            margin-bottom: 24px;
            position: relative;
        }

        .sidebar-logo {
            width: 42px;
            height: 42px;
            background: transparent;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .sidebar-logo:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .sidebar-logo img {
            width: 42px;
            height: 42px;
            filter: drop-shadow(0 0 10px var(--accent-glow));
        }

        .sidebar-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--cream);
            background: linear-gradient(90deg, var(--cream), var(--university-accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sidebar-subtitle {
            font-size: 11px;
            color: var(--university-accent);
            text-transform: uppercase;
            letter-spacing: 1px;
            animation: pulse 2s ease-in-out infinite;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding-right: 4px;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(79, 70, 229, 0.3);
            border-radius: 2px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--gray);
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 4px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--university-accent);
            transform: scaleY(0);
            transition: transform 0.3s ease;
            border-radius: 0 2px 2px 0;
        }

        .nav-item:hover {
            background: rgba(79, 70, 229, 0.15);
            color: var(--cream);
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.15);
        }

        .nav-item:hover::before {
            transform: scaleY(1);
        }

        .nav-item.active {
            background: linear-gradient(90deg, rgba(79, 70, 229, 0.25), rgba(79, 70, 229, 0.1));
            color: var(--cream);
            box-shadow: 0 4px 20px rgba(79, 70, 229, 0.2);
        }

        .nav-item.active::before {
            transform: scaleY(1);
            box-shadow: 0 0 10px var(--university-accent);
        }

        .nav-item svg {
            width: 20px;
            height: 20px;
            transition: transform 0.3s ease;
        }

        .nav-item:hover svg {
            transform: scale(1.15);
        }

        .nav-section-title {
            font-size: 11px;
            font-weight: 600;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 20px 16px 10px;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }

        .sidebar:hover .nav-section-title {
            opacity: 1;
        }

        .sidebar-footer {
            border-top: 1px solid rgba(79, 70, 229, 0.15);
            padding-top: 16px;
            animation: fadeIn 0.5s ease-out 0.3s both;
        }

        .org-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.15), rgba(79, 70, 229, 0.05));
            border-radius: 12px;
            margin-bottom: 12px;
            border: 1px solid rgba(79, 70, 229, 0.1);
            transition: all 0.3s ease;
        }

        .org-info:hover {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.2), rgba(79, 70, 229, 0.1));
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(79, 70, 229, 0.2);
        }

        .org-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--university-accent), #6366f1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            color: white;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
            transition: transform 0.3s ease;
        }

        .org-info:hover .org-avatar {
            transform: rotate(5deg) scale(1.05);
        }

        .org-name {
            font-weight: 600;
            font-size: 14px;
            color: var(--cream);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 140px;
        }

        .org-status {
            font-size: 11px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .status-verified {
            color: #22c55e;
        }

        .status-verified svg {
            animation: pulse 2s ease-in-out infinite;
        }

        .status-pending {
            color: #fbbf24;
            animation: pulse 1.5s ease-in-out infinite;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 32px 40px;
            min-height: 100vh;
            animation: fadeIn 0.6s ease-out;
            position: relative;
        }

        .main-content::before {
            content: '';
            position: fixed;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.08) 0%, transparent 70%);
            pointer-events: none;
            animation: float 8s ease-in-out infinite;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            animation: fadeInUp 0.5s ease-out;
        }

        .page-title {
            font-family: 'DM Serif Display', serif;
            font-size: 32px;
            color: var(--cream);
            position: relative;
            display: inline-block;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--university-accent), transparent);
            border-radius: 2px;
        }

        .page-subtitle {
            color: var(--gray);
            font-size: 14px;
            margin-top: 4px;
        }

        /* Cards */
        .card {
            background: linear-gradient(135deg, rgba(26, 31, 58, 0.9) 0%, rgba(45, 53, 97, 0.9) 100%);
            border: 1px solid rgba(79, 70, 229, 0.15);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            animation: fadeInUp 0.5s ease-out;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3), 0 0 30px rgba(79, 70, 229, 0.1);
            border-color: rgba(79, 70, 229, 0.3);
        }

        .card-header {
            background: linear-gradient(90deg, rgba(79, 70, 229, 0.1), transparent);
            border-bottom: 1px solid rgba(79, 70, 229, 0.15);
            padding: 18px 24px;
        }

        .card-title {
            font-weight: 600;
            font-size: 16px;
            color: var(--cream);
            margin: 0;
        }

        .card-body {
            padding: 24px;
        }

        /* Stats Cards */
        .stat-card {
            background: linear-gradient(135deg, rgba(26, 31, 58, 0.95) 0%, rgba(45, 53, 97, 0.95) 100%);
            border: 1px solid rgba(79, 70, 229, 0.15);
            border-radius: 16px;
            padding: 24px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            backdrop-filter: blur(10px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            animation: fadeInUp 0.5s ease-out;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--university-accent), #6366f1);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3), 0 0 40px rgba(79, 70, 229, 0.15);
            border-color: rgba(79, 70, 229, 0.3);
        }

        .stat-card:hover::before {
            transform: scaleX(1);
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.2), rgba(99, 102, 241, 0.1));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(79, 70, 229, 0.1);
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 5px 20px rgba(79, 70, 229, 0.3);
        }

        .stat-icon svg {
            width: 24px;
            height: 24px;
            color: var(--university-accent);
            transition: transform 0.3s ease;
        }

        .stat-card:hover .stat-icon svg {
            transform: scale(1.1);
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--cream);
            line-height: 1;
            background: linear-gradient(135deg, var(--cream), #a5b4fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 13px;
            color: var(--gray);
            margin-top: 2px;
        }

        /* Table */
        .table {
            color: var(--cream);
        }

        .table thead th {
            border-bottom: 1px solid rgba(79, 70, 229, 0.2);
            color: var(--gray);
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 14px 16px;
            background: rgba(79, 70, 229, 0.05);
        }

        .table tbody td {
            border-bottom: 1px solid rgba(79, 70, 229, 0.08);
            padding: 16px;
            vertical-align: middle;
            transition: all 0.3s ease;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: linear-gradient(90deg, rgba(79, 70, 229, 0.1), rgba(79, 70, 229, 0.05));
            transform: scale(1.01);
        }

        .table tbody tr:hover td {
            color: var(--cream);
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--university-accent) 0%, #6366f1 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 10px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(79, 70, 229, 0.4);
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:active {
            transform: translateY(-1px);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid rgba(79, 70, 229, 0.3);
            color: var(--cream);
            padding: 12px 24px;
            border-radius: 10px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-outline::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(79, 70, 229, 0.15);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.4s ease, height 0.4s ease;
        }

        .btn-outline:hover {
            border-color: var(--university-accent);
            color: var(--cream);
            box-shadow: 0 5px 20px rgba(79, 70, 229, 0.2);
        }

        .btn-outline:hover::before {
            width: 300px;
            height: 300px;
        }

        /* Badge */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .badge:hover {
            transform: scale(1.05);
        }

        .badge-success {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1));
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.2);
        }

        .badge-warning {
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.2), rgba(251, 191, 36, 0.1));
            color: #fbbf24;
            border: 1px solid rgba(251, 191, 36, 0.2);
        }

        .badge-info {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.2), rgba(79, 70, 229, 0.1));
            color: #a5b4fc;
            border: 1px solid rgba(79, 70, 229, 0.2);
        }

        .badge-danger {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.1));
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        /* Alert */
        .alert {
            border-radius: 12px;
            padding: 16px 20px;
            animation: fadeInUp 0.4s ease-out;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-warning {
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.1), rgba(251, 191, 36, 0.05));
            border: 1px solid rgba(251, 191, 36, 0.3);
            color: #fcd34d;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(34, 197, 94, 0.05));
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #86efac;
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.05));
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #f87171;
        }

        .alert-info {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(79, 70, 229, 0.05));
            border: 1px solid rgba(79, 70, 229, 0.3);
            color: #a5b4fc;
        }

        /* Avatar */
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--university-accent), #6366f1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.2);
        }

        .avatar:hover {
            transform: scale(1.1) rotate(5deg);
        }

        /* Form Controls */
        .form-control, .form-select {
            background: rgba(26, 31, 58, 0.8);
            border: 1px solid rgba(79, 70, 229, 0.2);
            border-radius: 10px;
            color: var(--cream);
            padding: 12px 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(26, 31, 58, 0.95);
            border-color: var(--university-accent);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2), 0 5px 20px rgba(79, 70, 229, 0.1);
            outline: none;
            color: var(--cream);
        }

        .form-control::placeholder {
            color: var(--gray);
        }

        .form-label {
            color: var(--gray);
            font-weight: 500;
            font-size: 13px;
            margin-bottom: 8px;
            transition: color 0.3s ease;
        }

        .form-group:focus-within .form-label {
            color: var(--university-accent);
        }

        /* Grid animations */
        .row > [class*="col-"] {
            animation: fadeInUp 0.5s ease-out;
        }

        .row > [class*="col-"]:nth-child(1) { animation-delay: 0.1s; }
        .row > [class*="col-"]:nth-child(2) { animation-delay: 0.15s; }
        .row > [class*="col-"]:nth-child(3) { animation-delay: 0.2s; }
        .row > [class*="col-"]:nth-child(4) { animation-delay: 0.25s; }
        .row > [class*="col-"]:nth-child(5) { animation-delay: 0.3s; }
        .row > [class*="col-"]:nth-child(6) { animation-delay: 0.35s; }

        /* Loading spinner */
        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid rgba(79, 70, 229, 0.1);
            border-top-color: var(--university-accent);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            animation: fadeIn 0.5s ease-out;
        }

        .empty-state svg {
            width: 80px;
            height: 80px;
            color: var(--gray);
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
        }

        .empty-state h3 {
            color: var(--cream);
            font-size: 20px;
            margin-bottom: 8px;
        }

        .empty-state p {
            color: var(--gray);
            font-size: 14px;
        }

        /* Pagination */
        .pagination {
            gap: 6px;
        }

        .page-item .page-link {
            background: rgba(26, 31, 58, 0.8);
            border: 1px solid rgba(79, 70, 229, 0.2);
            color: var(--cream);
            border-radius: 8px;
            padding: 8px 14px;
            transition: all 0.3s ease;
        }

        .page-item .page-link:hover {
            background: rgba(79, 70, 229, 0.2);
            border-color: var(--university-accent);
            transform: translateY(-2px);
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, var(--university-accent), #6366f1);
            border-color: transparent;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }

        /* Modal */
        .modal-content {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border: 1px solid rgba(79, 70, 229, 0.2);
            border-radius: 16px;
            animation: bounceIn 0.4s ease-out;
        }

        .modal-header {
            border-bottom: 1px solid rgba(79, 70, 229, 0.15);
            padding: 20px 24px;
        }

        .modal-title {
            color: var(--cream);
            font-weight: 600;
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            border-top: 1px solid rgba(79, 70, 229, 0.15);
            padding: 16px 24px;
        }

        .btn-close {
            filter: invert(1);
            opacity: 0.5;
            transition: opacity 0.3s ease;
        }

        .btn-close:hover {
            opacity: 1;
        }

        /* Mobile sidebar toggle */
        .sidebar-toggle {
            display: none;
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--university-accent), #6366f1);
            border: none;
            border-radius: 50%;
            color: white;
            cursor: pointer;
            z-index: 1001;
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 35px rgba(79, 70, 229, 0.5);
        }

        .sidebar-toggle svg {
            width: 24px;
            height: 24px;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1000;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 24px 20px;
            }

            .sidebar-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .page-title {
                font-size: 24px;
            }
        }

        @media (max-width: 576px) {
            .stat-card {
                padding: 16px;
            }

            .stat-value {
                font-size: 24px;
            }

            .card-body {
                padding: 16px;
            }
        }

        /* Utility classes */
        .text-gradient {
            background: linear-gradient(135deg, var(--cream), #a5b4fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glow-text {
            text-shadow: 0 0 20px rgba(79, 70, 229, 0.5);
        }

        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }
    </style>
    @yield('styles')
</head>
<body>
    @php
        $organization = Auth::guard('organization')->user();
    @endphp

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo" style="background: transparent;">
                <img src="{{ asset('images/legacyloop-logo.svg') }}" alt="LegacyLoop" style="width: 42px; height: 42px;">
            </div>
            <div>
                <div class="sidebar-title">LegacyLoop</div>
                <div class="sidebar-subtitle">University Portal</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('organization.dashboard') }}" class="nav-item {{ request()->routeIs('organization.dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <div class="nav-section-title">Alumni</div>
            
            <a href="{{ route('organization.alumni') }}" class="nav-item {{ request()->routeIs('organization.alumni*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Alumni Directory
            </a>

            <div class="nav-section-title">Events</div>
            
            <a href="{{ route('organization.events') }}" class="nav-item {{ request()->routeIs('organization.events') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                All Events
            </a>

            <a href="{{ route('organization.events.create') }}" class="nav-item {{ request()->routeIs('organization.events.create') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Create Event
            </a>

            <div class="nav-section-title">Engagement</div>

            <a href="{{ route('organization.announcements') }}" class="nav-item {{ request()->routeIs('organization.announcements*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
                Announcements
            </a>

            <a href="{{ route('organization.jobs') }}" class="nav-item {{ request()->routeIs('organization.jobs*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Job Postings
            </a>

            <a href="{{ route('organization.donations') }}" class="nav-item {{ request()->routeIs('organization.donations*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Donation Campaigns
            </a>

            <a href="{{ route('organization.messages') }}" class="nav-item {{ request()->routeIs('organization.messages*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Alumni Messages
            </a>

            <a href="{{ route('organization.stories') }}" class="nav-item {{ request()->routeIs('organization.stories*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
                Success Stories
            </a>

            <a href="{{ route('organization.analytics') }}" class="nav-item {{ request()->routeIs('organization.analytics') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Analytics
            </a>

            <div class="nav-section-title">Settings</div>
            
            <a href="{{ route('organization.profile') }}" class="nav-item {{ request()->routeIs('organization.profile') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Profile Settings
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="org-info">
                <div class="org-avatar">
                    {{ strtoupper(substr($organization->name, 0, 2)) }}
                </div>
                <div>
                    <div class="org-name">{{ $organization->name }}</div>
                    <div class="org-status {{ $organization->is_verified ? 'status-verified' : 'status-pending' }}">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="8"/>
                        </svg>
                        {{ $organization->is_verified ? 'Verified' : 'Pending Verification' }}
                    </div>
                </div>
            </div>
            <form action="{{ route('organization.logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-item w-100 text-start border-0 bg-transparent" style="color: var(--gray);">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Mobile Sidebar Toggle -->
    <button class="sidebar-toggle" id="sidebarToggle">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main Content -->
    <main class="main-content">
        @if (session('warning'))
        <div class="alert alert-warning mb-4">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <span><strong>Notice:</strong> {{ session('warning') }}</span>
        </div>
        @endif

        @if (session('success'))
        <div class="alert alert-success mb-4">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger mb-4">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile sidebar toggle
        const sidebar = document.querySelector('.sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');
                document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
            });
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = '';
            });
        }

        // Add stagger animation to cards
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.card, .stat-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${0.1 + index * 0.05}s`;
            });

            // Smooth scroll
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            });

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'all 0.5s ease-out';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });

        // Counter animation for stat values
        function animateCounter(element, target, duration = 1000) {
            let start = 0;
            const increment = target / (duration / 16);
            const timer = setInterval(() => {
                start += increment;
                if (start >= target) {
                    element.textContent = target.toLocaleString();
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(start).toLocaleString();
                }
            }, 16);
        }

        // Animate counters when in view
        const observerOptions = {
            threshold: 0.5
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statValue = entry.target.querySelector('.stat-value');
                    if (statValue && !statValue.dataset.animated) {
                        const value = parseInt(statValue.textContent.replace(/,/g, ''));
                        if (!isNaN(value)) {
                            statValue.dataset.animated = 'true';
                            animateCounter(statValue, value);
                        }
                    }
                }
            });
        }, observerOptions);

        document.querySelectorAll('.stat-card').forEach(card => {
            observer.observe(card);
        });
    </script>
    <style>
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }
    </style>
    @yield('scripts')
</body>
</html>
