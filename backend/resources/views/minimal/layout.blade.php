<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LegacyLoop')</title>
    <style>
        :root {
            --bg: #0f172a;
            --panel: #111827;
            --text: #e5e7eb;
            --muted: #9ca3af;
            --accent: #22c55e;
            --border: #374151;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: radial-gradient(circle at top right, #1f2937, var(--bg) 60%);
            color: var(--text);
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 20px;
            margin-top: 16px;
        }

        nav {
            display: flex;
            gap: 12px;
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            background: rgba(17, 24, 39, 0.8);
            position: sticky;
            top: 0;
            backdrop-filter: blur(6px);
        }

        nav a {
            color: var(--text);
            text-decoration: none;
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 6px 10px;
            font-size: 14px;
        }

        nav a:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        h1, h2 { margin-top: 0; }
        p { color: var(--muted); line-height: 1.6; }

        .ok {
            color: #4ade80;
            font-weight: bold;
        }

        .meta {
            font-size: 13px;
            color: var(--muted);
        }

        code {
            background: #0b1220;
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 2px 6px;
            color: #c7d2fe;
        }
    </style>
</head>
<body>
<nav>
    <a href="{{ route('minimal.home') }}">Home</a>
    <a href="{{ route('minimal.status') }}">Status</a>
    <a href="{{ route('minimal.about') }}">About</a>
</nav>

<div class="container">
    @yield('content')
</div>
</body>
</html>
