<?php
require_once 'config/db.php';

$slug = filter_input(INPUT_GET, 'slug', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';

if (empty($slug)) {
    header("Location: /DonaMart/products.php");
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.slug = ? AND p.status = 1");
    $stmt->execute([$slug]);
    $product = $stmt->fetch();
} catch (PDOException $e) {
    $product = null;
}

if (!$product) {
    $page_title = "Product Not Found";
    require_once 'includes/header.php';
    echo '<div class="container py-5 text-center my-5"><h2 class="mb-3">Product Not Found</h2><a href="/DonaMart/products.php" class="btn btn-accent rounded-pill">Back to Products</a></div>';
    require_once 'includes/footer.php';
    exit;
}

$page_title  = $product['name'] . " - Eco Tableware Spec";
$active_page = "products";
$meta_desc   = htmlspecialchars(substr($product['description'], 0, 150));

require_once 'includes/header.php';

try {
    $rel_stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ? AND id != ? AND status = 1 LIMIT 3");
    $rel_stmt->execute([$product['category_id'], $product['id']]);
    $related_products = $rel_stmt->fetchAll();
} catch (PDOException $e) {
    $related_products = [];
}
?>

<!-- Header Banner -->
<section class="bg-primary-custom text-white py-5">
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="/DonaMart/index.php" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="/DonaMart/products.php" class="text-white-50 text-decoration-none">Products</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?= htmlspecialchars($product['name']) ?></li>
            </ol>
        </nav>
        <h1 class="text-white font-weight-bold mb-0"><?= htmlspecialchars($product['name']) ?></h1>
    </div>
</section>

<!-- Product Details Section -->
<section class="py-5">
    <div class="container py-4">
        <div class="row g-5">
            <!-- Product Image -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="p-3 bg-white rounded-custom shadow-sm border border-light text-center">
                    <img src="/DonaMart/uploads/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-fluid rounded-4">
                </div>
            </div>

            <!-- Product Specs & CTAs -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="product-info-panel">
                    <span class="badge bg-success mb-3 px-3 py-2 text-uppercase font-weight-bold"><?= htmlspecialchars($product['category_name']) ?></span>
                    <h2 class="font-weight-bold mb-3"><?= htmlspecialchars($product['name']) ?></h2>
                    <p class="text-muted mb-4 lead"><?= htmlspecialchars($product['description']) ?></p>

                    <h4 class="h5 font-weight-bold text-primary-dark border-bottom pb-2 mb-3">Technical Specifications</h4>

                    <table class="table table-striped spec-table-large">
                        <tr><td class="font-weight-bold text-muted w-40">Available Sizes:</td><td class="text-dark font-weight-bold"><?= htmlspecialchars($product['sizes']) ?></td></tr>
                        <tr><td class="font-weight-bold text-muted">Raw Material:</td><td class="text-dark font-weight-bold"><?= htmlspecialchars($product['material']) ?></td></tr>
                        <tr><td class="font-weight-bold text-muted">Minimum Order Qty (MOQ):</td><td class="text-dark font-weight-bold"><?= number_format($product['moq']) ?> pieces</td></tr>
                        <tr><td class="font-weight-bold text-muted">Biodegradability:</td><td class="text-success font-weight-bold">100% Compostable (within 60-90 days)</td></tr>
                        <tr><td class="font-weight-bold text-muted">Heat Resistance:</td><td class="text-dark font-weight-bold">Safe up to 220°C (Microwave & Oven Safe)</td></tr>
                        <tr><td class="font-weight-bold text-muted">Chemical Treatment:</td><td class="text-dark font-weight-bold">Zero Chemicals, Dyes, or Lacquers Used</td></tr>
                    </table>

                    <div class="d-flex flex-column flex-sm-row gap-3 mt-4">
                        <a href="/DonaMart/bulk-order.php?product=<?= urlencode($product['name']) ?>"
                           class="btn btn-accent btn-lg px-5 py-3 rounded-pill font-weight-bold shadow-md">
                            Request Wholesale Quote
                        </a>
                        <a href="https://wa.me/918874812003?text=Hi%20DonaMart,%20I'm%20interested%20in:%20<?= urlencode($product['name']) ?>"
                           target="_blank" rel="noopener"
                           class="btn btn-whatsapp btn-lg px-5 py-3 rounded-pill font-weight-bold">
                            <i class="fa-brands fa-whatsapp me-2"></i> WhatsApp Order
                        </a>
                    </div>

                    <!-- PDF Download — JavaScript-driven, bypasses any overlay issue -->
                    <div class="mt-4 pt-3 border-top text-center text-sm-start">
                        <button type="button"
                           onclick="window.location.href='/DonaMart/actions/download_catalogue.php'"
                           style="background:var(--tan-light,#f0e6d9);color:var(--accent-color,#b5835a);
                                  border:none;font-weight:700;padding:10px 18px;border-radius:50px;
                                  cursor:pointer;font-size:14px;display:inline-flex;align-items:center;gap:8px;
                                  font-family:inherit;">
                            <i class="fa-solid fa-file-pdf"></i> Download Product Catalogue PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <?php if (!empty($related_products)): ?>
            <div class="row mt-5 pt-5" data-aos="fade-up">
                <div class="col-12 mb-4">
                    <h3 class="font-weight-bold text-primary-dark">Related Products</h3>
                    <div class="bg-accent-custom mt-2" style="width: 50px; height: 3px;"></div>
                </div>
                <?php foreach ($related_products as $rp): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="product-card">
                            <div class="product-img-wrapper">
                                <img src="/DonaMart/uploads/<?= htmlspecialchars($rp['image']) ?>" alt="<?= htmlspecialchars($rp['name']) ?>">
                            </div>
                            <div class="product-details">
                                <h4 class="h5 mb-2 font-weight-bold text-primary-dark"><?= htmlspecialchars($rp['name']) ?></h4>
                                <p class="text-muted text-sm mb-3"><?= htmlspecialchars(substr($rp['description'], 0, 80)) ?>...</p>
                                <div class="product-actions d-grid gap-2">
                                    <a href="/DonaMart/product-details.php?slug=<?= urlencode($rp['slug']) ?>" class="btn btn-outline-primary-custom rounded-pill btn-sm font-weight-bold">View Specs</a>
                                    <a href="/DonaMart/bulk-order.php?product=<?= urlencode($rp['name']) ?>" class="btn btn-accent rounded-pill btn-sm font-weight-bold">Get Price</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>