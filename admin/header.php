<?php
require_once __DIR__ . '/auth.php';
require_admin_login();

$portfolioData = get_portfolio_data();
$unreadCount = 0;
if (!empty($portfolioData['messages'])) {
    foreach ($portfolioData['messages'] as $m) {
        if (empty($m['read'])) $unreadCount++;
    }
}
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard | Sahashra Janith</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <style>
    :root {
      --bg-dark: #090d16;
      --bg-card: #111827;
      --bg-sidebar: #0f172a;
      --border-color: rgba(255, 255, 255, 0.08);
      --accent: #00f2fe;
      --accent-blue: #3b82f6;
      --text-main: #f8fafc;
      --text-dim: #94a3b8;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
    body { background: var(--bg-dark); color: var(--text-main); display: flex; min-height: 100vh; }
    
    /* Sidebar */
    .admin-sidebar {
      width: 260px;
      background: var(--bg-sidebar);
      border-right: 1px solid var(--border-color);
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      z-index: 100;
    }
    .sidebar-header {
      padding: 24px 20px;
      display: flex;
      align-items: center;
      gap: 12px;
      border-bottom: 1px solid var(--border-color);
    }
    .logo-box {
      width: 40px; height: 40px;
      background: linear-gradient(135deg, var(--accent), var(--accent-blue));
      color: #05070a; font-weight: 800; font-size: 18px;
      border-radius: 10px; display: flex; align-items: center; justify-content: center;
    }
    .brand-name { font-size: 17px; font-weight: 700; letter-spacing: -0.3px; }
    .brand-name span { color: var(--accent); }
    
    .sidebar-menu { list-style: none; padding: 20px 12px; flex: 1; overflow-y: auto; }
    .menu-label { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: var(--text-dim); margin: 16px 12px 8px; font-weight: 700; }
    .menu-link {
      display: flex; align-items: center; gap: 12px;
      padding: 12px 16px; color: var(--text-dim);
      text-decoration: none; border-radius: 10px;
      font-size: 14px; font-weight: 600;
      transition: all 0.2s ease;
    }
    .menu-link:hover, .menu-link.active {
      background: rgba(0, 242, 254, 0.1);
      color: var(--accent);
    }
    .menu-link i { font-size: 16px; width: 20px; text-align: center; }
    .badge-count {
      margin-left: auto; background: #ef4444; color: #fff;
      font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 20px;
    }

    .sidebar-footer { padding: 16px; border-top: 1px solid var(--border-color); }
    .btn-logout {
      width: 100%; padding: 10px; background: rgba(239, 68, 68, 0.1);
      border: 1px solid rgba(239, 68, 68, 0.2); color: #fca5a5;
      border-radius: 8px; cursor: pointer; text-decoration: none;
      display: flex; align-items: center; justify-content: center; gap: 8px;
      font-size: 13px; font-weight: 600; transition: background 0.2s;
    }
    .btn-logout:hover { background: rgba(239, 68, 68, 0.2); }

    /* Main Container */
    .admin-main { margin-left: 260px; flex: 1; padding: 32px; min-width: 0; }
    .top-bar {
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 32px; padding-bottom: 20px; border-bottom: 1px solid var(--border-color);
    }
    .page-title h1 { font-family: 'Outfit', sans-serif; font-size: 26px; font-weight: 700; }
    .page-title p { font-size: 14px; color: var(--text-dim); margin-top: 2px; }

    .view-site-btn {
      display: flex; align-items: center; gap: 8px; padding: 10px 18px;
      background: rgba(255, 255, 255, 0.05); border: 1px solid var(--border-color);
      color: var(--text-main); text-decoration: none; border-radius: 10px;
      font-size: 13px; font-weight: 600; transition: all 0.2s;
    }
    .view-site-btn:hover { background: rgba(255, 255, 255, 0.1); border-color: var(--accent); color: var(--accent); }

    /* Alert Banners */
    .alert-success {
      background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.4);
      color: #6ee7b7; padding: 14px 18px; border-radius: 10px; margin-bottom: 24px; font-size: 14px;
    }

    /* Standard Form Controls */
    .card {
      background: var(--bg-card); border: 1px solid var(--border-color);
      border-radius: 14px; padding: 24px; margin-bottom: 24px;
    }
    .card-title { font-family: 'Outfit', sans-serif; font-size: 18px; font-weight: 700; margin-bottom: 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px; }
    .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
    .form-group { margin-bottom: 18px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: #cbd5e1; margin-bottom: 6px; }
    .form-control {
      width: 100%; padding: 11px 14px; background: #1e293b;
      border: 1px solid #334155; border-radius: 8px; color: #fff;
      font-size: 14px; outline: none; transition: border-color 0.2s;
    }
    .form-control:focus { border-color: var(--accent); }
    textarea.form-control { min-height: 90px; resize: vertical; }

    .btn-save {
      padding: 12px 24px; background: linear-gradient(135deg, var(--accent), var(--accent-blue));
      border: none; border-radius: 8px; color: #05070a; font-size: 14px; font-weight: 700;
      cursor: pointer; transition: opacity 0.2s, transform 0.1s; display: inline-flex; align-items: center; gap: 8px;
    }
    .btn-save:hover { opacity: 0.95; transform: translateY(-1px); }
    
    .btn-danger {
      padding: 8px 14px; background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3);
      color: #fca5a5; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: none;
    }
    .btn-danger:hover { background: rgba(239, 68, 68, 0.3); }

    /* Tables */
    .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    table { width: 100%; border-collapse: collapse; text-align: left; }
    th { padding: 12px 16px; background: #1e293b; color: var(--text-dim); font-size: 12px; font-weight: 700; text-transform: uppercase; border-bottom: 1px solid var(--border-color); white-space: nowrap; }
    td { padding: 14px 16px; border-bottom: 1px solid var(--border-color); font-size: 14px; vertical-align: middle; }
    tr:hover td { background: rgba(255, 255, 255, 0.02); }

    /* Mobile Responsive Sidebar & Layout */
    .mobile-nav-toggle {
      display: none;
      background: rgba(0, 242, 254, 0.12);
      border: 1px solid rgba(0, 242, 254, 0.3);
      color: var(--accent);
      width: 42px;
      height: 42px;
      border-radius: 10px;
      font-size: 18px;
      cursor: pointer;
      align-items: center;
      justify-content: center;
      transition: background 0.2s;
    }
    .mobile-nav-toggle:hover { background: rgba(0, 242, 254, 0.25); }
    
    .sidebar-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(5, 7, 10, 0.8);
      backdrop-filter: blur(4px);
      z-index: 90;
    }

    @media (max-width: 992px) {
      .admin-sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 0 50px rgba(0, 0, 0, 0.8);
      }
      .admin-sidebar.active {
        transform: translateX(0);
      }
      .sidebar-overlay.active {
        display: block;
      }
      .admin-main {
        margin-left: 0;
        padding: 20px 16px;
      }
      .mobile-nav-toggle {
        display: flex;
      }
      .top-bar {
        gap: 16px;
        flex-wrap: wrap;
      }
    }

    /* Mobile Table-to-Card Responsive Transformation */
    @media (max-width: 768px) {
      .table-to-cards thead {
        display: none;
      }
      .table-to-cards,
      .table-to-cards tbody,
      .table-to-cards tr,
      .table-to-cards td {
        display: block;
        width: 100%;
      }
      .table-to-cards tr {
        background: #111827;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 14px;
        padding: 16px;
        margin-bottom: 16px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
      }
      .table-to-cards td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        font-size: 13px;
        text-align: right;
      }
      .table-to-cards td:last-child {
        border-bottom: none;
        padding-bottom: 0;
        margin-top: 10px;
        justify-content: flex-end;
        gap: 10px;
      }
      .table-to-cards td::before {
        content: attr(data-label);
        font-weight: 700;
        color: var(--text-dim);
        font-size: 12px;
        text-transform: uppercase;
        text-align: left;
        padding-right: 12px;
        flex-shrink: 0;
      }
    }

    @media (max-width: 576px) {
      .page-title h1 { font-size: 20px; }
      .page-title p { font-size: 12px; }
      .card { padding: 16px; }
      .form-grid { grid-template-columns: 1fr; }
      .view-site-btn { padding: 8px 12px; font-size: 12px; }
      .btn-save { width: 100%; justify-content: center; }
    }
  </style>
