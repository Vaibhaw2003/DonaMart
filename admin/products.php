<?php
// admin/products.php
$admin_page = 'products';
require_once __DIR__ . '/../config/db.php';

$message = '';
$message_type = '';

// DELETE product
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = intval($_GET['delete']);
    try {
        $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $prod = $stmt->fetch();
        $pdo->prepare("DELETE FROM products WHERE id = ?")->execute([$id]);
        if ($prod && $prod['image'] && file_exists(__DIR__ . '/../uploads/' . $prod['image'])) {
            unlink(__DIR__ . '/../uploads/' . $prod['image']);
        }
        $message = 'Product deleted successfully!';
        $message_type = 'success';
    } catch (PDOException $e) {
        $message = 'Error deleting product.';
        $message_type = 'danger';
    }
}

// TOGGLE featured
if (isset($_GET['toggle_featured']) && is_numeric($_GET['toggle_featured'])) {
    try {
        $pdo->prepare("UPDATE products SET is_featured = NOT is_featured WHERE id = ?")->execute([intval($_GET['toggle_featured'])]);
        $message = 'Featured status updated!';
        $message_type = 'success';
    } catch (PDOException $e) {
        $message = 'Error updating product.';
        $message_type = 'danger';
    }
}

// TOGGLE status
if (isset($_GET['toggle_status']) && is_numeric($_GET['toggle_status'])) {
    try {
        $pdo->prepare("UPDATE products SET status = NOT status WHERE id = ?")->execute([intval($_GET['toggle_status'])]);
        $message = 'Product status updated!';
        $message_type = 'success';
    } catch (PDOException $e) {
        $message = 'Error updating product.';
        $message_type = 'danger';
    }
}

// ADD / EDIT product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $name        = trim(filter_input(INPUT_POST, 'name',        FILTER_SANITIZE_SPECIAL_CHARS));
    $category_id = intval($_POST['category_id']);
    $description = trim(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS));
    $sizes       = trim(filter_input(INPUT_POST, 'sizes',       FILTER_SANITIZE_SPECIAL_CHARS));
    $material    = trim(filter_input(INPUT_POST, 'material',    FILTER_SANITIZE_SPECIAL_CHARS));
    $moq         = intval($_POST['moq']);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $status      = isset($_POST['status']) ? 1 : 0;
    $id          = intval($_POST['product_id'] ?? 0);
    $slug        = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));

    $image_name = trim(filter_input(INPUT_POST, 'existing_image', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($file_ext, ['jpg','jpeg','png','webp'])) {
            $image_name = $slug . '_' . time() . '.' . $file_ext;
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../uploads/' . $image_name);
        }
    }

    try {
        if ($_POST['action'] === 'add') {
            $pdo->prepare("INSERT INTO products (category_id, name, slug, description, sizes, material, moq, image, is_featured, status) VALUES (?,?,?,?,?,?,?,?,?,?)")
                ->execute([$category_id, $name, $slug, $description, $sizes, $material, $moq, $image_name, $is_featured, $status]);
            $message = 'Product added successfully!';
            $message_type = 'success';
        } elseif ($_POST['action'] === 'edit' && $id > 0) {
            $pdo->prepare("UPDATE products SET category_id=?,name=?,slug=?,description=?,sizes=?,material=?,moq=?,image=?,is_featured=?,status=? WHERE id=?")
                ->execute([$category_id, $name, $slug, $description, $sizes, $material, $moq, $image_name, $is_featured, $status, $id]);
            $message = 'Product updated successfully!';
            $message_type = 'success';
        }
    } catch (PDOException $e) {
        $message = 'Error: ' . $e->getMessage();
        $message_type = 'danger';
    }
}

$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
$products   = $pdo->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC")->fetchAll();

$total    = count($products);
$active   = count(array_filter($products, fn($p) => $p['status']));
$featured = count(array_filter($products, fn($p) => $p['is_featured']));

require_once __DIR__ . '/includes/header.php';
?>

<!-- Page Header -->
<div class="page-header-row">
    <div class="page-header-title">
        <i class="fa-solid fa-boxes-stacked me-2" style="color:var(--forest-mid);"></i>Product Management
    </div>
    <button class="btn-forest" data-bs-toggle="modal" data-bs-target="#productModal" id="addProductBtn">
        <i class="fa-solid fa-plus"></i> Add Product
    </button>
</div>

