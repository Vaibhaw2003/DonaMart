<?php
// admin/enquiries.php
$admin_page = 'enquiries';
require_once __DIR__ . '/../config/db.php';

$message = '';
$message_type = '';
$active_tab = filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'enquiries';

// MARK replied
if (isset($_GET['mark_replied']) && is_numeric($_GET['mark_replied'])) {
    $id  = intval($_GET['mark_replied']);
    $tab = filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'enquiries';
    try {
        if ($tab === 'messages') {
            $pdo->prepare("UPDATE contact_messages SET status='replied' WHERE id=?")->execute([$id]);
        } else {
            $pdo->prepare("UPDATE bulk_enquiries SET status='replied' WHERE id=?")->execute([$id]);
        }
        $message = 'Marked as replied!';
        $message_type = 'success';
    } catch (PDOException $e) {
        $message = 'Error updating status.';
        $message_type = 'danger';
    }
}

// DELETE
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id  = intval($_GET['delete']);
    $tab = filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'enquiries';
    try {
        $table = ($tab === 'messages') ? 'contact_messages' : 'bulk_enquiries';
        $pdo->prepare("DELETE FROM $table WHERE id=?")->execute([$id]);
        $message = 'Deleted successfully!';
        $message_type = 'success';
    } catch (PDOException $e) {
        $message = 'Error deleting record.';
        $message_type = 'danger';
    }
}

// Export CSV
if (isset($_GET['export']) && $_GET['export'] === 'csv' && $active_tab === 'newsletter') {
    $subs = $pdo->query("SELECT email, created_at FROM newsletter_subscribers ORDER BY id DESC")->fetchAll();
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="subscribers_' . date('Y-m-d') . '.csv"');
    $f = fopen('php://output', 'w');
    fputcsv($f, ['Email', 'Subscribed On']);
    foreach ($subs as $s) fputcsv($f, [$s['email'], $s['created_at']]);
    fclose($f);
    exit;
}

$bulk_enquiries   = $pdo->query("SELECT * FROM bulk_enquiries ORDER BY id DESC")->fetchAll();
$contact_messages = $pdo->query("SELECT * FROM contact_messages ORDER BY id DESC")->fetchAll();
$subscribers      = $pdo->query("SELECT * FROM newsletter_subscribers ORDER BY id DESC")->fetchAll();

$pending_enq  = count(array_filter($bulk_enquiries,   fn($e) => $e['status'] === 'pending'));
$unread_msg   = count(array_filter($contact_messages, fn($m) => $m['status'] === 'unread'));

require_once __DIR__ . '/includes/header.php';
?>

<!-- Page Header -->
<div class="page-header-row">
    <div class="page-header-title">
        <i class="fa-solid fa-envelope-open-text me-2" style="color:var(--forest-mid);"></i>Enquiries & Messages
    </div>
    <?php if ($active_tab === 'newsletter'): ?>
    <a href="?tab=newsletter&export=csv" class="btn-forest" style="text-decoration:none;padding:8px 18px;border-radius:8px;">
        <i class="fa-solid fa-file-csv"></i> Export CSV
    </a>
    <?php endif; ?>
</div>

<?php if ($message): ?>
<div class="dm-alert dm-alert-<?= $message_type ?> mb-3">
    <i class="fa-solid fa-<?= $message_type === 'success' ? 'circle-check' : 'circle-exclamation' ?>"></i>
    <?= htmlspecialchars($message) ?>
</div>
<?php endif; ?>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon-wrap si-amber"><i class="fa-solid fa-file-invoice-dollar"></i></div>
            <div class="stat-label">Bulk Enquiries</div>
            <div class="stat-value"><?= count($bulk_enquiries) ?></div>
            <div class="stat-sub"><?= $pending_enq ?> pending</div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon-wrap si-teal"><i class="fa-solid fa-envelope"></i></div>
            <div class="stat-label">Contact Messages</div>
            <div class="stat-value"><?= count($contact_messages) ?></div>
            <div class="stat-sub"><?= $unread_msg ?> unread</div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon-wrap si-green"><i class="fa-solid fa-newspaper"></i></div>
            <div class="stat-label">Subscribers</div>
            <div class="stat-value"><?= count($subscribers) ?></div>
            <div class="stat-sub">newsletter list</div>
        </div>
    </div>
</div>

