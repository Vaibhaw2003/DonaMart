<?php
// admin/index.php
$admin_page = 'dashboard';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/includes/header.php';

try {
    $prod_count = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    $cat_count  = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
    $enq_count  = $pdo->query("SELECT COUNT(*) FROM bulk_enquiries")->fetchColumn();
    $msg_count  = $pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();
    $sub_count  = $pdo->query("SELECT COUNT(*) FROM newsletter_subscribers")->fetchColumn();
    $pending_enq= $pdo->query("SELECT COUNT(*) FROM bulk_enquiries WHERE status='pending'")->fetchColumn();
    $unread_msg = $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE status='unread'")->fetchColumn();

    $recent_enquiries = $pdo->query("SELECT * FROM bulk_enquiries ORDER BY id DESC LIMIT 5")->fetchAll();
    $recent_messages  = $pdo->query("SELECT * FROM contact_messages ORDER BY id DESC LIMIT 5")->fetchAll();
} catch (PDOException $e) {
    $prod_count = $cat_count = $enq_count = $msg_count = $sub_count = $pending_enq = $unread_msg = 0;
    $recent_enquiries = $recent_messages = [];
}
?>

<div class="page-header-row">
    <div class="page-header-title">Dashboard</div>
    <span style="font-size:12px;color:#999;">
        <?= date('l, d F Y') ?>
    </span>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon-wrap si-green"><i class="fa-solid fa-boxes-stacked"></i></div>
            <div class="stat-label">Products</div>
            <div class="stat-value"><?= $prod_count ?></div>
            <div class="stat-sub">across <?= $cat_count ?> categories</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon-wrap si-amber"><i class="fa-solid fa-file-invoice-dollar"></i></div>
            <div class="stat-label">Bulk Enquiries</div>
            <div class="stat-value"><?= $enq_count ?></div>
            <div class="stat-sub"><?= $pending_enq ?> pending reply</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon-wrap si-teal"><i class="fa-solid fa-envelope"></i></div>
            <div class="stat-label">Messages</div>
            <div class="stat-value"><?= $msg_count ?></div>
            <div class="stat-sub"><?= $unread_msg ?> unread</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon-wrap si-red"><i class="fa-solid fa-users"></i></div>
            <div class="stat-label">Subscribers</div>
            <div class="stat-value"><?= $sub_count ?></div>
            <div class="stat-sub">newsletter list</div>
        </div>
    </div>
</div>

<!-- Recent Tables -->
<div class="row g-3">
    <!-- Recent Bulk Enquiries -->
    <div class="col-lg-7">
        <div class="dm-card">
            <div style="padding:14px 18px;border-bottom:1px solid #f0f0f0;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:13px;font-weight:600;color:#111;">
                    <i class="fa-solid fa-file-invoice-dollar me-2" style="color:#854f0b;"></i>Recent Bulk Enquiries
                </span>
                <a href="/DonaMart/admin/enquiries.php" class="dm-badge badge-warning" style="text-decoration:none;">View all</a>
            </div>
            <div style="overflow-x:auto;">
                <table class="dm-table">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($recent_enquiries)): ?>
                        <?php foreach ($recent_enquiries as $enq): ?>
                        <tr>
                            <td>
                                <div style="font-weight:600;"><?= htmlspecialchars($enq['name']) ?></div>
                                <div style="font-size:11px;color:#aaa;"><?= htmlspecialchars($enq['company_name']) ?></div>
                            </td>
                            <td><?= htmlspecialchars($enq['product_name']) ?></td>
                            <td>
                                <span class="dm-badge badge-dark"><?= number_format($enq['quantity']) ?></span>
                            </td>
                            <td>
                                <span class="dm-badge <?=
                                    $enq['status'] === 'replied' ? 'badge-success' :
                                    ($enq['status'] === 'closed' ? 'badge-secondary' : 'badge-warning')
                                ?>">
                                    <?= ucfirst($enq['status']) ?>
                                </span>
                            </td>
                            <td style="color:#aaa;font-size:12px;"><?= date('d M', strtotime($enq['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" style="text-align:center;color:#bbb;padding:24px;">No enquiries yet.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Messages -->
    <div class="col-lg-5">
        <div class="dm-card">
            <div style="padding:14px 18px;border-bottom:1px solid #f0f0f0;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:13px;font-weight:600;color:#111;">
                    <i class="fa-solid fa-envelope me-2" style="color:#0f6e56;"></i>Recent Messages
                </span>
                <a href="/DonaMart/admin/enquiries.php?tab=messages" class="dm-badge badge-info" style="text-decoration:none;">View all</a>
            </div>
            <div>
                <?php if (!empty($recent_messages)): ?>
                    <?php foreach ($recent_messages as $msg): ?>
                    <div style="display:flex;align-items:flex-start;gap:10px;padding:11px 18px;border-bottom:1px solid #f6f6f6;">
                        <div style="width:7px;height:7px;border-radius:50%;margin-top:5px;flex-shrink:0;
                            background:<?= $msg['status'] === 'unread' ? '#3b6d11' : '#ddd' ?>;"></div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:13px;font-weight:<?= $msg['status']==='unread'?'600':'400' ?>;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                <?= htmlspecialchars(substr($msg['subject'],0,40)) ?>
                            </div>
                            <div style="font-size:11px;color:#aaa;"><?= htmlspecialchars($msg['name']) ?></div>
                        </div>
                        <div style="font-size:11px;color:#bbb;white-space:nowrap;">
                            <?= date('d M', strtotime($msg['created_at'])) ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="text-align:center;color:#bbb;padding:24px;font-size:13px;">No messages yet.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>