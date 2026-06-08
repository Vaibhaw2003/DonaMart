<?php
// admin/products.php
$admin_page = 'products';
require_once __DIR__ . '/../config/db.php';

// Handle Actions
$message = '';
$message_type = '';

// DELETE product
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = intval($_GET['delete']);
    try {
        // Get image before deleting
        $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $prod = $stmt->fetch();
        
        $pdo->prepare("DELETE FROM products WHERE id = ?")->execute([$id]);
        
        // Remove image file
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
    $id = intval($_GET['toggle_featured']);
    try {
        $pdo->prepare("UPDATE products SET is_featured = NOT is_featured WHERE id = ?")->execute([$id]);
        $message = 'Product updated!';
        $message_type = 'success';
    } catch (PDOException $e) {
        $message = 'Error updating product.';
        $message_type = 'danger';
    }
}

// TOGGLE status
if (isset($_GET['toggle_status']) && is_numeric($_GET['toggle_status'])) {
    $id = intval($_GET['toggle_status']);
    try {
        $pdo->prepare("UPDATE products SET status = NOT status WHERE id = ?")->execute([$id]);
        $message = 'Product status updated!';
        $message_type = 'success';
    } catch (PDOException $e) {
        $message = 'Error updating product.';
        $message_type = 'danger';
    }
}

// ADD / EDIT product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
    $category_id = intval($_POST['category_id']);
    $description = trim(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS));
    $sizes = trim(filter_input(INPUT_POST, 'sizes', FILTER_SANITIZE_SPECIAL_CHARS));
    $material = trim(filter_input(INPUT_POST, 'material', FILTER_SANITIZE_SPECIAL_CHARS));
    $moq = intval($_POST['moq']);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $status = isset($_POST['status']) ? 1 : 0;
    $id = intval($_POST['product_id'] ?? 0);
    
    // Generate slug
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));

    // Handle image upload
    $image_name = filter_input(INPUT_POST, 'existing_image', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($file_ext, $allowed)) {
            $image_name = $slug . '_' . time() . '.' . $file_ext;
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../uploads/' . $image_name);
        }
    }

    try {
        if ($_POST['action'] === 'add') {
            $stmt = $pdo->prepare("INSERT INTO products (category_id, name, slug, description, sizes, material, moq, image, is_featured, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$category_id, $name, $slug, $description, $sizes, $material, $moq, $image_name, $is_featured, $status]);
            $message = 'Product added successfully!';
            $message_type = 'success';
        } elseif ($_POST['action'] === 'edit' && $id > 0) {
            $stmt = $pdo->prepare("UPDATE products SET category_id=?, name=?, slug=?, description=?, sizes=?, material=?, moq=?, image=?, is_featured=?, status=? WHERE id=?");
            $stmt->execute([$category_id, $name, $slug, $description, $sizes, $material, $moq, $image_name, $is_featured, $status, $id]);
            $message = 'Product updated successfully!';
            $message_type = 'success';
        }
    } catch (PDOException $e) {
        $message = 'Error: ' . $e->getMessage();
        $message_type = 'danger';
    }
}

// Fetch edit product if requested
$edit_product = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([intval($_GET['edit'])]);
    $edit_product = $stmt->fetch();
}

// Fetch all categories for dropdown
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();

// Fetch all products
$products = $pdo->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC")->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 font-weight-bold">Product Management</h1>
    <button class="btn btn-success rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#productModal" id="addProductBtn">
        <i class="fa-solid fa-plus me-2"></i> Add New Product
    </button>
</div>

<?php if ($message): ?>
    <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
        <?php echo $message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Products Table -->
