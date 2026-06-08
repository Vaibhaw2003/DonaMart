<?php
// admin/gallery.php
$admin_page = 'gallery';
require_once __DIR__ . '/../config/db.php';

$message = '';
$message_type = '';

// DELETE gallery image
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = intval($_GET['delete']);
    try {
        $stmt = $pdo->prepare("SELECT image FROM gallery WHERE id = ?");
        $stmt->execute([$id]);
        $img = $stmt->fetchColumn();
        $pdo->prepare("DELETE FROM gallery WHERE id = ?")->execute([$id]);
        if ($img && file_exists(__DIR__ . '/../uploads/' . $img)) {
            unlink(__DIR__ . '/../uploads/' . $img);
        }
        $message = 'Image deleted successfully!'; $message_type = 'success';
    } catch (PDOException $e) {
        $message = 'Error deleting image.'; $message_type = 'danger';
    }
}

// ADD gallery image
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $caption = trim(filter_input(INPUT_POST, 'caption', FILTER_SANITIZE_SPECIAL_CHARS));
    $type    = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_ext  = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed   = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($file_ext, $allowed)) {
            $image_name = 'gallery_' . time() . '.' . $file_ext;
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../uploads/' . $image_name);
            try {
                $pdo->prepare("INSERT INTO gallery (image, caption, type) VALUES (?, ?, ?)")->execute([$image_name, $caption, $type]);
                $message = 'Image uploaded successfully!'; $message_type = 'success';
            } catch (PDOException $e) {
                $message = 'Database error.'; $message_type = 'danger';
            }
        } else {
            $message = 'Invalid file type. Only JPG, PNG, WEBP allowed.'; $message_type = 'danger';
        }
    } else {
        $message = 'Please select a valid image file.'; $message_type = 'danger';
    }
}

$gallery_items = $pdo->query("SELECT * FROM gallery ORDER BY id DESC")->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 font-weight-bold">Gallery Management</h1>
    <button class="btn btn-success rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#galleryModal">
        <i class="fa-solid fa-upload me-2"></i> Upload Image
    </button>
</div>

<?php if ($message): ?>
<div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show">
    <?php echo $message; ?> <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- Gallery Grid -->
<div class="row g-3">
    <?php if (!empty($gallery_items)): ?>
        <?php foreach ($gallery_items as $g): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card border-0 rounded-4 shadow-sm overflow-hidden">
                    <img src="/DonaMart/uploads/<?php echo htmlspecialchars($g['image']); ?>" class="card-img-top" style="height:180px; object-fit:cover;" alt="<?php echo htmlspecialchars($g['caption']); ?>">
                    <div class="card-body p-2">
                        <p class="mb-1 text-sm fw-bold text-truncate"><?php echo htmlspecialchars($g['caption'] ?: '(no caption)'); ?></p>
                        <span class="badge bg-secondary text-capitalize text-xs"><?php echo htmlspecialchars($g['type']); ?></span>
                        <div class="mt-2 text-end">
                            <a href="?delete=<?php echo $g['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Delete this image?')">
                                <i class="fa-solid fa-trash"></i> Delete
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center py-5 text-muted">
            <i class="fa-solid fa-images fs-1 mb-3"></i>
            <p>No gallery images yet. Upload your first image above.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Upload Gallery Modal -->
<div class="modal fade" id="galleryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Upload Gallery Image</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body row g-3">
                    <div class="col-12">
                        <label class="form-label fw-bold">Select Image *</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Caption</label>
                        <input type="text" name="caption" class="form-control" placeholder="Optional description">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Type</label>
                        <select name="type" class="form-select">
                            <option value="product">Finished Products</option>
                            <option value="factory">Factory</option>
                            <option value="process">Manufacturing Process</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4"><i class="fa-solid fa-upload me-1"></i> Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