<!-- Tabs -->
<div style="display:flex;gap:4px;margin-bottom:16px;border-bottom:1px solid #eee;padding-bottom:0;">
    <?php
    $tabs = [
        'enquiries'  => ['label'=>'Bulk Enquiries',    'icon'=>'fa-file-invoice-dollar', 'count'=>count($bulk_enquiries),   'badge'=>$pending_enq > 0 ? $pending_enq : null],
        'messages'   => ['label'=>'Contact Messages',  'icon'=>'fa-envelope',            'count'=>count($contact_messages), 'badge'=>$unread_msg > 0 ? $unread_msg : null],
        'newsletter' => ['label'=>'Newsletter',        'icon'=>'fa-newspaper',           'count'=>count($subscribers),      'badge'=>null],
    ];
    foreach ($tabs as $key => $tab): $isActive = $active_tab === $key; ?>
    <a href="?tab=<?= $key ?>"
       style="display:flex;align-items:center;gap:7px;padding:10px 16px;font-size:13px;font-weight:600;text-decoration:none;border-bottom:2px solid <?= $isActive ? 'var(--forest)' : 'transparent' ?>;color:<?= $isActive ? 'var(--forest)' : '#888' ?>;margin-bottom:-1px;transition:color 0.15s;">
        <i class="fa-solid <?= $tab['icon'] ?>"></i>
        <?= $tab['label'] ?>
        <span style="background:<?= $isActive ? 'var(--forest)' : '#eee' ?>;color:<?= $isActive ? '#fff' : '#888' ?>;font-size:10px;padding:2px 7px;border-radius:10px;font-weight:700;">
            <?= $tab['count'] ?>
        </span>
        <?php if ($tab['badge']): ?>
        <span style="background:#faeeda;color:#854f0b;font-size:10px;padding:2px 6px;border-radius:10px;font-weight:700;">
            <?= $tab['badge'] ?> new
        </span>
        <?php endif; ?>
    </a>
    <?php endforeach; ?>
</div>

<!-- BULK ENQUIRIES TAB -->
<?php if ($active_tab === 'enquiries'): ?>
<div class="dm-card">
    <div style="overflow-x:auto;">
        <table class="dm-table">
            <thead>
                <tr>
                    <th>#</th>
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
                        <td style="color:#aaa;font-size:12px;"><?= $e['id'] ?></td>
                        <td>
                            <div style="font-weight:600;color:#111;"><?= htmlspecialchars($e['name']) ?></div>
                            <div style="font-size:11px;color:#aaa;"><?= htmlspecialchars($e['company_name']) ?></div>
                        </td>
                        <td style="font-size:13px;"><?= htmlspecialchars($e['product_name']) ?></td>
                        <td>
                            <span class="dm-badge badge-dark"><?= number_format($e['quantity']) ?> pcs</span>
                        </td>
                        <td>
                            <div style="font-size:12px;"><i class="fa-solid fa-phone" style="color:#aaa;width:14px;"></i> <?= htmlspecialchars($e['phone']) ?></div>
                            <div style="font-size:12px;margin-top:2px;"><i class="fa-solid fa-envelope" style="color:#aaa;width:14px;"></i> <?= htmlspecialchars($e['email']) ?></div>
                        </td>
                        <td>
                            <span class="dm-badge <?=
                                $e['status']==='replied' ? 'badge-success' :
                                ($e['status']==='closed' ? 'badge-secondary' : 'badge-warning')
                            ?>">
                                <?= ucfirst($e['status']) ?>
                            </span>
                        </td>
                        <td style="color:#aaa;font-size:12px;"><?= date('d M Y', strtotime($e['created_at'])) ?></td>
                        <td>
                            <div style="display:flex;gap:5px;flex-wrap:wrap;">
                                <?php if ($e['status'] === 'pending'): ?>
                                <a href="?tab=enquiries&mark_replied=<?= $e['id'] ?>"
                                   class="dm-badge badge-success"
                                   style="text-decoration:none;padding:5px 9px;border-radius:6px;" title="Mark as replied">
                                    <i class="fa-solid fa-check"></i>
                                </a>
                                <?php endif; ?>
                                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $e['phone']) ?>?text=Hi%20<?= urlencode($e['name']) ?>,%20your%20bulk%20enquiry%20for%20<?= urlencode($e['product_name']) ?>%20has%20been%20received."
                                   target="_blank"
                                   class="dm-badge"
                                   style="background:#e8faf0;color:#15803d;text-decoration:none;padding:5px 9px;border-radius:6px;" title="WhatsApp">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                                <a href="?tab=enquiries&delete=<?= $e['id'] ?>"
                                   class="dm-badge badge-danger"
                                   style="text-decoration:none;padding:5px 9px;border-radius:6px;" title="Delete"
                                   onclick="return confirm('Delete this enquiry?')">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php if ($e['address'] || $e['message']): ?>
                    <tr style="background:#fafaf8;">
                        <td colspan="8" style="font-size:12px;color:#888;padding:6px 14px;">
                            <?php if ($e['address']): ?>
                                <i class="fa-solid fa-location-dot me-1" style="color:#bbb;"></i>
                                <strong>Address:</strong> <?= htmlspecialchars($e['address']) ?>
                            <?php endif; ?>
                            <?php if ($e['message']): ?>
                                &nbsp;&nbsp;<i class="fa-solid fa-comment me-1" style="color:#bbb;"></i>
                                <strong>Note:</strong> <?= htmlspecialchars($e['message']) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8" style="text-align:center;padding:40px;color:#aaa;">No bulk enquiries yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- CONTACT MESSAGES TAB -->
