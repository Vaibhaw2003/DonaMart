<?php
// admin/index.php
$admin_page = 'dashboard';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/includes/header.php';

// Fetch statistics
try {
    $prod_count = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    $cat_count  = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
    $enq_count  = $pdo->query("SELECT COUNT(*) FROM bulk_enquiries")->fetchColumn();
    $msg_count  = $pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();
    $sub_count  = $pdo->query("SELECT COUNT(*) FROM newsletter_subscribers")->fetchColumn();
    
    // Fetch 5 recent bulk enquiries
    $stmt_enq = $pdo->query("SELECT * FROM bulk_enquiries ORDER BY id DESC LIMIT 5");
    $recent_enquiries = $stmt_enq->fetchAll();

    // Fetch 5 recent contact messages
    $stmt_msg = $pdo->query("SELECT * FROM contact_messages ORDER BY id DESC LIMIT 5");
    $recent_messages = $stmt_msg->fetchAll();
} catch (PDOException $e) {
    $prod_count = $cat_count = $enq_count = $msg_count = $sub_count = 0;
    $recent_enquiries = $recent_messages = [];
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 font-weight-bold">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <span class="text-muted">Welcome back, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</span>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-5">
    <!-- Products -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-stat bg-white p-3 d-flex flex-row align-items-center justify-content-between">
            <div>
                <span class="text-muted text-sm text-uppercase font-weight-bold">Products</span>
                <h3 class="mb-0 font-weight-bold mt-1"><?php echo $prod_count; ?></h3>
            </div>
            <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle">
                <i class="fa-solid fa-boxes-stacked fs-3"></i>
            </div>
        </div>
    </div>
    <!-- Categories -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-stat bg-white p-3 d-flex flex-row align-items-center justify-content-between">
            <div>
                <span class="text-muted text-sm text-uppercase font-weight-bold">Categories</span>
                <h3 class="mb-0 font-weight-bold mt-1"><?php echo $cat_count; ?></h3>
            </div>
            <div class="bg-info bg-opacity-10 text-info p-3 rounded-circle">
                <i class="fa-solid fa-tags fs-3"></i>
            </div>
        </div>
    </div>
    <!-- Bulk Enquiries -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-stat bg-white p-3 d-flex flex-row align-items-center justify-content-between">
            <div>
                <span class="text-muted text-sm text-uppercase font-weight-bold">Bulk Enquiries</span>
                <h3 class="mb-0 font-weight-bold mt-1"><?php echo $enq_count; ?></h3>
            </div>
            <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-circle">
                <i class="fa-solid fa-file-invoice-dollar fs-3"></i>
            </div>
        </div>
    </div>
    <!-- Newsletter Subscribers -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-stat bg-white p-3 d-flex flex-row align-items-center justify-content-between">
            <div>
                <span class="text-muted text-sm text-uppercase font-weight-bold">Subscribers</span>
                <h3 class="mb-0 font-weight-bold mt-1"><?php echo $sub_count; ?></h3>
            </div>
            <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-circle">
                <i class="fa-solid fa-users fs-3"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Bulk Enquiries -->
    <div class="col-lg-6">
        <div class="card border-0 rounded-4 shadow-sm p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="h5 mb-0 font-weight-bold"><i class="fa-solid fa-envelope-open-text me-2 text-warning"></i>Recent Bulk Enquiries</h4>
                <a href="/DonaMart/admin/enquiries.php" class="btn btn-outline-secondary btn-sm rounded-pill font-weight-bold text-xs">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recent_enquiries)): ?>
                            <?php foreach ($recent_enquiries as $enq): ?>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold"><?php echo htmlspecialchars($enq['name']); ?></div>
                                        <small class="text-muted"><?php echo htmlspecialchars($enq['company_name']); ?></small>
                                    </td>
                                    <td><?php echo htmlspecialchars($enq['product_name']); ?></td>
                                    <td><span class="badge bg-secondary"><?php echo htmlspecialchars($enq['quantity']); ?></span></td>
                                    <td class="text-muted text-xs"><?php echo date('d M Y', strtotime($enq['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">No enquiries received yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Contact Messages -->
    <div class="col-lg-6">
        <div class="card border-0 rounded-4 shadow-sm p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="h5 mb-0 font-weight-bold"><i class="fa-solid fa-envelope me-2 text-info"></i>Recent Messages</h4>
                <a href="/DonaMart/admin/enquiries.php?tab=messages" class="btn btn-outline-secondary btn-sm rounded-pill font-weight-bold text-xs">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>From</th>
                            <th>Subject</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recent_messages)): ?>
                            <?php foreach ($recent_messages as $msg): ?>
                                <tr>
                                    <td class="font-weight-bold"><?php echo htmlspecialchars($msg['name']); ?></td>
                                    <td><?php echo htmlspecialchars(substr($msg['subject'], 0, 30)) . '...'; ?></td>
                                    <td class="text-muted text-xs"><?php echo date('d M Y', strtotime($msg['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted">No messages received yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
