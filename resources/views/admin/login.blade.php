<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login — ReadyRide</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Inter', sans-serif;
      background: #0d1117;
      color: #e6edf3;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .login-wrap {
      width: 100%;
      max-width: 400px;
    }

    .login-brand {
      text-align: center;
      margin-bottom: 32px;
    }
    .brand-icon {
      width: 64px; height: 64px;
      border-radius: 16px;
      overflow: hidden;
      display: inline-block;
      margin-bottom: 14px;
    }
    .brand-icon img { width: 100%; height: 100%; object-fit: contain; }
    .brand-name {
      font-size: 22px; font-weight: 900;
      color: #e6edf3; letter-spacing: -0.5px;
    }
    .brand-sub {
      font-size: 13px; color: #8b949e; font-weight: 500; margin-top: 4px;
    }

    .login-card {
      background: #161b22;
      border: 1px solid #30363d;
      border-radius: 12px;
      padding: 28px;
    }
    .login-card h1 {
      font-size: 17px; font-weight: 800;
      color: #e6edf3; margin-bottom: 4px;
    }
    .login-card .sub {
      font-size: 13px; color: #8b949e; margin-bottom: 22px;
    }

    .form-group { margin-bottom: 16px; }
    label { display: block; font-size: 12px; font-weight: 700; color: #8b949e; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 7px; }
    input {
      width: 100%; background: #0d1117;
      border: 1px solid #30363d;
      border-radius: 6px; padding: 10px 13px;
      font-size: 14px; color: #e6edf3; font-family: inherit;
      transition: border .15s;
    }
    input:focus { outline: none; border-color: #c9e265; box-shadow: 0 0 0 3px rgba(201,226,101,.12); }
    input::placeholder { color: #484f58; }

    .error-msg {
      background: rgba(248,81,73,.12);
      border: 1px solid rgba(248,81,73,.3);
      border-radius: 6px;
      padding: 10px 14px;
      font-size: 13px;
      color: #f85149;
      margin-bottom: 16px;
      display: flex; gap: 8px; align-items: center;
    }

    .btn-login {
      width: 100%;
      background: #c9e265;
      color: #0d1117;
      border: none;
      border-radius: 6px;
      padding: 11px;
      font-size: 14px;
      font-weight: 800;
      font-family: inherit;
      cursor: pointer;
      transition: background .15s;
      margin-top: 6px;
    }
    .btn-login:hover { background: #d4e97a; }

    .decor {
      position: fixed; pointer-events: none; opacity: .04;
      border-radius: 50%; background: #c9e265;
    }
    .decor-1 { width: 500px; height: 500px; top: -200px; right: -150px; }
    .decor-2 { width: 300px; height: 300px; bottom: -100px; left: -100px; }
  </style>
</head>
<body>
  <div class="decor decor-1"></div>
  <div class="decor decor-2"></div>

  <div class="login-wrap">
    <div class="login-brand">
      <div class="brand-icon"><img src="{{ url('logo.png') }}" alt="ReadyRide" /></div>
      <div class="brand-name">ReadyRide</div>
      <div class="brand-sub">Fleet Management</div>
    </div>

    <div class="login-card">
      <h1>Admin Sign In</h1>
      <p class="sub">Access the fleet management console</p>

      @if($errors->has('email'))
        <div class="error-msg">⚠ {{ $errors->first('email') }}</div>
      @endif

      <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        <div class="form-group">
          <label for="email">Email address</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required autofocus />
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input id="password" type="password" name="password" placeholder="••••••••" required />
        </div>
        <button type="submit" class="btn-login">Sign In →</button>
      </form>
    </div>
  </div>
</body>
</html>
