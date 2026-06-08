<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check authentication
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: /DonaMart/admin/login.php");
    exit;
}

// Active navigation helper
function isAdminActive($page, $current) {
    return $page === $current ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DonaMart Admin Panel</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom Admin Styles -->
    <style>
        :root {
            --primary-color: #1b4332;
            --primary-dark: #081c15;
            --accent-color: #b5835a;
            --bg-light: #f8f9fa;
        }
        body {
            background-color: var(--bg-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .admin-sidebar {
            min-height: 100vh;
            background-color: var(--primary-color);
            box-shadow: 2px 0 5px rgba(0,0,0,0.05);
        }
        .admin-sidebar .nav-link {
            color: rgba(255,255,255,0.75);
            padding: 12px 20px;
            font-weight: 500;
            border-radius: 5px;
            margin: 5px 10px;
            transition: all 0.2s;
        }
        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255,255,255,0.1);
        }
        .admin-sidebar .nav-link.active {
            background-color: var(--accent-color);
        }
        .navbar-brand {
            font-weight: 800;
            font-size: 1.4rem;
        }
        .card-stat {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
            transition: transform 0.2s;
        }
        .card-stat:hover {
            transform: translateY(-3px);
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block admin-sidebar collapse navbar-collapse d-flex flex-column p-0">
            <div class="w-100 py-4 px-3 text-center border-bottom border-secondary mb-3">
                <a class="navbar-brand d-flex align-items-center justify-content-center text-white text-decoration-none" href="/DonaMart/admin/index.php">
                    <span class="brand-logo me-2"><i class="fa-solid fa-leaf text-success"></i></span>
                    <span>Dona<span class="text-accent">Mart</span></span>
                </a>
                <span class="badge bg-secondary mt-2">Admin Portal</span>
            </div>
            
            <ul class="nav flex-column w-100 flex-grow-1">
                <li class="nav-item">
                    <a class="nav-link <?php echo isAdminActive('dashboard', $admin_page ?? ''); ?>" href="/DonaMart/admin/index.php">
                        <i class="fa-solid fa-gauge me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isAdminActive('products', $admin_page ?? ''); ?>" href="/DonaMart/admin/products.php">
                        <i class="fa-solid fa-boxes-stacked me-2"></i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isAdminActive('categories', $admin_page ?? ''); ?>" href="/DonaMart/admin/categories.php">
                        <i class="fa-solid fa-tags me-2"></i> Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isAdminActive('gallery', $admin_page ?? ''); ?>" href="/DonaMart/admin/gallery.php">
                        <i class="fa-solid fa-images me-2"></i> Gallery
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isAdminActive('enquiries', $admin_page ?? ''); ?>" href="/DonaMart/admin/enquiries.php">
                        <i class="fa-solid fa-envelope-open-text me-2"></i> Enquiries
                    </a>
                </li>
                <li class="nav-item mt-auto border-top border-secondary pt-3 mb-4">
                    <a class="nav-link text-danger" href="/DonaMart/admin/actions/logout.php">
                        <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content Area -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
