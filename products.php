<?php
$page_title = "Our Eco-Friendly Tableware Products";
$active_page = "products";
$meta_desc = "Browse our full range of eco-friendly tableware, including Areca palm leaf plates, stitched Sal leaf Dona, Pattal, and compostable bowls.";

require_once 'config/db.php';
require_once 'includes/header.php';

// Fetch categories for filters
try {
    $cat_stmt = $pdo->query("SELECT * FROM categories ORDER BY id ASC");
    $categories = $cat_stmt->fetchAll();
} catch (PDOException $e) {
    $categories = [];
}

// Get filter and search parameters
$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
$cat_slug = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';

// Build products query
try {
    $query = "SELECT p.*, c.name as category_name, c.slug as category_slug 
              FROM products p 
              JOIN categories c ON p.category_id = c.id 
              WHERE p.status = 1";
    $params = [];
    
    if (!empty($search)) {
        $query .= " AND (p.name LIKE ? OR p.description LIKE ? OR p.material LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }
    
    if (!empty($cat_slug)) {
        $query .= " AND c.slug = ?";
        $params[] = $cat_slug;
    }
    
    $query .= " ORDER BY p.id DESC";
    
    $prod_stmt = $pdo->prepare($query);
    $prod_stmt->execute($params);
    $products = $prod_stmt->fetchAll();
} catch (PDOException $e) {
    $products = [];
}
?>

<!-- Header Banner -->
<section class="bg-primary-custom text-white py-5">
    <div class="container text-center py-4">
        <h1 class="text-white font-weight-bold mb-2">Our Eco Tableware Collection</h1>
        <p class="text-white-50 lead mb-0">Explore our sustainable, robust, and chemical-free products.</p>
    </div>
</section>

<!-- Search and Filter Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4 justify-content-between align-items-center mb-5">
            <!-- Category Filters -->
            <div class="col-lg-8" data-aos="fade-right">
                <div class="d-flex flex-wrap gap-2">
                    <a href="/DonaMart/products.php" class="btn btn-sm <?php echo empty($cat_slug) ? 'btn-accent' : 'btn-outline-primary-custom'; ?> rounded-pill px-4 py-2 font-weight-bold">All Products</a>
                    <?php foreach ($categories as $cat): ?>
                        <a href="/DonaMart/products.php?category=<?php echo $cat['slug']; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" 
                           class="btn btn-sm <?php echo ($cat_slug === $cat['slug']) ? 'btn-accent' : 'btn-outline-primary-custom'; ?> rounded-pill px-4 py-2 font-weight-bold">
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Search Bar -->
            <div class="col-lg-4 col-md-8 ms-auto" data-aos="fade-left">
                <form action="/DonaMart/products.php" method="GET" class="search-form">
                    <?php if (!empty($cat_slug)): ?>
                        <input type="hidden" name="category" value="<?php echo htmlspecialchars($cat_slug); ?>">
                    <?php endif; ?>
                    <div class="input-group bg-white shadow-sm rounded-pill overflow-hidden border border-light">
                        <input type="text" name="search" class="form-control border-0 px-4" placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>">
                        <button class="btn btn-accent px-4 border-0" type="submit" aria-label="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Product Listing Grid -->
        <div class="row g-4">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $p): ?>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="product-card">
                            <div class="product-img-wrapper">
                                <span class="product-badge"><?php echo htmlspecialchars($p['category_name']); ?></span>
                                <a href="/DonaMart/product-details.php?slug=<?php echo urlencode($p['slug']); ?>">
                                    <img src="/DonaMart/uploads/<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
                                </a>
                            </div>
                            <div class="product-details">
                                <h4 class="h5 mb-2 font-weight-bold text-primary-dark">
                                    <a href="/DonaMart/product-details.php?slug=<?php echo urlencode($p['slug']); ?>" class="text-decoration-none text-primary-dark hover-accent">
                                        <?php echo htmlspecialchars($p['name']); ?>
                                    </a>
                                </h4>
                                <p class="text-muted text-sm mb-3 flex-grow-1"><?php echo htmlspecialchars($p['description']); ?></p>
                                
                                <table class="table product-spec-table">
                                    <tr>
                                        <td>Available Sizes:</td>
                                        <td><?php echo htmlspecialchars($p['sizes']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Material:</td>
                                        <td><?php echo htmlspecialchars($p['material']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Min. Order Qty:</td>
                                        <td><?php echo htmlspecialchars($p['moq']); ?> pcs</td>
                                    </tr>
                                </table>
                                
                                <div class="product-actions d-grid gap-2">
                                    <a href="/DonaMart/bulk-order.php?product=<?php echo urlencode($p['name']); ?>" class="btn btn-accent rounded-pill font-weight-bold">Enquire Bulk Price</a>
                                    <a href="https://wa.me/919876543210?text=Hi%20DonaMart,%20I'm%20interested%20in%20your%20product:%20<?php echo urlencode($p['name']); ?>" target="_blank" class="btn btn-whatsapp rounded-pill font-weight-bold"><i class="fa-brands fa-whatsapp me-1"></i> WhatsApp Order</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <div class="py-5" data-aos="zoom-in">
                        <i class="fa-solid fa-leaf text-success fs-1 mb-3"></i>
                        <h3 class="mb-2">No Products Found</h3>
                        <p class="text-muted">We couldn't find any products matching your filters. Try checking other categories or clear search terms.</p>
                        <a href="/DonaMart/products.php" class="btn btn-accent rounded-pill px-4 mt-3">Reset Filters</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