<?php elseif ($active_tab === 'messages'): ?>
<div class="dm-card">
    <div style="overflow-x:auto;">
        <table class="dm-table">
            <thead>
                <tr><th>#</th><th>Name</th><th>Subject</th><th>Email</th><th>Phone</th><th>Status</th><th>Date</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php if (!empty($contact_messages)): ?>
                    <?php foreach ($contact_messages as $m): ?>
                    <tr style="<?= $m['status']==='unread' ? 'font-weight:600;' : '' ?>">
                        <td style="color:#aaa;font-size:12px;"><?= $m['id'] ?></td>
                        <td style="font-weight:600;"><?= htmlspecialchars($m['name']) ?></td>
                        <td><?= htmlspecialchars($m['subject']) ?></td>
                        <td style="font-size:12px;"><?= htmlspecialchars($m['email']) ?></td>
                        <td style="font-size:12px;"><?= htmlspecialchars($m['phone']) ?></td>
                        <td>
                            <span class="dm-badge <?=
                                $m['status']==='replied' ? 'badge-success' :
                                ($m['status']==='read'   ? 'badge-info'    : 'badge-warning')
                            ?>">
                                <?= ucfirst($m['status']) ?>
                            </span>
                        </td>
                        <td style="color:#aaa;font-size:12px;"><?= date('d M Y', strtotime($m['created_at'])) ?></td>
                        <td>
                            <div style="display:flex;gap:5px;">
                                <a href="?tab=messages&mark_replied=<?= $m['id'] ?>"
                                   class="dm-badge badge-success"
                                   style="text-decoration:none;padding:5px 9px;border-radius:6px;" title="Mark replied">
                                    <i class="fa-solid fa-check"></i>
                                </a>
                                <a href="mailto:<?= htmlspecialchars($m['email']) ?>?subject=Re: <?= urlencode($m['subject']) ?>"
                                   class="dm-badge badge-info"
                                   style="text-decoration:none;padding:5px 9px;border-radius:6px;" title="Reply via email">
                                    <i class="fa-solid fa-reply"></i>
                                </a>
                                <a href="?tab=messages&delete=<?= $m['id'] ?>"
                                   class="dm-badge badge-danger"
                                   style="text-decoration:none;padding:5px 9px;border-radius:6px;" title="Delete"
                                   onclick="return confirm('Delete this message?')">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr style="background:#fafaf8;">
                        <td colspan="8" style="font-size:12px;color:#888;padding:6px 14px;">
                            <i class="fa-solid fa-comment me-1" style="color:#bbb;"></i>
                            <strong>Message:</strong> <?= htmlspecialchars($m['message']) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8" style="text-align:center;padding:40px;color:#aaa;">No contact messages yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- NEWSLETTER TAB -->
<?php elseif ($active_tab === 'newsletter'): ?>
<div class="dm-card">
    <div style="padding:14px 18px;border-bottom:1px solid #f0f0f0;display:flex;align-items:center;justify-content:space-between;">
        <span style="font-size:13px;font-weight:600;color:#111;">
            Newsletter Subscribers <span style="font-size:12px;font-weight:400;color:#aaa;">(<?= count($subscribers) ?> total)</span>
        </span>
        <a href="?tab=newsletter&export=csv" class="btn-forest" style="text-decoration:none;padding:6px 16px;border-radius:7px;font-size:12px;">
            <i class="fa-solid fa-file-csv me-1"></i> Export CSV
        </a>
    </div>
    <div style="overflow-x:auto;">
        <table class="dm-table">
            <thead>
                <tr><th>#</th><th>Email Address</th><th>Subscribed On</th></tr>
            </thead>
            <tbody>
                <?php if (!empty($subscribers)): ?>
                    <?php foreach ($subscribers as $i => $s): ?>
                    <tr>
                        <td style="color:#aaa;font-size:12px;"><?= $i + 1 ?></td>
                        <td style="font-weight:500;"><?= htmlspecialchars($s['email']) ?></td>
                        <td style="color:#aaa;font-size:12px;"><?= date('d M Y, H:i', strtotime($s['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3" style="text-align:center;padding:40px;color:#aaa;">No subscribers yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>