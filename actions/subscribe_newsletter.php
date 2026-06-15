<?php
// DonaMart/actions/subscribe_newsletter.php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}

$email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL) ?? '');

if (!$email) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

try {
    $check = $pdo->prepare("SELECT id FROM newsletter_subscribers WHERE email = ?");
    $check->execute([$email]);
    if ($check->fetch()) {
        echo json_encode(['success' => false, 'message' => 'You are already subscribed!']);
        exit;
    }
    $pdo->prepare("INSERT INTO newsletter_subscribers (email, created_at) VALUES (?, NOW())")->execute([$email]);
    echo json_encode(['success' => true, 'message' => '🎉 Subscribed successfully! Welcome to DonaMart.']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}