<?php if ($message): ?>
<div class="dm-alert dm-alert-<?= $message_type ?> mb-3">
    <i class="fa-solid fa-<?= $message_type === 'success' ? 'circle-check' : 'circle-exclamation' ?>"></i>
    <?= htmlspecialchars($message) ?>
</div>
<?php endif; ?>

<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon-wrap si-green"><i class="fa-solid fa-boxes-stacked"></i></div>
            <div class="stat-label">Total Products</div>
            <div class="stat-value"><?= $total ?></div>
            <div class="stat-sub"><?= $active ?> active</div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon-wrap si-amber"><i class="fa-solid fa-star"></i></div>
            <div class="stat-label">Featured</div>
            <div class="stat-value"><?= $featured ?></div>
            <div class="stat-sub">shown on homepage</div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon-wrap si-red"><i class="fa-solid fa-eye-slash"></i></div>
            <div class="stat-label">Hidden</div>
            <div class="stat-value"><?= $total - $active ?></div>
            <div class="stat-sub">not visible on site</div>
        </div>
    </div>
</div>

<!-- Products Table -->
<div class="dm-card">
    <div style="padding:14px 18px;border-bottom:1px solid #f0f0f0;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
        <span style="font-size:13px;font-weight:600;color:#111;">
            All Products <span style="font-size:12px;font-weight:400;color:#aaa;">(<?= $total ?> total)</span>
        </span>
        <!-- Search filter -->
        <input type="text" id="prodSearch" placeholder="🔍  Search products..."
               oninput="filterProducts(this.value)"
               style="border:1px solid #e8e8e8;border-radius:8px;padding:6px 12px;font-size:12px;outline:none;width:220px;">
    </div>
    <div style="overflow-x:auto;">
        <table class="dm-table" id="prodTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>MOQ</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $p): ?>
                    <tr class="prod-row" data-name="<?= strtolower(htmlspecialchars($p['name'])) ?>">
                        <td style="color:#aaa;font-size:12px;"><?= $p['id'] ?></td>
                        <td>
                            <img src="/DonaMart/uploads/<?= htmlspecialchars($p['image']) ?>"
                                 style="width:48px;height:48px;object-fit:cover;border-radius:8px;border:1px solid #eee;"
                                 alt="<?= htmlspecialchars($p['name']) ?>"
                                 onerror="this.src='/DonaMart/assets/images/placeholder.png'">
                        </td>
                        <td>
                            <div style="font-weight:600;color:#111;"><?= htmlspecialchars($p['name']) ?></div>
                            <div style="font-size:11px;color:#aaa;"><?= htmlspecialchars($p['material']) ?></div>
                        </td>
                        <td>
                            <span class="dm-badge badge-success"><?= htmlspecialchars($p['category_name']) ?></span>
                        </td>
                        <td style="font-weight:500;"><?= number_format($p['moq']) ?></td>
                        <td>
                            <a href="?toggle_featured=<?= $p['id'] ?>"
                               class="dm-badge <?= $p['is_featured'] ? 'badge-warning' : 'badge-secondary' ?>"
                               style="text-decoration:none;cursor:pointer;"
                               title="Click to toggle">
                                <?= $p['is_featured'] ? '★ Yes' : '☆ No' ?>
                            </a>
                        </td>
                        <td>
                            <a href="?toggle_status=<?= $p['id'] ?>"
                               class="dm-badge <?= $p['status'] ? 'badge-success' : 'badge-danger' ?>"
                               style="text-decoration:none;cursor:pointer;"
                               title="Click to toggle">
                                <?= $p['status'] ? '● Active' : '● Hidden' ?>
                            </a>
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;">
                                <button class="btn-outline-forest"
                                    style="padding:5px 12px;font-size:12px;border-radius:6px;"
                                    data-bs-toggle="modal" data-bs-target="#productModal"
                                    onclick="loadEditProduct(<?= htmlspecialchars(json_encode($p)) ?>)">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <a href="?delete=<?= $p['id'] ?>"
                                   class="dm-badge badge-danger"
                                   style="padding:5px 12px;border-radius:6px;text-decoration:none;font-size:12px;display:inline-flex;align-items:center;gap:4px;"
                                   onclick="return confirm('Delete \'<?= addslashes($p['name']) ?>\'? This cannot be undone.')">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align:center;padding:40px;color:#aaa;">
                            <i class="fa-solid fa-boxes-stacked" style="font-size:28px;display:block;margin-bottom:10px;opacity:0.3;"></i>
                            No products yet. Add your first product!
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add/Edit Product Modal -->
<div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border:none;border-radius:14px;overflow:hidden;">
            <div class="modal-header dm-modal-head">
                <h5 class="modal-title" id="modalTitle">
                    <i class="fa-solid fa-plus me-2"></i>Add New Product
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action"         id="formAction"     value="add">
                <input type="hidden" name="product_id"     id="product_id"     value="">
                <input type="hidden" name="existing_image" id="existing_image" value="">
                <div class="modal-body" style="padding:24px;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="prod_name" class="form-control" required placeholder="e.g. Areca Leaf Plates 8 inch">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category_id" id="prod_category_id" class="form-select" required>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea name="description" id="prod_description" class="form-control" rows="3" required placeholder="Describe the product..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Available Sizes</label>
                            <input type="text" name="sizes" id="prod_sizes" class="form-control" placeholder="e.g. 6 inch, 8 inch, 10 inch">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Material</label>
                            <input type="text" name="material" id="prod_material" class="form-control" placeholder="e.g. Areca Leaf, Sal Leaf">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Minimum Order Qty (MOQ)</label>
                            <input type="number" name="moq" id="prod_moq" class="form-control" min="1" value="1000">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Product Image</label>
                            <input type="file" name="image" id="prod_image" class="form-control" accept="image/jpeg,image/png,image/webp">
                            <div style="font-size:11px;color:#aaa;margin-top:4px;">JPG, PNG or WEBP. Max 5MB.</div>
                        </div>
                        <!-- Image preview -->
                        <div class="col-12" id="img_preview_wrap" style="display:none;">
                            <label class="form-label">Current Image</label>
                            <img id="img_preview" src="" style="height:80px;border-radius:8px;border:1px solid #eee;object-fit:cover;">
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mt-2">
                                <input type="checkbox" name="is_featured" id="prod_is_featured" class="form-check-input" role="switch">
                                <label class="form-check-label fw-bold" for="prod_is_featured">Featured Product</label>
                                <div style="font-size:11px;color:#aaa;">Show on homepage highlights</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mt-2">
                                <input type="checkbox" name="status" id="prod_status" class="form-check-input" role="switch" checked>
                                <label class="form-check-label fw-bold" for="prod_status">Active (Visible)</label>
                                <div style="font-size:11px;color:#aaa;">Show on products page</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #f0f0f0;padding:14px 24px;">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-forest" style="padding:8px 22px;border-radius:8px;">
                        <i class="fa-solid fa-save me-1"></i> Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function loadEditProduct(p) {
    document.getElementById('modalTitle').innerHTML     = '<i class="fa-solid fa-pen me-2"></i>Edit Product';
    document.getElementById('formAction').value         = 'edit';
    document.getElementById('product_id').value         = p.id;
    document.getElementById('prod_name').value          = p.name;
    document.getElementById('prod_category_id').value   = p.category_id;
    document.getElementById('prod_description').value   = p.description;
    document.getElementById('prod_sizes').value         = p.sizes;
    document.getElementById('prod_material').value      = p.material;
    document.getElementById('prod_moq').value           = p.moq;
    document.getElementById('prod_is_featured').checked = p.is_featured == 1;
    document.getElementById('prod_status').checked      = p.status == 1;
    document.getElementById('existing_image').value     = p.image;
    if (p.image) {
        document.getElementById('img_preview').src        = '/DonaMart/uploads/' + p.image;
        document.getElementById('img_preview_wrap').style.display = 'block';
    } else {
        document.getElementById('img_preview_wrap').style.display = 'none';
    }
}

document.getElementById('addProductBtn').addEventListener('click', function () {
    document.getElementById('modalTitle').innerHTML     = '<i class="fa-solid fa-plus me-2"></i>Add New Product';
    document.getElementById('formAction').value         = 'add';
    document.getElementById('product_id').value         = '';
    document.getElementById('prod_name').value          = '';
    document.getElementById('prod_description').value   = '';
    document.getElementById('prod_sizes').value         = '';
    document.getElementById('prod_material').value      = '';
    document.getElementById('prod_moq').value           = '1000';
    document.getElementById('prod_is_featured').checked = false;
    document.getElementById('prod_status').checked      = true;
    document.getElementById('existing_image').value     = '';
    document.getElementById('img_preview_wrap').style.display = 'none';
});

// Live search filter
function filterProducts(q) {
    q = q.toLowerCase();
    document.querySelectorAll('.prod-row').forEach(row => {
        row.style.display = row.dataset.name.includes(q) ? '' : 'none';
    });
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>