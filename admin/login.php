<?php
require_once __DIR__ . '/auth.php';

if (is_admin_logged_in()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $data = get_portfolio_data();
    $storedHash = $data['admin_password_hash'] ?? '$2y$10$e8w6Q01Q2yv5zL01S.311.A3eLqXmX3mN.R8jG.e6.Z6wQ.x9q.';

    // Default password check: admin / admin123
    if ($username === 'admin' && (password_verify($password, $storedHash) || $password === 'admin123')) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user'] = 'Sahashra Janith';
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login | Sahashra Janith Portfolio</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
    body {
      background: #090d16;
      color: #f1f5f9;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 20px;
    }
    .login-card {
      background: #111827;
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 16px;
      padding: 40px 32px;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
    }
    .brand-logo {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 24px;
      justify-content: center;
    }
    .logo-box {
      width: 44px;
      height: 44px;
      background: linear-gradient(135deg, #00f2fe, #3b82f6);
      color: #05070a;
      font-weight: 800;
      font-size: 20px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .brand-title {
      font-size: 20px;
      font-weight: 700;
      letter-spacing: -0.5px;
    }
    .login-header {
      text-align: center;
      margin-bottom: 28px;
    }
    .login-header h2 { font-size: 22px; font-weight: 700; margin-bottom: 6px; }
    .login-header p { font-size: 14px; color: #94a3b8; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: #cbd5e1; margin-bottom: 8px; }
    .input-wrapper { position: relative; }
    .input-wrapper i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #64748b; }
    .form-control {
      width: 100%;
      padding: 12px 14px 12px 42px;
      background: #1e293b;
      border: 1px solid #334155;
      border-radius: 10px;
      color: #fff;
      font-size: 14px;
      outline: none;
      transition: border-color 0.2s;
    }
    .form-control:focus { border-color: #00f2fe; }
    .btn-login {
      width: 100%;
      padding: 13px;
      background: linear-gradient(135deg, #00f2fe, #3b82f6);
      border: none;
      border-radius: 10px;
      color: #05070a;
      font-size: 15px;
      font-weight: 700;
      cursor: pointer;
      transition: opacity 0.2s, transform 0.1s;
    }
    .btn-login:hover { opacity: 0.95; transform: translateY(-1px); }
    .alert-danger {
      background: rgba(239, 68, 68, 0.15);
      border: 1px solid rgba(239, 68, 68, 0.4);
      color: #fca5a5;
      padding: 12px;
      border-radius: 8px;
      font-size: 13px;
      margin-bottom: 20px;
      text-align: center;
    }
    .back-link {
      display: block;
      text-align: center;
      margin-top: 20px;
      color: #94a3b8;
      font-size: 13px;
      text-decoration: none;
    }
    .back-link:hover { color: #00f2fe; }
  </style>
</head>
<body>

  <div class="login-card">
    <div class="brand-logo">
      <div class="logo-box">SJ</div>
      <div class="brand-title">Admin Panel</div>
    </div>

    <div class="login-header">
      <h2>Welcome Back</h2>
      <p>Log in to manage your portfolio content</p>
    </div>

    <?php if (!empty($error)): ?>
      <div class="alert-danger"><i class="fa-solid fa-circle-exclamation"></i> <?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
      <div class="form-group">
        <label>Username</label>
        <div class="input-wrapper">
          <i class="fa-solid fa-user"></i>
          <input type="text" name="username" class="form-control" placeholder="admin" required autofocus />
        </div>
      </div>

      <div class="form-group">
        <label>Password</label>
        <div class="input-wrapper">
          <i class="fa-solid fa-lock"></i>
          <input type="password" name="password" class="form-control" placeholder="••••••••" required />
        </div>
      </div>

      <button type="submit" class="btn-login">Log In to Dashboard</button>
    </form>

    <a href="../" class="back-link"><i class="fa-solid fa-arrow-left"></i> Back to Main Portfolio Website</a>
  </div>

</body>
</html>
