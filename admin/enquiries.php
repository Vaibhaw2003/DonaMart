<?php
// admin/enquiries.php
$admin_page = 'enquiries';
require_once __DIR__ . '/../config/db.php';

$message = '';
$message_type = '';
$active_tab = filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'enquiries';

// UPDATE status
if (isset($_GET['mark_replied']) && is_numeric($_GET['mark_replied'])) {
    $id  = intval($_GET['mark_replied']);
    $tab = filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'enquiries';
    try {
        if ($tab === 'messages') {
            $pdo->prepare("UPDATE contact_messages SET status='replied' WHERE id=?")->execute([$id]);
        } else {
            $pdo->prepare("UPDATE bulk_enquiries SET status='replied' WHERE id=?")->execute([$id]);
        }
        $message = 'Marked as replied!'; $message_type = 'success';
    } catch (PDOException $e) {
        $message = 'Error updating status.'; $message_type = 'danger';
    }
}

// DELETE
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id  = intval($_GET['delete']);
    $tab = filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'enquiries';
    try {
        $table = ($tab === 'messages') ? 'contact_messages' : 'bulk_enquiries';
        $pdo->prepare("DELETE FROM $table WHERE id=?")->execute([$id]);
        $message = 'Deleted successfully!'; $message_type = 'success';
    } catch (PDOException $e) {
        $message = 'Error deleting record.'; $message_type = 'danger';
    }
}

// Fetch data
$bulk_enquiries   = $pdo->query("SELECT * FROM bulk_enquiries ORDER BY id DESC")->fetchAll();
$contact_messages = $pdo->query("SELECT * FROM contact_messages ORDER BY id DESC")->fetchAll();
$subscribers      = $pdo->query("SELECT * FROM newsletter_subscribers ORDER BY id DESC")->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<div class="pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 font-weight-bold">Enquiries & Messages</h1>
</div>

<?php if ($message): ?>
<div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show">
    <?php echo $message; ?> <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- Nav Tabs -->
<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link <?php echo $active_tab==='enquiries' ? 'active fw-bold' : ''; ?>" href="?tab=enquiries">
            <i class="fa-solid fa-file-invoice-dollar me-1"></i> Bulk Enquiries
            <span class="badge bg-warning text-dark ms-1"><?php echo count($bulk_enquiries); ?></span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo $active_tab==='messages' ? 'active fw-bold' : ''; ?>" href="?tab=messages">
            <i class="fa-solid fa-envelope me-1"></i> Contact Messages
            <span class="badge bg-info ms-1"><?php echo count($contact_messages); ?></span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo $active_tab==='newsletter' ? 'active fw-bold' : ''; ?>" href="?tab=newsletter">
            <i class="fa-solid fa-newspaper me-1"></i> Newsletter
            <span class="badge bg-success ms-1"><?php echo count($subscribers); ?></span>
        </a>
    </li>
</ul>

<!-- BULK ENQUIRIES TAB -->
<?php if ($active_tab === 'enquiries'): ?>
<div class="card border-0 rounded-4 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="p-3">#</th>
                        <th>Client</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($bulk_enquiries)): ?>
                        <?php foreach ($bulk_enquiries as $e): ?>
                        <tr>
                            <td class="p-3"><?php echo $e['id']; ?></td>
                            <td>
                                <div class="fw-bold"><?php echo htmlspecialchars($e['name']); ?></div>
                                <small class="text-muted"><?php echo htmlspecialchars($e['company_name']); ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($e['product_name']); ?></td>
                            <td><span class="badge bg-dark"><?php echo number_format($e['quantity']); ?> pcs</span></td>
                            <td>
                                <div><i class="fa-solid fa-phone text-muted me-1"></i><?php echo htmlspecialchars($e['phone']); ?></div>
                                <div><i class="fa-solid fa-envelope text-muted me-1"></i><?php echo htmlspecialchars($e['email']); ?></div>
                            </td>
                            <td>
                                <span class="badge <?php echo $e['status']==='replied' ? 'bg-success' : ($e['status']==='closed' ? 'bg-secondary' : 'bg-warning text-dark'); ?>">
                                    <?php echo ucfirst($e['status']); ?>
                                </span>
                            </td>
                            <td class="text-muted"><?php echo date('d M Y', strtotime($e['created_at'])); ?></td>
                            <td>
                                <?php if ($e['status'] === 'pending'): ?>
                                <a href="?tab=enquiries&mark_replied=<?php echo $e['id']; ?>" class="btn btn-sm btn-outline-success rounded-pill me-1">
                                    <i class="fa-solid fa-check"></i>
                                </a>
                                <?php endif; ?>
                                <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $e['phone']); ?>?text=Hi%20<?php echo urlencode($e['name']); ?>,%20your%20bulk%20enquiry%20for%20<?php echo urlencode($e['product_name']); ?>%20has%20been%20received.%20Here%20is%20our%20quote..." target="_blank" class="btn btn-sm btn-outline-success rounded-pill me-1">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                                <a href="?tab=enquiries&delete=<?php echo $e['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Delete this enquiry?')">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="8" class="bg-light text-sm text-muted">
                                <strong>Address:</strong> <?php echo htmlspecialchars($e['address']); ?>
                                <?php if ($e['message']): ?> | <strong>Note:</strong> <?php echo htmlspecialchars($e['message']); ?><?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8" class="text-center p-4 text-muted">No bulk enquiries yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- CONTACT MESSAGES TAB -->
