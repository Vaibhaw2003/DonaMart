<?php
// admin/includes/header.php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: /DonaMart/admin/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DonaMart Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --forest:      #1b4332;
            --forest-dark: #0f2b1f;
            --forest-mid:  #2d6a4f;
            --forest-light:#52b788;
            --tan:         #b5835a;
            --tan-light:   #f0e6d9;
            --cream:       #fcfaf5;
            --sidebar-w:   230px;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--cream);
            font-size: 14px;
            color: #1a1a1a;
        }

        /* ── Layout ── */
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            min-width: var(--sidebar-w);
            background: var(--forest-dark);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            z-index: 1000;
            transition: transform 0.25s ease;
        }

        .sidebar-brand {
            padding: 20px 16px 18px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .brand-icon {
            width: 36px; height: 36px;
            background: var(--forest-mid);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            color: var(--forest-light);
            font-size: 17px;
            flex-shrink: 0;
        }
        .brand-name  { font-size: 15px; font-weight: 600; color: #fff; }
        .brand-label { font-size: 10px; color: rgba(255,255,255,0.35); letter-spacing: 0.09em; text-transform: uppercase; margin-top: 1px; }

        .nav-section-label {
            padding: 16px 18px 4px;
            font-size: 10px;
            color: rgba(255,255,255,0.28);
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .nav-link-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 18px;
            color: rgba(255,255,255,0.55);
            font-size: 13px;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: background 0.15s, color 0.15s, border-color 0.15s;
        }
        .nav-link-item:hover {
            background: rgba(255,255,255,0.06);
            color: rgba(255,255,255,0.9);
        }
        .nav-link-item.active {
            background: rgba(181,131,90,0.15);
            color: #e9c99b;
            border-left-color: var(--tan);
        }
        .nav-link-item i {
            font-size: 15px;
            width: 18px;
            text-align: center;
            flex-shrink: 0;
        }
        .nav-badge {
            margin-left: auto;
            background: rgba(181,131,90,0.28);
            color: #e9c99b;
            font-size: 10px;
            padding: 2px 7px;
            border-radius: 10px;
            font-weight: 600;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 10px 8px;
            border-top: 1px solid rgba(255,255,255,0.07);
        }
        .logout-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 16px;
            color: rgba(220,80,80,0.75);
            font-size: 13px;
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.15s, color 0.15s;
        }
        .logout-link:hover {
            background: rgba(255,80,80,0.1);
            color: #ff6b6b;
        }
        .logout-link i { font-size: 15px; width: 18px; text-align: center; }

        /* ── Main area ── */
        .main-wrap {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ── Top bar ── */
        .topbar {
            height: 56px;
            background: #fff;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 12px;
            position: sticky;
            top: 0;
            z-index: 900;
        }
        .topbar-title {
            font-size: 15px;
            font-weight: 600;
            color: #111;
        }
        .topbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .topbar-greeting {
            font-size: 12px;
            color: #888;
        }
        .topbar-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: var(--forest-mid);
            color: #fff;
            font-size: 11px;
            font-weight: 600;
            display: flex; align-items: center; justify-content: center;
        }
        .topbar-divider {
            width: 1px; height: 20px;
            background: #e8e8e8;
        }
        .site-link {
            font-size: 12px;
            color: var(--forest-mid);
            text-decoration: none;
            display: flex; align-items: center; gap: 4px;
        }
        .site-link:hover { color: var(--forest); text-decoration: underline; }

        /* ── Page content wrapper ── */
        .page-content {
            padding: 24px 28px;
            flex: 1;
        }

        /* ── Reusable card ── */
        .dm-card {
            background: #fff;
            border: 1px solid #ececec;
            border-radius: 12px;
        }

        /* ── Stat cards ── */
        .stat-card {
            background: #fff;
            border: 1px solid #ececec;
            border-radius: 12px;
            padding: 16px 18px;
        }
        .stat-icon-wrap {
            width: 40px; height: 40px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            margin-bottom: 12px;
        }
        .si-green  { background: #eaf3de; color: #3b6d11; }
        .si-teal   { background: #e1f5ee; color: #0f6e56; }
        .si-amber  { background: #faeeda; color: #854f0b; }
        .si-red    { background: #fcebeb; color: #a32d2d; }
        .si-blue   { background: #e6f1fb; color: #185fa5; }

        .stat-label { font-size: 11px; color: #999; text-transform: uppercase; letter-spacing: 0.07em; margin-bottom: 3px; }
        .stat-value { font-size: 28px; font-weight: 700; color: #111; line-height: 1; }
        .stat-sub   { font-size: 11px; color: #aaa; margin-top: 5px; }

        /* ── Tables ── */
        .dm-table { width: 100%; border-collapse: collapse; }
        .dm-table th {
            background: #f8f8f6;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #888;
            padding: 11px 14px;
            border-bottom: 1px solid #ececec;
            white-space: nowrap;
        }
        .dm-table td {
            padding: 11px 14px;
            border-bottom: 1px solid #f4f4f4;
            font-size: 13px;
            color: #222;
            vertical-align: middle;
        }
        .dm-table tr:last-child td { border-bottom: none; }
        .dm-table tbody tr:hover { background: #fafafa; }

        /* ── Badges ── */
        .dm-badge {
            display: inline-flex; align-items: center;
            padding: 3px 9px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 600;
        }
        .badge-success  { background: #eaf3de; color: #3b6d11; }
        .badge-warning  { background: #faeeda; color: #854f0b; }
        .badge-danger   { background: #fcebeb; color: #a32d2d; }
        .badge-info     { background: #e6f1fb; color: #185fa5; }
        .badge-dark     { background: #ebebeb; color: #333; }
        .badge-secondary{ background: #f0f0f0; color: #666; }

        /* ── Buttons ── */
        .btn-forest {
            background: var(--forest);
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.15s;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-forest:hover { background: var(--forest-mid); color: #fff; }

        .btn-outline-forest {
            background: transparent;
            color: var(--forest);
            border: 1px solid var(--forest);
            padding: 7px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.15s;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-outline-forest:hover { background: var(--forest); color: #fff; }

        /* ── Modal header override ── */
        .modal-header.dm-modal-head {
            background: var(--forest);
            color: #fff;
        }
        .modal-header.dm-modal-head .btn-close { filter: invert(1); }

        /* ── Alert ── */
        .dm-alert {
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 13px;
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 16px;
        }
        .dm-alert-success { background: #eaf3de; color: #3b6d11; border: 1px solid #c0dd97; }
        .dm-alert-danger  { background: #fcebeb; color: #a32d2d; border: 1px solid #f7c1c1; }

        /* ── Mobile toggle ── */
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            color: #333;
            cursor: pointer;
            padding: 0;
            margin-right: 4px;
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrap { margin-left: 0; }
            .sidebar-toggle { display: block; }
            .page-content { padding: 16px; }
            .topbar { padding: 0 16px; }
        }

        /* ── Page header ── */
        .page-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
            padding-bottom: 16px;
            border-bottom: 1px solid #ececec;
        }
        .page-header-title { font-size: 20px; font-weight: 700; color: #111; }
    </style>
</head>
<body>

<div class="admin-layout">

<!-- ── Sidebar ── -->
<aside class="sidebar" id="sidebar">
    <a class="sidebar-brand" href="/DonaMart/admin/index.php">
        <div class="brand-icon"><i class="fa-solid fa-leaf"></i></div>
        <div>
            <div class="brand-name">DonaMart</div>
            <div class="brand-label">Admin Portal</div>
        </div>
    </a>

    <div class="nav-section-label">Main</div>

    <a href="/DonaMart/admin/index.php"
       class="nav-link-item <?= ($admin_page === 'dashboard') ? 'active' : '' ?>">
        <i class="fa-solid fa-gauge-high"></i> Dashboard
    </a>

    <a href="/DonaMart/admin/products.php"
       class="nav-link-item <?= ($admin_page === 'products') ? 'active' : '' ?>">
        <i class="fa-solid fa-boxes-stacked"></i> Products
    </a>

    <a href="/DonaMart/admin/categories.php"
       class="nav-link-item <?= ($admin_page === 'categories') ? 'active' : '' ?>">
        <i class="fa-solid fa-tags"></i> Categories
    </a>

    <a href="/DonaMart/admin/gallery.php"
       class="nav-link-item <?= ($admin_page === 'gallery') ? 'active' : '' ?>">
        <i class="fa-solid fa-images"></i> Gallery
    </a>

    <a href="/DonaMart/admin/enquiries.php"
       class="nav-link-item <?= ($admin_page === 'enquiries') ? 'active' : '' ?>">
        <i class="fa-solid fa-envelope-open-text"></i> Enquiries
        <?php
        // Show pending badge
        try {
            global $pdo;
            $pending = $pdo->query("SELECT COUNT(*) FROM bulk_enquiries WHERE status='pending'")->fetchColumn();
            if ($pending > 0) echo '<span class="nav-badge">' . $pending . '</span>';
        } catch(Exception $e) {}
        ?>
    </a>

    <div class="sidebar-footer">
        <a href="/DonaMart/admin/logout.php" class="logout-link">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </div>
</aside>

<!-- ── Main Wrapper ── -->
<div class="main-wrap">

    <!-- Top bar -->
    <header class="topbar">
        <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle menu">
            <i class="fa-solid fa-bars"></i>
        </button>
        <i class="fa-solid fa-leaf" style="color:var(--forest-mid);font-size:16px;"></i>
        <span class="topbar-title">
            <?php
            $titles = [
                'dashboard'  => 'Dashboard',
                'products'   => 'Products',
                'categories' => 'Categories',
                'gallery'    => 'Gallery',
                'enquiries'  => 'Enquiries & Messages',
            ];
            echo $titles[$admin_page] ?? 'Admin';
            ?>
        </span>
        <div class="topbar-right">
            <a href="/DonaMart/index.php" class="site-link" target="_blank">
                <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:11px;"></i>
                View Site
            </a>
            <div class="topbar-divider"></div>
            <span class="topbar-greeting">
                <?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?>
            </span>
            <div class="topbar-avatar">
                <?= strtoupper(substr($_SESSION['admin_username'] ?? 'A', 0, 2)) ?>
            </div>
        </div>
    </header>

    <!-- Page content starts here -->
    <main class="page-content">