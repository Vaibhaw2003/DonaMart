<?php
// config/db.php

$host   = 'localhost';
$dbname = 'donamart_db';   // ← apna database name yahan likho
$user   = 'root';       // ← XAMPP default username
$pass   = '';           // ← XAMPP mein default password BLANK hota hai

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    // Show friendly error
    die("
    <div style='font-family:sans-serif;max-width:500px;margin:80px auto;padding:30px;
                border:1px solid #f7c1c1;border-radius:12px;background:#fcebeb;color:#a32d2d;'>
        <h3 style='margin:0 0 10px;'>⚠️ Database Connection Failed</h3>
        <p style='margin:0 0 8px;font-size:13px;'><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>
        <hr style='border:none;border-top:1px solid #f7c1c1;margin:14px 0;'>
        <p style='font-size:12px;margin:0;color:#c0392b;'>
            <strong>Fix karo:</strong><br>
            1. XAMPP mein MySQL <strong>Start</strong> karo<br>
            2. <code>config/db.php</code> mein <code>\$dbname</code> sahi karo<br>
            3. XAMPP ka default password <strong>blank</strong> hota hai
        </p>
    </div>
    ");
}