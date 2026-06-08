<?php
// database/init_db.php

$host = '127.0.0.1';
$port = 3307;
$user = 'root';
$used_pass = '';

try {
    $pdo = new PDO("mysql:host=$host;port=$port", $user, $used_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed on port 3307: " . $e->getMessage() . "\n");
}

try {
    // Read the SQL schema file
    $sqlFile = __DIR__ . '/donamart_db.sql';

    if (!file_exists($sqlFile)) {
        die("SQL file not found at: $sqlFile\n");
    }

    $sql = file_get_contents($sqlFile);

    // Run the schema queries
    echo "Initializing database...\n";
    $pdo->exec($sql);
    echo "Database and tables created successfully!\n";

    // Update config/db.php with working password
    $configFile = dirname(__DIR__) . '/config/db.php';
    if (file_exists($configFile)) {
        $configContent = file_get_contents($configFile);
        $configContent = preg_replace("/\\\$pass\s*=\s*['\"].*?['\"];/", "\$pass = '$used_pass';", $configContent);
        file_put_contents($configFile, $configContent);
        echo "Updated config/db.php with the working password: '$used_pass'\n";
    }

} catch (PDOException $e) {
    die("Database initialization failed: " . $e->getMessage() . "\n");
}
?>
