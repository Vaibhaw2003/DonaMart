<?php
// actions/subscribe_newsletter.php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}

$email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));

if (!$email) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

try {
    // Check if already subscribed
    $check = $pdo->prepare("SELECT id FROM newsletter_subscribers WHERE email = ?");
    $check->execute([$email]);
    if ($check->fetch()) {
        echo json_encode(['success' => false, 'message' => 'You are already subscribed. Thank you!']);
        exit;
    }
    $stmt = $pdo->prepare("INSERT INTO newsletter_subscribers (email, created_at) VALUES (?, NOW())");
    $stmt->execute([$email]);
    echo json_encode(['success' => true, 'message' => '🎉 You\'re subscribed! Welcome to the DonaMart family.']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Something went wrong. Please try again.']);
}