</head>
<body>

  <!-- Mobile Sidebar Overlay -->
  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <!-- Sidebar Navigation -->
  <aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-header">
      <div class="logo-box">SJ</div>
      <div class="brand-name">Sahashra <span>Admin</span></div>
    </div>

    <ul class="sidebar-menu">
      <div class="menu-label">Main Menu</div>
      <li>
        <a href="index.php" class="menu-link <?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">
          <i class="fa-solid fa-gauge-high"></i> Dashboard
        </a>
      </li>
      <li>
        <a href="hero.php" class="menu-link <?php echo $currentPage === 'hero.php' ? 'active' : ''; ?>">
          <i class="fa-solid fa-user-pen"></i> Hero & Profile
        </a>
      </li>
      <li>
        <a href="projects.php" class="menu-link <?php echo $currentPage === 'projects.php' ? 'active' : ''; ?>">
          <i class="fa-solid fa-folder-open"></i> Projects Manager
        </a>
      </li>
      <li>
        <a href="skills.php" class="menu-link <?php echo $currentPage === 'skills.php' ? 'active' : ''; ?>">
          <i class="fa-solid fa-layer-group"></i> Skills Manager
        </a>
      </li>
      <li>
        <a href="messages.php" class="menu-link <?php echo $currentPage === 'messages.php' ? 'active' : ''; ?>">
          <i class="fa-solid fa-envelope"></i> Contact Inbox
          <?php if ($unreadCount > 0): ?>
            <span class="badge-count"><?php echo $unreadCount; ?></span>
          <?php endif; ?>
        </a>
      </li>

      <div class="menu-label">External Links</div>
      <li>
        <a href="../" target="_blank" class="menu-link">
          <i class="fa-solid fa-globe"></i> View Website
        </a>
      </li>
    </ul>

    <div class="sidebar-footer">
      <a href="logout.php" class="btn-logout">
        <i class="fa-solid fa-right-from-bracket"></i> Log Out
      </a>
    </div>
  </aside>

  <!-- Main Content Wrapper -->
  <main class="admin-main">
    <div class="top-bar">
      <div style="display:flex; align-items:center; gap:14px;">
        <button type="button" class="mobile-nav-toggle" id="mobileNavToggle" aria-label="Toggle Navigation">
          <i class="fa-solid fa-bars"></i>
        </button>
        <div class="page-title">
          <h1>Control Dashboard</h1>
          <p>Manage all portfolio details, projects, skills, and client inquiries</p>
        </div>
      </div>

      <a href="../" target="_blank" class="view-site-btn">
        <i class="fa-solid fa-arrow-up-right-from-square"></i> Open Live Site
      </a>
    </div>