<?php elseif ($active_tab === 'messages'): ?>
<div class="card border-0 rounded-4 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="p-3">#</th>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($contact_messages)): ?>
                        <?php foreach ($contact_messages as $m): ?>
                        <tr class="<?php echo $m['status']==='unread' ? 'fw-bold' : ''; ?>">
                            <td class="p-3"><?php echo $m['id']; ?></td>
                            <td><?php echo htmlspecialchars($m['name']); ?></td>
                            <td><?php echo htmlspecialchars($m['subject']); ?></td>
                            <td><?php echo htmlspecialchars($m['email']); ?></td>
                            <td><?php echo htmlspecialchars($m['phone']); ?></td>
                            <td>
                                <span class="badge <?php echo $m['status']==='replied' ? 'bg-success' : ($m['status']==='read' ? 'bg-info' : 'bg-warning text-dark'); ?>">
                                    <?php echo ucfirst($m['status']); ?>
                                </span>
                            </td>
                            <td class="text-muted"><?php echo date('d M Y', strtotime($m['created_at'])); ?></td>
                            <td>
                                <a href="?tab=messages&mark_replied=<?php echo $m['id']; ?>" class="btn btn-sm btn-outline-success rounded-pill me-1">
                                    <i class="fa-solid fa-check"></i>
                                </a>
                                <a href="mailto:<?php echo htmlspecialchars($m['email']); ?>?subject=Re: <?php echo urlencode($m['subject']); ?>" class="btn btn-sm btn-outline-primary rounded-pill me-1">
                                    <i class="fa-solid fa-reply"></i>
                                </a>
                                <a href="?tab=messages&delete=<?php echo $m['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Delete this message?')">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="8" class="bg-light text-sm text-muted">
                                <strong>Message:</strong> <?php echo htmlspecialchars($m['message']); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8" class="text-center p-4 text-muted">No contact messages yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- NEWSLETTER SUBSCRIBERS TAB -->
<?php elseif ($active_tab === 'newsletter'): ?>
<div class="card border-0 rounded-4 shadow-sm">
    <div class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Newsletter Subscribers (<?php echo count($subscribers); ?>)</h5>
        <a href="?tab=newsletter&export=csv" class="btn btn-outline-success rounded-pill btn-sm">
            <i class="fa-solid fa-file-csv me-1"></i> Export CSV
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr><th class="p-3">#</th><th>Email Address</th><th>Subscribed On</th></tr>
                </thead>
                <tbody>
                    <?php if (!empty($subscribers)): ?>
                        <?php foreach ($subscribers as $i => $s): ?>
                        <tr>
                            <td class="p-3"><?php echo $i + 1; ?></td>
                            <td><?php echo htmlspecialchars($s['email']); ?></td>
                            <td class="text-muted"><?php echo date('d M Y, H:i', strtotime($s['created_at'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3" class="text-center p-4 text-muted">No subscribers yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
