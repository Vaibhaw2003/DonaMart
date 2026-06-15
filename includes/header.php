<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Helper to determine active class
function isActive($page, $active_page) {
    return $page === $active_page ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . " - DonaMart" : "DonaMart - Premium Eco-Friendly Tableware Manufacturer"; ?></title>
    
    <!-- Meta tags for SEO -->
    <meta name="description" content="<?php echo isset($meta_desc) ? $meta_desc : "DonaMart is a leading manufacturer of premium eco-friendly Dona, Pattal, Areca leaf plates, biodegradable bowls, and compartment plates."; ?>">
    <meta name="keywords" content="Eco-friendly plates, Dona manufacture, Pattal manufacturer, Areca leaf tableware, biodegradable bowls, DonaMart, disposable compartment plates">
    <meta name="author" content="DonaMart">
    
    <!-- Google Fonts - Outfit and Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS CSS (Animate on Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/DonaMart/assets/css/style.css">
</head>
<body>

    <!-- Top Info Bar -->
    <div class="top-bar d-none d-lg-block">
        <div class="container d-flex justify-content-between align-items-center py-2">
            <div class="top-info text-white-50">
                <span class="me-3"><i class="fa-solid fa-phone text-accent me-1"></i> +91 8874812003</span>
                <span><i class="fa-solid fa-envelope text-accent me-1"></i>donamartvns@gmail.com</span>
            </div>
            <div class="top-socials">
                <a href="#" class="text-white-50 me-3"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="text-white-50 me-3"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="text-white-50 me-3"><i class="fa-brands fa-linkedin-in"></i></a>
                <a href="#" class="text-white-50"><i class="fa-brands fa-twitter"></i></a>
            </div>
        </div>
    </div>

    <!-- Navigation Header -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/DonaMart/index.php">
                <span class="brand-logo me-2"><i class="fa-solid fa-leaf text-success"></i></span>
                <span class="brand-text">Dona<span class="text-accent">Mart</span></span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link <?php echo isActive('home', $active_page ?? ''); ?>" href="/DonaMart/index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo isActive('about', $active_page ?? ''); ?>" href="/DonaMart/about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo isActive('products', $active_page ?? ''); ?>" href="/DonaMart/products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo isActive('gallery', $active_page ?? ''); ?>" href="/DonaMart/gallery.php">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo isActive('bulk', $active_page ?? ''); ?>" href="/DonaMart/bulk-order.php">Bulk Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo isActive('contact', $active_page ?? ''); ?>" href="/DonaMart/contact.php">Contact Us</a>
                    </li>
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <a href="/DonaMart/bulk-order.php" class="btn btn-accent px-4 py-2 rounded-pill font-weight-bold shadow-sm">Get Quote</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