<div class="card border-0 rounded-4 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="p-3">#</th>
                        <th>Image</th>
                        <th>Name</th>
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
                            <tr>
                                <td class="p-3"><?php echo $p['id']; ?></td>
                                <td><img src="/DonaMart/uploads/<?php echo htmlspecialchars($p['image']); ?>" width="60" height="60" class="rounded object-fit-cover" style="object-fit:cover;"></td>
                                <td>
                                    <div class="fw-bold"><?php echo htmlspecialchars($p['name']); ?></div>
                                    <small class="text-muted"><?php echo htmlspecialchars($p['material']); ?></small>
                                </td>
                                <td><span class="badge bg-success bg-opacity-10 text-success"><?php echo htmlspecialchars($p['category_name']); ?></span></td>
                                <td><?php echo number_format($p['moq']); ?></td>
                                <td>
                                    <a href="?toggle_featured=<?php echo $p['id']; ?>" class="badge <?php echo $p['is_featured'] ? 'bg-warning' : 'bg-secondary'; ?> text-decoration-none">
                                        <?php echo $p['is_featured'] ? 'Yes' : 'No'; ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="?toggle_status=<?php echo $p['id']; ?>" class="badge <?php echo $p['status'] ? 'bg-success' : 'bg-danger'; ?> text-decoration-none">
                                        <?php echo $p['status'] ? 'Active' : 'Hidden'; ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="?edit=<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-primary rounded-pill me-1" data-bs-toggle="modal" data-bs-target="#productModal" onclick="loadEditProduct(<?php echo htmlspecialchars(json_encode($p)); ?>)">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <a href="?delete=<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Are you sure you want to delete this product?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center p-4 text-muted">No products found. Add your first product above.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Product Modal -->
<div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalTitle">Add New Product</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="product_id" id="product_id" value="">
                <input type="hidden" name="existing_image" id="existing_image" value="">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Product Name *</label>
                            <input type="text" name="name" id="prod_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Category *</label>
                            <select name="category_id" id="prod_category_id" class="form-select" required>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Description *</label>
                            <textarea name="description" id="prod_description" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Available Sizes</label>
                            <input type="text" name="sizes" id="prod_sizes" class="form-control" placeholder="e.g. 8 inch, 10 inch">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Material</label>
                            <input type="text" name="material" id="prod_material" class="form-control" placeholder="e.g. Areca Leaf">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Minimum Order Qty (MOQ)</label>
                            <input type="number" name="moq" id="prod_moq" class="form-control" min="1" value="1000">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Product Image</label>
                            <input type="file" name="image" id="prod_image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-6 d-flex align-items-center gap-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="is_featured" id="prod_is_featured" class="form-check-input" role="switch">
                                <label class="form-check-label fw-bold" for="prod_is_featured">Featured Product</label>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex align-items-center gap-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="status" id="prod_status" class="form-check-input" role="switch" checked>
                                <label class="form-check-label fw-bold" for="prod_status">Active (Visible)</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4">Save Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function loadEditProduct(p) {
    document.getElementById('modalTitle').textContent = 'Edit Product';
    document.getElementById('formAction').value = 'edit';
    document.getElementById('product_id').value = p.id;
    document.getElementById('prod_name').value = p.name;
    document.getElementById('prod_category_id').value = p.category_id;
    document.getElementById('prod_description').value = p.description;
    document.getElementById('prod_sizes').value = p.sizes;
    document.getElementById('prod_material').value = p.material;
    document.getElementById('prod_moq').value = p.moq;
    document.getElementById('prod_is_featured').checked = p.is_featured == 1;
    document.getElementById('prod_status').checked = p.status == 1;
    document.getElementById('existing_image').value = p.image;
}

document.getElementById('addProductBtn').addEventListener('click', function() {
    document.getElementById('modalTitle').textContent = 'Add New Product';
    document.getElementById('formAction').value = 'add';
    document.getElementById('product_id').value = '';
    document.getElementById('prod_name').value = '';
    document.getElementById('prod_description').value = '';
    document.getElementById('prod_sizes').value = '';
    document.getElementById('prod_material').value = '';
    document.getElementById('prod_moq').value = '1000';
    document.getElementById('prod_is_featured').checked = false;
    document.getElementById('prod_status').checked = true;
    document.getElementById('existing_image').value = '';
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
