<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>@yield('title', 'Admin') — ReadyRide</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg:       #0d1117;
      --surface:  #161b22;
      --surface2: #1c2128;
      --border:   #30363d;
      --border2:  #21262d;
      --primary:  #c9e265;
      --primary-strong: #7fa93c;
      --primary-soft: rgba(201,226,101,.12);
      --accent:   #29b554;
      --text:     #e6edf3;
      --text2:    #8b949e;
      --danger:   #f85149;
      --warning:  #d29922;
      --success:  #3fb950;
      --radius:   6px;
      --shadow:   0 8px 24px rgba(0,0,0,.4);
    }

    body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

    /* ── Sidebar ── */
    .layout { display: flex; min-height: 100vh; }
    .sidebar {
      width: 240px; flex-shrink: 0;
      background: var(--surface);
      border-right: 1px solid var(--border2);
      display: flex; flex-direction: column;
      position: sticky; top: 0; height: 100vh; overflow-y: auto;
    }
    .sidebar-logo {
      padding: 24px 20px 20px;
      border-bottom: 1px solid var(--border2);
      display: flex; align-items: center; gap: 10px;
    }
    .sidebar-logo .logo-icon {
      width: 34px; height: 34px; border-radius: 8px;
      overflow: hidden; flex-shrink: 0;
    }
    .sidebar-logo .logo-icon img { width: 100%; height: 100%; object-fit: contain; }
    .sidebar-logo .logo-text { font-size: 15px; font-weight: 800; color: var(--text); letter-spacing: -0.3px; }
    .sidebar-logo .logo-sub  { font-size: 11px; color: var(--text2); font-weight: 500; margin-top: 1px; }

    .sidebar-nav { flex: 1; padding: 12px 10px; }
    .nav-label { font-size: 10px; font-weight: 700; color: var(--text2); letter-spacing: 1px; text-transform: uppercase; padding: 12px 10px 6px; }
    .nav-item {
      display: flex; align-items: center; gap: 10px;
      padding: 9px 12px; border-radius: var(--radius);
      font-size: 13.5px; font-weight: 500; color: var(--text2);
      text-decoration: none; transition: all .15s;
      margin-bottom: 2px;
    }
    .nav-item:hover { background: var(--surface2); color: var(--text); }
    .nav-item.active { background: var(--primary-soft); color: var(--primary); font-weight: 700; }
    .nav-item .nav-icon { font-size: 15px; width: 18px; text-align: center; }

    .sidebar-footer {
      padding: 12px 10px;
      border-top: 1px solid var(--border2);
    }
    .sidebar-user { display: flex; align-items: center; gap: 10px; padding: 8px 10px; margin-bottom: 4px; }
    .sidebar-avatar {
      width: 30px; height: 30px; border-radius: 50%;
      background: var(--primary); display: flex; align-items: center; justify-content: center;
      font-size: 12px; font-weight: 800; color: #000; flex-shrink: 0;
    }
    .sidebar-name { font-size: 13px; font-weight: 600; color: var(--text); }
    .sidebar-role { font-size: 11px; color: var(--text2); }
    .btn-logout {
      display: flex; align-items: center; gap: 8px; width: 100%;
      padding: 8px 12px; border-radius: var(--radius);
      background: none; border: none; cursor: pointer;
      font-size: 13px; color: var(--danger); font-family: inherit;
      transition: background .15s;
    }
    .btn-logout:hover { background: rgba(248,81,73,.1); }

    /* ── Main ── */
    .main { flex: 1; min-width: 0; display: flex; flex-direction: column; }
    .topbar {
      height: 57px; border-bottom: 1px solid var(--border2);
      display: flex; align-items: center; padding: 0 28px;
      background: var(--surface);
      gap: 12px;
    }
    .topbar-title { font-size: 15px; font-weight: 700; color: var(--text); flex: 1; }
    .page-content { padding: 28px; flex: 1; }

    /* ── Cards ── */
    .card {
      background: var(--surface); border: 1px solid var(--border2);
      border-radius: 8px; overflow: hidden;
    }
    .card-header {
      padding: 16px 20px; border-bottom: 1px solid var(--border2);
      display: flex; align-items: center; gap: 12px;
    }
    .card-title { font-size: 14px; font-weight: 700; color: var(--text); flex: 1; }

    /* ── Alerts ── */
    .alert {
      padding: 10px 16px; border-radius: var(--radius); margin-bottom: 18px;
      font-size: 13.5px; font-weight: 500; display: flex; align-items: center; gap: 8px;
    }
    .alert-success { background: rgba(63,185,80,.12); border: 1px solid rgba(63,185,80,.3); color: var(--success); }
    .alert-error   { background: rgba(248,81,73,.12);  border: 1px solid rgba(248,81,73,.3);  color: var(--danger); }

    /* ── Table ── */
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    th {
      padding: 10px 16px; text-align: left; font-size: 11px; font-weight: 700;
      color: var(--text2); text-transform: uppercase; letter-spacing: .6px;
      background: var(--surface2); border-bottom: 1px solid var(--border);
    }
    td {
      padding: 12px 16px; font-size: 13.5px; color: var(--text);
      border-bottom: 1px solid var(--border2); vertical-align: middle;
    }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: var(--surface2); }

    /* ── Badges ── */
    .badge {
      display: inline-flex; align-items: center; gap: 4px;
      padding: 3px 9px; border-radius: 4px; font-size: 11px; font-weight: 700;
      letter-spacing: .4px; text-transform: uppercase;
    }
    .badge-company { background: rgba(41,181,84,.15);  color: var(--accent); }
    .badge-driver  { background: rgba(201,226,101,.12); color: var(--primary-strong); }

    /* ── Buttons ── */
    .btn {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 8px 16px; border-radius: var(--radius); font-size: 13px; font-weight: 600;
      cursor: pointer; border: none; font-family: inherit; transition: all .15s; text-decoration: none;
    }
    .btn-primary { background: var(--primary); color: #0d1117; }
    .btn-primary:hover { background: #d4e97a; }
    .btn-secondary { background: var(--surface2); color: var(--text); border: 1px solid var(--border); }
    .btn-secondary:hover { background: var(--border2); }
    .btn-danger { background: rgba(248,81,73,.12); color: var(--danger); border: 1px solid rgba(248,81,73,.2); }
    .btn-danger:hover { background: rgba(248,81,73,.2); }
    .btn-sm { padding: 5px 11px; font-size: 12px; }
    .btn-icon { padding: 6px; }

    /* ── Form ── */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group.full { grid-column: 1 / -1; }
    label { font-size: 12px; font-weight: 700; color: var(--text2); text-transform: uppercase; letter-spacing: .5px; }
    input, select, textarea {
      background: var(--bg); border: 1px solid var(--border);
      border-radius: var(--radius); padding: 9px 12px;
      font-size: 14px; color: var(--text); font-family: inherit;
      transition: border .15s; width: 100%;
      appearance: none; -webkit-appearance: none;
    }
    input:focus, select:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(201,226,101,.15); }
    input::placeholder { color: var(--text2); }
    .form-hint { font-size: 11.5px; color: var(--text2); margin-top: 2px; }
    .field-error { font-size: 12px; color: var(--danger); margin-top: 2px; }

    /* ── Filters row ── */
    .filters { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
    .filters input, .filters select { width: auto; min-width: 180px; }

    /* ── Pagination ── */
    .pagination { display: flex; align-items: center; gap: 4px; flex-wrap: wrap; }
    .pagination a, .pagination span {
      display: inline-flex; align-items: center; justify-content: center;
      width: 34px; height: 34px; border-radius: var(--radius); font-size: 13px; font-weight: 600;
      text-decoration: none; color: var(--text2); transition: all .15s;
      border: 1px solid transparent;
    }
    .pagination a:hover { background: var(--surface2); color: var(--text); }
    .pagination .active { background: var(--primary); color: #0d1117; border-color: var(--primary); }
    .pagination .disabled { opacity: .35; pointer-events: none; }

    /* ── Empty ── */
    .empty-state { padding: 60px 20px; text-align: center; color: var(--text2); }
    .empty-state .empty-icon { font-size: 40px; margin-bottom: 14px; }
    .empty-state .empty-title { font-size: 15px; font-weight: 700; color: var(--text); margin-bottom: 6px; }
    .empty-state p { font-size: 13.5px; }

    /* ── Responsive ── */
    @media (max-width: 768px) {
      .sidebar { display: none; }
      .form-grid { grid-template-columns: 1fr; }
      .filters { flex-direction: column; align-items: stretch; }
      .filters input, .filters select { width: 100%; }
    }
  </style>
  @stack('head')
</head>
<body>
<div class="layout">
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-logo">
      <div class="logo-icon"><img src="{{ url('logo.png') }}" alt="ReadyRide" /></div>
      <div>
        <div class="logo-text">ReadyRide</div>
        <div class="logo-sub">Admin Panel</div>
      </div>
    </div>

    <nav class="sidebar-nav">
      <div class="nav-label">Management</div>
      <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <span class="nav-icon">👥</span> Users
      </a>
    </nav>

    <div class="sidebar-footer">
      <div class="sidebar-user">
        <div class="sidebar-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        <div>
          <div class="sidebar-name">{{ Auth::user()->name }}</div>
          <div class="sidebar-role">Administrator</div>
        </div>
      </div>
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" class="btn-logout">
          <span>↩</span> Sign out
        </button>
      </form>
    </div>
  </aside>

  <!-- Main -->
  <main class="main">
    <div class="topbar">
      <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
      @yield('topbar-actions')
    </div>
    <div class="page-content">
      @if(session('success'))
        <div class="alert alert-success">✓ {{ session('success') }}</div>
      @endif
      @if($errors->any() && !$errors->has('email'))
        <div class="alert alert-error">⚠ Please fix the errors below.</div>
      @endif
      @yield('content')
    </div>
  </main>
</div>
@stack('scripts')
</body>
</html>
