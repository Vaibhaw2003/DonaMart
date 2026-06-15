<?php
// admin/categories.php
$admin_page = 'categories';
require_once __DIR__ . '/../config/db.php';

$message = '';
$message_type = '';

// ADD / EDIT Category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    $id   = intval($_POST['cat_id'] ?? 0);

    if (empty($name)) {
        $message = 'Category name cannot be empty.';
        $message_type = 'danger';
    } else {
        try {
            if ($_POST['action'] === 'add') {
                $pdo->prepare("INSERT INTO categories (name, slug) VALUES (?, ?)")->execute([$name, $slug]);
                $message = 'Category added successfully!';
                $message_type = 'success';
            } elseif ($_POST['action'] === 'edit' && $id > 0) {
                $pdo->prepare("UPDATE categories SET name=?, slug=? WHERE id=?")->execute([$name, $slug, $id]);
                $message = 'Category updated successfully!';
                $message_type = 'success';
            }
        } catch (PDOException $e) {
            $message = 'Error: ' . $e->getMessage();
            $message_type = 'danger';
        }
    }
}

// DELETE Category
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    try {
        $pdo->prepare("DELETE FROM categories WHERE id = ?")->execute([intval($_GET['delete'])]);
        $message = 'Category deleted successfully.';
        $message_type = 'success';
    } catch (PDOException $e) {
        $message = 'Cannot delete — products are linked to this category. Remove products first.';
        $message_type = 'danger';
    }
}

$categories = $pdo->query("
    SELECT c.*, COUNT(p.id) as prod_count
    FROM categories c
    LEFT JOIN products p ON c.id = p.category_id
    GROUP BY c.id
    ORDER BY c.id DESC
")->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<!-- Page Header -->
<div class="page-header-row">
    <div class="page-header-title">
        <i class="fa-solid fa-tags me-2" style="color:var(--forest-mid);"></i>Category Management
    </div>
    <button class="btn-forest" data-bs-toggle="modal" data-bs-target="#catModal" onclick="resetCatForm()">
        <i class="fa-solid fa-plus"></i> Add Category
    </button>
</div>

<?php if ($message): ?>
<div class="dm-alert dm-alert-<?= $message_type ?> mb-3">
    <i class="fa-solid fa-<?= $message_type === 'success' ? 'circle-check' : 'circle-exclamation' ?>"></i>
    <?= htmlspecialchars($message) ?>
</div>
<?php endif; ?>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon-wrap si-teal"><i class="fa-solid fa-tags"></i></div>
            <div class="stat-label">Total Categories</div>
            <div class="stat-value"><?= count($categories) ?></div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon-wrap si-green"><i class="fa-solid fa-boxes-stacked"></i></div>
            <div class="stat-label">Total Products</div>
            <div class="stat-value"><?= array_sum(array_column($categories, 'prod_count')) ?></div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon-wrap si-amber"><i class="fa-solid fa-folder-open"></i></div>
            <div class="stat-label">Empty Categories</div>
            <div class="stat-value"><?= count(array_filter($categories, fn($c) => $c['prod_count'] == 0)) ?></div>
        </div>
    </div>
</div>

<!-- Categories Table -->
<div class="dm-card">
    <div style="padding:14px 18px;border-bottom:1px solid #f0f0f0;display:flex;align-items:center;justify-content:space-between;">
        <span style="font-size:13px;font-weight:600;color:#111;">
            All Categories <span style="font-size:12px;font-weight:400;color:#aaa;margin-left:6px;">(<?= count($categories) ?> total)</span>
        </span>
    </div>
    <div style="overflow-x:auto;">
        <table class="dm-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Category Name</th>
                    <th>Slug</th>
                    <th>Products</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $c): ?>
                    <tr>
                        <td style="color:#aaa;font-size:12px;"><?= $c['id'] ?></td>
                        <td>
                            <div style="font-weight:600;color:#111;"><?= htmlspecialchars($c['name']) ?></div>
                        </td>
                        <td>
                            <code style="background:#f5f5f2;padding:3px 8px;border-radius:5px;font-size:12px;color:#555;">
                                <?= htmlspecialchars($c['slug']) ?>
                            </code>
                        </td>
                        <td>
                            <span class="dm-badge <?= $c['prod_count'] > 0 ? 'badge-success' : 'badge-secondary' ?>">
                                <?= $c['prod_count'] ?> product<?= $c['prod_count'] != 1 ? 's' : '' ?>
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;">
                                <button class="btn-outline-forest"
                                    style="padding:5px 12px;font-size:12px;border-radius:6px;"
                                    data-bs-toggle="modal" data-bs-target="#catModal"
                                    onclick="loadCatEdit(<?= $c['id'] ?>, '<?= addslashes(htmlspecialchars($c['name'])) ?>')">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </button>
                                <a href="?delete=<?= $c['id'] ?>"
                                   class="dm-badge badge-danger"
                                   style="padding:5px 12px;border-radius:6px;text-decoration:none;font-size:12px;display:inline-flex;align-items:center;gap:4px;"
                                   onclick="return confirm('Delete \'<?= addslashes($c['name']) ?>\'? Products linked to it may also be affected.')">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center;padding:40px;color:#aaa;">
                            <i class="fa-solid fa-tags" style="font-size:28px;display:block;margin-bottom:10px;opacity:0.3;"></i>
                            No categories yet. Add your first one!
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="catModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border:none;border-radius:14px;overflow:hidden;">
            <div class="modal-header dm-modal-head">
                <h5 class="modal-title" id="catModalTitle">
                    <i class="fa-solid fa-tags me-2"></i>Add Category
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" id="catAction" value="add">
                <input type="hidden" name="cat_id" id="cat_id" value="">
                <div class="modal-body" style="padding:24px;">
                    <label class="form-label">Category Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="cat_name" class="form-control"
                           required placeholder="e.g. Areca Leaf Plates"
                           style="border-radius:8px;">
                    <div style="font-size:12px;color:#aaa;margin-top:6px;">
                        <i class="fa-solid fa-info-circle me-1"></i>
                        Slug will be auto-generated from the name.
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #f0f0f0;padding:14px 24px;">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-forest" style="padding:8px 22px;border-radius:8px;">
                        <i class="fa-solid fa-save me-1"></i> Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function resetCatForm() {
    document.getElementById('catModalTitle').innerHTML = '<i class="fa-solid fa-tags me-2"></i>Add Category';
    document.getElementById('catAction').value = 'add';
    document.getElementById('cat_id').value = '';
    document.getElementById('cat_name').value = '';
}
function loadCatEdit(id, name) {
    document.getElementById('catModalTitle').innerHTML = '<i class="fa-solid fa-pen me-2"></i>Edit Category';
    document.getElementById('catAction').value = 'edit';
    document.getElementById('cat_id').value = id;
    document.getElementById('cat_name').value = name;
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>