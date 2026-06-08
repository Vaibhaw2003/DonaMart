<?php
$page_title = "Factory & Products Gallery";
$active_page = "gallery";
$meta_desc = "Take a virtual tour of DonaMart's manufacturing facility. See our sorting, pressing, quality checks, packaging, and final products gallery.";

require_once 'config/db.php';
require_once 'includes/header.php';

// Get active type filter
$type_filter = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';

try {
    $query = "SELECT * FROM gallery";
    $params = [];
    if (!empty($type_filter)) {
        $query .= " WHERE type = ?";
        $params[] = $type_filter;
    }
    $query .= " ORDER BY id DESC";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $gallery_items = $stmt->fetchAll();
} catch (PDOException $e) {
    $gallery_items = [];
}
?>

<!-- Header Banner -->
<section class="bg-primary-custom text-white py-5">
    <div class="container text-center py-4">
        <h1 class="text-white font-weight-bold mb-2">Our Facility & Products Gallery</h1>
        <p class="text-white-50 lead mb-0">Witness our clean manufacturing process and high quality finishes.</p>
    </div>
</section>

<!-- Gallery Section -->
<section class="py-5">
    <div class="container">
        <!-- Gallery Filters -->
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="d-inline-flex flex-wrap gap-2 bg-white p-2 rounded-pill shadow-sm border border-light">
                <a href="/DonaMart/gallery.php" class="btn btn-sm <?php echo empty($type_filter) ? 'btn-accent' : 'btn-outline-primary-custom'; ?> rounded-pill px-4 py-2 font-weight-bold">All Photos</a>
                <a href="/DonaMart/gallery.php?type=factory" class="btn btn-sm <?php echo ($type_filter === 'factory') ? 'btn-accent' : 'btn-outline-primary-custom'; ?> rounded-pill px-4 py-2 font-weight-bold">Factory</a>
                <a href="/DonaMart/gallery.php?type=process" class="btn btn-sm <?php echo ($type_filter === 'process') ? 'btn-accent' : 'btn-outline-primary-custom'; ?> rounded-pill px-4 py-2 font-weight-bold">Manufacturing Process</a>
                <a href="/DonaMart/gallery.php?type=product" class="btn btn-sm <?php echo ($type_filter === 'product') ? 'btn-accent' : 'btn-outline-primary-custom'; ?> rounded-pill px-4 py-2 font-weight-bold">Finished Products</a>
            </div>
        </div>

        <!-- Masonry Grid -->
        <div class="gallery-grid" data-aos="fade-up">
            <?php if (!empty($gallery_items)): ?>
                <?php foreach ($gallery_items as $item): ?>
                    <div class="gallery-item">
                        <img src="/DonaMart/uploads/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['caption']); ?>" class="img-fluid">
                        <div class="p-3 bg-white border-top">
                            <h5 class="h6 font-weight-bold text-primary-dark mb-1"><?php echo htmlspecialchars($item['caption'] ?: 'DonaMart Production'); ?></h5>
                            <span class="badge bg-light text-success text-capitalize text-xs font-weight-bold"><?php echo htmlspecialchars($item['type']); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No images found in this gallery category.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
