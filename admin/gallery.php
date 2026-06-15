<?php
// admin/gallery.php

$admin_page = 'gallery';
require_once __DIR__ . '/../config/db.php';

$message = '';
$message_type = '';

/* =========================
   DELETE IMAGE
========================= */
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {

    $id = intval($_GET['delete']);

    try {

        $stmt = $pdo->prepare("SELECT image FROM gallery WHERE id = ?");
        $stmt->execute([$id]);

        $image = $stmt->fetchColumn();

        $pdo->prepare("DELETE FROM gallery WHERE id = ?")
            ->execute([$id]);

        $file = __DIR__ . '/../uploads/' . $image;

        if ($image && file_exists($file)) {
            unlink($file);
        }

        $message = "Image deleted successfully!";
        $message_type = "success";

    } catch (PDOException $e) {

        $message = "Error deleting image.";
        $message_type = "danger";
    }
}

/* =========================
   UPLOAD IMAGE
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $caption = trim($_POST['caption'] ?? '');
    $type = trim($_POST['type'] ?? 'product');

    if (
        isset($_FILES['image']) &&
        $_FILES['image']['error'] === UPLOAD_ERR_OK
    ) {

        $max_size = 5 * 1024 * 1024;

        if ($_FILES['image']['size'] > $max_size) {

            $message = "Image size must be less than 5MB.";
            $message_type = "danger";

        } else {

            $extension = strtolower(
                pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)
            );

            $allowed = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($extension, $allowed)) {

                $image_name =
                    'gallery_' .
                    time() .
                    '_' .
                    uniqid() .
                    '.' .
                    $extension;

                $upload_path =
                    __DIR__ . '/../uploads/' . $image_name;

                if (
                    move_uploaded_file(
                        $_FILES['image']['tmp_name'],
                        $upload_path
                    )
                ) {

                    try {

                        $stmt = $pdo->prepare("
                            INSERT INTO gallery
                            (image, caption, type)
                            VALUES (?, ?, ?)
                        ");

                        $stmt->execute([
                            $image_name,
                            $caption,
                            $type
                        ]);

                        $message = "Image uploaded successfully!";
                        $message_type = "success";

                    } catch (PDOException $e) {

                        $message = "Database error.";
                        $message_type = "danger";
                    }

                } else {

                    $message = "Failed to upload image.";
                    $message_type = "danger";
                }

            } else {

                $message =
                    "Only JPG, JPEG, PNG and WEBP files are allowed.";

                $message_type = "danger";
            }
        }

    } else {

        $message = "Please select a valid image.";
        $message_type = "danger";
    }
}

/* =========================
   FETCH GALLERY
========================= */

$gallery_items = $pdo
    ->query("SELECT * FROM gallery ORDER BY id DESC")
    ->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 fw-bold">Gallery Management</h1>

    <button
        class="btn btn-success rounded-pill px-4"
        data-bs-toggle="modal"
        data-bs-target="#galleryModal">

        <i class="fa-solid fa-upload me-2"></i>
        Upload Image
    </button>
</div>

<?php if ($message): ?>

<div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show">
    <?php echo $message; ?>

    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert">
    </button>
</div>

<?php endif; ?>

<!-- GALLERY GRID -->

<div class="row g-4">

<?php if (!empty($gallery_items)): ?>

    <?php foreach ($gallery_items as $item): ?>

        <div class="col-lg-3 col-md-4 col-sm-6">

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">

                <img
                    src="/DonaMart/uploads/<?php echo htmlspecialchars($item['image']); ?>"
                    alt="<?php echo htmlspecialchars($item['caption']); ?>"
                    class="card-img-top"
                    style="
                        height:220px;
                        object-fit:contain;
                        background:#fff;
                        padding:10px;
                    ">

                <div class="card-body">

                    <h6 class="fw-bold mb-2">
                        <?php echo htmlspecialchars($item['caption'] ?: 'No Caption'); ?>
                    </h6>

                    <span class="badge bg-secondary text-capitalize">
                        <?php echo htmlspecialchars($item['type']); ?>
                    </span>

                    <div class="mt-3 text-end">

                        <a
                            href="?delete=<?php echo $item['id']; ?>"
                            onclick="return confirm('Delete this image?')"
                            class="btn btn-outline-danger btn-sm rounded-pill">

                            <i class="fa-solid fa-trash"></i>
                            Delete

                        </a>

                    </div>

                </div>

            </div>

        </div>

    <?php endforeach; ?>

<?php else: ?>

    <div class="col-12 text-center py-5">

        <i class="fa-solid fa-images fa-4x text-muted mb-3"></i>

        <h5 class="text-muted">
            No gallery images available
        </h5>

        <p class="text-muted">
            Upload your first image using the button above.
        </p>

    </div>

<?php endif; ?>

</div>

<!-- UPLOAD MODAL -->

<div class="modal fade" id="galleryModal" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header bg-success text-white">

                <h5 class="modal-title">
                    Upload Gallery Image
                </h5>

                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <form method="POST" enctype="multipart/form-data">

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Select Image *
                        </label>

                        <input
                            type="file"
                            name="image"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp"
                            required>

                        <small class="text-muted">
                            JPG, PNG, WEBP | Max 5MB
                        </small>

                    </div>

                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Caption
                        </label>

                        <input
                            type="text"
                            name="caption"
                            class="form-control"
                            placeholder="Enter image caption">

                    </div>

                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Type
                        </label>

                        <select name="type" class="form-select">

                            <option value="product">
                                Finished Products
                            </option>

                            <option value="factory">
                                Factory & Infrastructure
                            </option>

                            <option value="process">
                                Manufacturing Process
                            </option>

                            <option value="machinery">
                                Machinery
                            </option>

                            <option value="packaging">
                                Packaging
                            </option>

                            <option value="raw_material">
                                Raw Material
                            </option>

                        </select>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary rounded-pill"
                        data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button
                        type="submit"
                        class="btn btn-success rounded-pill px-4">

                        <i class="fa-solid fa-upload me-1"></i>
                        Upload

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>