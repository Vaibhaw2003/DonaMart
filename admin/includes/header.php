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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}
:root{
  --forest:#1b4332;
  --forest-dark:#0f2b1f;
  --forest-mid:#2d6a4f;
  --forest-light:#52b788;
  --tan:#b5835a;
  --tan-light:#f0e6d9;
  --cream:#fcfaf5;
  --sw:220px;
  --topbar-h:52px;
}
html,body{height:100%;overflow:hidden}
body{font-family:'Segoe UI',system-ui,sans-serif;font-size:14px;background:#f5f5f2;color:#1a1a1a;-webkit-font-smoothing:antialiased}

/* ── Layout ── */
.admin-layout{display:flex;height:100vh;overflow:hidden}

/* ── Sidebar ── */
.sidebar{
  width:var(--sw);min-width:var(--sw);
  background:var(--forest-dark);
  display:flex;flex-direction:column;
  height:100vh;
  position:fixed;top:0;left:0;
  z-index:200;
  transition:transform 0.25s ease;
  overflow-y:auto;
  overflow-x:hidden;
}
.sb-brand{
  padding:18px 16px;
  border-bottom:1px solid rgba(255,255,255,0.07);
  display:flex;align-items:center;gap:10px;
  text-decoration:none;flex-shrink:0;
}
.sb-leaf{
  width:34px;height:34px;
  background:var(--forest-mid);border-radius:8px;
  display:flex;align-items:center;justify-content:center;
  color:var(--forest-light);font-size:16px;flex-shrink:0;
}
.sb-name{font-size:15px;font-weight:600;color:#fff;display:block}
.sb-sub{font-size:10px;color:rgba(255,255,255,0.35);letter-spacing:0.08em;text-transform:uppercase;margin-top:1px}
.sb-section{
  padding:14px 18px 4px;
  font-size:10px;color:rgba(255,255,255,0.28);
  letter-spacing:0.1em;text-transform:uppercase;
}
.sb-item{
  display:flex;align-items:center;gap:10px;
  padding:9px 18px;
  color:rgba(255,255,255,0.55);font-size:13px;
  text-decoration:none;
  border-left:3px solid transparent;
  transition:background 0.15s,color 0.15s,border-color 0.15s;
  white-space:nowrap;
}
.sb-item:hover{background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.9)}
.sb-item.active{background:rgba(181,131,90,0.15);color:#e9c99b;border-left-color:var(--tan)}
.sb-item i{font-size:15px;width:18px;text-align:center;flex-shrink:0}
.sb-badge{
  margin-left:auto;
  background:rgba(181,131,90,0.28);color:#e9c99b;
  font-size:10px;padding:2px 7px;border-radius:10px;font-weight:600;
}
.sb-footer{
  margin-top:auto;padding:10px 8px;
  border-top:1px solid rgba(255,255,255,0.07);
}
.sb-logout{
  display:flex;align-items:center;gap:10px;
  padding:9px 16px;
  color:rgba(220,80,80,0.7);font-size:13px;
  text-decoration:none;border-radius:8px;
  transition:background 0.15s,color 0.15s;
}
.sb-logout:hover{background:rgba(255,80,80,0.1);color:#ff6b6b}
.sb-logout i{font-size:15px;width:18px;text-align:center}

/* ── Main wrapper ── */
.main-wrap{
  margin-left:var(--sw);
  flex:1;
  display:flex;flex-direction:column;
  height:100vh;
  overflow:hidden;
}

/* ── Topbar ── */
.topbar{
  height:var(--topbar-h);
  background:#fff;
  border-bottom:1px solid #eee;
  display:flex;align-items:center;
  padding:0 20px;gap:10px;
  flex-shrink:0;
  z-index:100;
}
.tb-title{font-size:14px;font-weight:600;color:#111}
.tb-right{margin-left:auto;display:flex;align-items:center;gap:12px}
.tb-greeting{font-size:12px;color:#999}
.tb-divider{width:1px;height:18px;background:#eee}
.tb-avatar{
  width:30px;height:30px;border-radius:50%;
  background:var(--forest-mid);color:#fff;
  font-size:11px;font-weight:600;
  display:flex;align-items:center;justify-content:center;
}
.tb-site-link{
  font-size:12px;color:var(--forest-mid);text-decoration:none;
  display:flex;align-items:center;gap:4px;
}
.tb-site-link:hover{color:var(--forest);text-decoration:underline}
.tb-cta{
  background:var(--forest);color:#fff;border:none;
  padding:6px 14px;border-radius:6px;font-size:12px;font-weight:600;
  cursor:pointer;display:flex;align-items:center;gap:5px;
  font-family:inherit;transition:background 0.15s;text-decoration:none;
}
.tb-cta:hover{background:var(--forest-mid);color:#fff}

/* Mobile toggle */
.sb-toggle{
  display:none;background:none;border:1px solid #e5e5e5;
  border-radius:7px;width:36px;height:36px;
  align-items:center;justify-content:center;
  cursor:pointer;color:#555;font-size:16px;flex-shrink:0;
}

/* ── Page content ── */
.page-content{
  flex:1;overflow-y:auto;
  padding:22px 24px;
  background:#f5f5f2;
}

/* ── Page header ── */
.page-header-row{
  display:flex;align-items:center;justify-content:space-between;
  margin-bottom:20px;padding-bottom:16px;
  border-bottom:1px solid #e8e8e8;
}
.page-header-title{font-size:18px;font-weight:700;color:#111}

/* ── Stat cards ── */
.stat-card{
  background:#fff;border:1px solid #eee;
  border-radius:12px;padding:16px 18px;
}
.stat-icon-wrap{
  width:38px;height:38px;border-radius:9px;
  display:flex;align-items:center;justify-content:center;
  font-size:18px;margin-bottom:11px;
}
.si-green{background:#eaf3de;color:#3b6d11}
.si-teal {background:#e1f5ee;color:#0f6e56}
.si-amber{background:#faeeda;color:#854f0b}
.si-red  {background:#fcebeb;color:#a32d2d}
.si-blue {background:#e6f1fb;color:#185fa5}
.stat-label{font-size:10px;color:#999;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:3px}
.stat-value{font-size:26px;font-weight:700;color:#111;line-height:1}
.stat-sub  {font-size:11px;color:#aaa;margin-top:5px}

/* ── Cards ── */
.dm-card{background:#fff;border:1px solid #eee;border-radius:12px;overflow:hidden}

/* ── Tables ── */
.dm-table{width:100%;border-collapse:collapse}
.dm-table th{
  background:#fafaf8;font-size:10px;font-weight:700;
  text-transform:uppercase;letter-spacing:0.07em;color:#999;
  padding:10px 14px;border-bottom:1px solid #eee;white-space:nowrap;
}
.dm-table td{
  padding:10px 14px;border-bottom:1px solid #f5f5f5;
  font-size:13px;color:#222;vertical-align:middle;
}
.dm-table tbody tr:last-child td{border-bottom:none}
.dm-table tbody tr:hover{background:#fafaf8}

/* ── Badges ── */
.dm-badge{display:inline-flex;align-items:center;padding:3px 9px;border-radius:5px;font-size:11px;font-weight:600}
.badge-success {background:#eaf3de;color:#3b6d11}
.badge-warning {background:#faeeda;color:#854f0b}
.badge-danger  {background:#fcebeb;color:#a32d2d}
.badge-info    {background:#e6f1fb;color:#185fa5}
.badge-dark    {background:#ebebeb;color:#333}
.badge-secondary{background:#f0f0f0;color:#666}

/* ── Buttons ── */
.btn-forest{
  background:var(--forest);color:#fff;border:none;
  padding:8px 18px;border-radius:8px;font-size:13px;font-weight:600;
  cursor:pointer;transition:background 0.15s;
  display:inline-flex;align-items:center;gap:6px;text-decoration:none;
  font-family:inherit;
}
.btn-forest:hover{background:var(--forest-mid);color:#fff}
.btn-outline-forest{
  background:transparent;color:var(--forest);
  border:1.5px solid var(--forest);
  padding:6px 14px;border-radius:8px;font-size:12px;font-weight:600;
  cursor:pointer;transition:all 0.15s;
  display:inline-flex;align-items:center;gap:5px;text-decoration:none;
  font-family:inherit;
}
.btn-outline-forest:hover{background:var(--forest);color:#fff}

/* ── Modal ── */
.modal-header.dm-modal-head{background:var(--forest);color:#fff}
.modal-header.dm-modal-head .btn-close{filter:invert(1)}

/* ── Alerts ── */
.dm-alert{
  padding:11px 16px;border-radius:9px;font-size:13px;
  display:flex;align-items:center;gap:9px;margin-bottom:16px;
}
.dm-alert-success{background:#eaf3de;color:#3b6d11;border:1px solid #c3e6a0}
.dm-alert-danger {background:#fcebeb;color:#a32d2d;border:1px solid #f7c1c1}

/* ── Forms ── */
.form-control,.form-select{
  border:1.5px solid #e5e5e5;background:#fafaf8;
  font-size:13px;border-radius:8px !important;
  padding:9px 14px;height:auto;
  transition:border-color 0.2s,box-shadow 0.2s;
}
.form-control:focus,.form-select:focus{
  border-color:var(--forest-mid);
  box-shadow:0 0 0 3px rgba(45,106,79,0.1);
  background:#fff;
}
.form-label{font-size:12px;font-weight:600;color:#555;margin-bottom:5px}

/* ── Responsive ── */
@media(max-width:768px){
  .sidebar{transform:translateX(-100%)}
  .sidebar.open{transform:translateX(0)}
  .main-wrap{margin-left:0}
  .sb-toggle{display:flex}
  .page-content{padding:14px}
}
</style>
</head>
<body>
<div class="admin-layout">

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
  <a class="sb-brand" href="/DonaMart/admin/index.php">
    <div class="sb-leaf"><i class="fa-solid fa-leaf"></i></div>
    <div>
      <span class="sb-name">DonaMart</span>
      <span class="sb-sub">Admin Portal</span>
    </div>
  </a>

  <div class="sb-section">Main</div>

  <a href="/DonaMart/admin/index.php"
     class="sb-item <?= ($admin_page==='dashboard') ? 'active' : '' ?>">
    <i class="fa-solid fa-gauge-high"></i> Dashboard
  </a>

  <a href="/DonaMart/admin/products.php"
     class="sb-item <?= ($admin_page==='products') ? 'active' : '' ?>">
    <i class="fa-solid fa-boxes-stacked"></i> Products
  </a>

  <a href="/DonaMart/admin/categories.php"
     class="sb-item <?= ($admin_page==='categories') ? 'active' : '' ?>">
    <i class="fa-solid fa-tags"></i> Categories
  </a>

  <a href="/DonaMart/admin/gallery.php"
     class="sb-item <?= ($admin_page==='gallery') ? 'active' : '' ?>">
    <i class="fa-solid fa-images"></i> Gallery
  </a>

  <a href="/DonaMart/admin/enquiries.php"
     class="sb-item <?= ($admin_page==='enquiries') ? 'active' : '' ?>">
    <i class="fa-solid fa-envelope-open-text"></i> Enquiries
    <?php
      try {
        global $pdo;
        $pending = $pdo->query("SELECT COUNT(*) FROM bulk_enquiries WHERE status='pending'")->fetchColumn();
        if ($pending > 0) echo '<span class="sb-badge">'.$pending.'</span>';
      } catch(Exception $e){}
    ?>
  </a>

  <div class="sb-section">Account</div>

  <a href="/DonaMart/index.php" target="_blank"
     class="sb-item">
    <i class="fa-solid fa-arrow-up-right-from-square"></i> View Website
  </a>

  <div class="sb-footer">
    <a href="/DonaMart/admin/logout.php" class="sb-logout">
      <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>
  </div>
</aside>

<!-- MAIN -->
<div class="main-wrap">

  <!-- TOPBAR -->
  <header class="topbar">
    <button class="sb-toggle" id="sbToggle" aria-label="Menu">
      <i class="fa-solid fa-bars"></i>
    </button>
    <i class="fa-solid fa-leaf" style="color:var(--forest-mid);font-size:15px;"></i>
    <span class="tb-title">
      <?php
        $titles=['dashboard'=>'Dashboard','products'=>'Products',
                 'categories'=>'Categories','gallery'=>'Gallery','enquiries'=>'Enquiries & Messages'];
        echo $titles[$admin_page] ?? 'Admin';
      ?>
    </span>
    <div class="tb-right">
      <a href="/DonaMart/index.php" target="_blank" class="tb-site-link">
        <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:11px;"></i> View Site
      </a>
      <div class="tb-divider"></div>
      <span class="tb-greeting"><?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></span>
      <div class="tb-avatar"><?= strtoupper(substr($_SESSION['admin_username'] ?? 'A',0,2)) ?></div>
    </div>
  </header>

  <!-- PAGE CONTENT STARTS -->
  <main class="page-content">