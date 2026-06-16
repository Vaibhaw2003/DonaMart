<?php
// DonaMart/setup_admin.php — RUN ONCE THEN DELETE!

$username = 'admin';
$password = 'Admin@123';  // ← Yahi password use karo

// Sirf localhost pe chalega
if (!in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1','::1','localhost'])) {
    die('Access denied.');
}

require_once __DIR__ . '/config/db.php';

try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS admins (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $hashed = password_hash($password, PASSWORD_BCRYPT);

    $check = $pdo->prepare("SELECT id FROM admins WHERE username = ?");
    $check->execute([$username]);

    if ($check->fetch()) {
        $pdo->prepare("UPDATE admins SET password = ? WHERE username = ?")
            ->execute([$hashed, $username]);
        $action = 'updated';
    } else {
        $pdo->prepare("INSERT INTO admins (username, password) VALUES (?, ?)")
            ->execute([$username, $hashed]);
        $action = 'created';
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Admin Setup</title>
        <style>
            *{box-sizing:border-box;margin:0;padding:0}
            body{font-family:sans-serif;min-height:100vh;background:#f5f5f2;
                 display:flex;align-items:center;justify-content:center;}
            .card{background:#fff;border-radius:16px;padding:40px;
                  max-width:420px;width:90%;box-shadow:0 4px 24px rgba(0,0,0,0.08);text-align:center;}
            .icon{font-size:48px;margin-bottom:16px;}
            h2{color:#1b4332;margin-bottom:20px;}
            table{width:100%;border-collapse:collapse;margin-bottom:20px;text-align:left;}
            td{padding:10px 14px;border:1px solid #eee;font-size:14px;}
            td:first-child{background:#f8f8f5;font-weight:600;width:40%;}
            code{background:#f0f0f0;padding:2px 8px;border-radius:4px;}
            .warn{background:#fcebeb;border:1px solid #f7c1c1;border-radius:10px;
                  padding:14px;font-size:13px;color:#a32d2d;margin-bottom:20px;}
            .btn{display:inline-block;background:#1b4332;color:#fff;
                 padding:12px 28px;border-radius:50px;text-decoration:none;
                 font-weight:700;font-size:14px;transition:background 0.2s;}
            .btn:hover{background:#2d6a4f;}
        </style>
    </head>
    <body>
    <div class="card">
        <div class="icon">✅</div>
        <h2>Admin <?= $action ?>!</h2>
        <table>
            <tr><td>Username</td><td><code><?= htmlspecialchars($username) ?></code></td></tr>
            <tr><td>Password</td><td><code><?= htmlspecialchars($password) ?></code></td></tr>
        </table>
        <div class="warn">
            ⚠️ <strong>Is file ko ABHI delete karo!</strong><br>
            <code>DonaMart/setup_admin.php</code>
        </div>
        <a href="/DonaMart/admin/login.php" class="btn">Go to Admin Login →</a>
    </div>
    </body>
    </html>
    <?php
} catch (PDOException $e) {
    echo "<div style='padding:40px;color:red;font-family:sans-serif;'>
        <h3>❌ Error</h3><p>" . htmlspecialchars($e->getMessage()) . "</p>
    </div>";
}