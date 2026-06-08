<?php
require 'config/db.php';
$tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
echo "Tables: " . implode(', ', $tables) . "\n";

$prod_count = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$cat_count  = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
$gallery_count = $pdo->query("SELECT COUNT(*) FROM gallery")->fetchColumn();
echo "Products: $prod_count | Categories: $cat_count | Gallery: $gallery_count\n";

$admin = $pdo->query("SELECT username, email FROM admins LIMIT 1")->fetch();
echo "Admin user: " . $admin['username'] . " (" . $admin['email'] . ")\n";
echo "All OK!\n";
?>
