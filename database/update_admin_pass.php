<?php
// database/update_admin_pass.php
// Run this ONCE to set admin password to "admin123" using PHP's bcrypt

require_once __DIR__ . '/../config/db.php';

$password = 'admin123';
$hash = password_hash($password, PASSWORD_BCRYPT);

try {
    $stmt = $pdo->prepare("UPDATE admins SET password = ? WHERE username = 'admin'");
    $stmt->execute([$hash]);
    echo "Admin password updated successfully!\n";
    echo "Username: admin\nPassword: admin123\n";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage() . "\n");
}
?>
