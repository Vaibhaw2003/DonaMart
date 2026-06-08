<?php
// admin/categories.php
$admin_page = 'categories';
require_once __DIR__ . '/../config/db.php';

$message = '';
$message_type = '';

// ADD Category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    $id   = intval($_POST['cat_id'] ?? 0);

    try {
        if ($_POST['action'] === 'add') {
            $pdo->prepare("INSERT INTO categories (name, slug) VALUES (?, ?)")->execute([$name, $slug]);
            $message = 'Category added successfully!'; $message_type = 'success';
        } elseif ($_POST['action'] === 'edit' && $id > 0) {
            $pdo->prepare("UPDATE categories SET name=?, slug=? WHERE id=?")->execute([$name, $slug, $id]);
            $message = 'Category updated successfully!'; $message_type = 'success';
        }
    } catch (PDOException $e) {
        $message = 'Error: ' . $e->getMessage(); $message_type = 'danger';
    }
}

// DELETE Category
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    try {
        $pdo->prepare("DELETE FROM categories WHERE id = ?")->execute([intval($_GET['delete'])]);
        $message = 'Category deleted.'; $message_type = 'success';
    } catch (PDOException $e) {
        $message = 'Cannot delete – products are linked to this category.'; $message_type = 'danger';
    }
}

$categories = $pdo->query("SELECT c.*, COUNT(p.id) as prod_count FROM categories c LEFT JOIN products p ON c.id=p.category_id GROUP BY c.id ORDER BY c.id DESC")->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 font-weight-bold">Category Management</h1>
    <button class="btn btn-success rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#catModal" onclick="resetCatForm()">
        <i class="fa-solid fa-plus me-2"></i> Add Category
    </button>
</div>

<?php if ($message): ?>
<div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show">
    <?php echo $message; ?> <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="card border-0 rounded-4 shadow-sm">
    <div class="card-body p-0">
        <table class="table align-middle mb-0">
            <thead class="bg-light">
                <tr><th class="p-3">#</th><th>Name</th><th>Slug</th><th>Products</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $c): ?>
                <tr>
                    <td class="p-3"><?php echo $c['id']; ?></td>
                    <td class="fw-bold"><?php echo htmlspecialchars($c['name']); ?></td>
                    <td><code><?php echo htmlspecialchars($c['slug']); ?></code></td>
                    <td><span class="badge bg-info bg-opacity-10 text-info"><?php echo $c['prod_count']; ?> products</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary rounded-pill me-1"
                            data-bs-toggle="modal" data-bs-target="#catModal"
                            onclick="loadCatEdit(<?php echo $c['id']; ?>, '<?php echo addslashes($c['name']); ?>')">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <a href="?delete=<?php echo $c['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill"
                            onclick="return confirm('Delete this category? Products linked to it will also be removed.')">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add/Edit Category Modal -->
<div class="modal fade" id="catModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="catModalTitle">Add Category</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" id="catAction" value="add">
                <input type="hidden" name="cat_id" id="cat_id" value="">
                <div class="modal-body">
                    <label class="form-label fw-bold">Category Name *</label>
                    <input type="text" name="name" id="cat_name" class="form-control" required placeholder="e.g. Areca Leaf Plates">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function resetCatForm(){
    document.getElementById('catModalTitle').textContent='Add Category';
    document.getElementById('catAction').value='add';
    document.getElementById('cat_id').value='';
    document.getElementById('cat_name').value='';
}
function loadCatEdit(id, name){
    document.getElementById('catModalTitle').textContent='Edit Category';
    document.getElementById('catAction').value='edit';
    document.getElementById('cat_id').value=id;
    document.getElementById('cat_name').value=name;
}
</script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
