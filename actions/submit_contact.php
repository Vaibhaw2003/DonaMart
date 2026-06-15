<?php
// DonaMart/actions/submit_contact.php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}

$name    = trim(filter_input(INPUT_POST, 'name',    FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$email   = trim(filter_input(INPUT_POST, 'email',   FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$phone   = trim(filter_input(INPUT_POST, 'phone',   FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$subject = trim(filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$message = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');

$errors = [];
if (empty($name))                              $errors[] = 'Full name is required.';
if (empty($email))                             $errors[] = 'Email is required.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL))$errors[] = 'Enter a valid email.';
if (empty($subject))                           $errors[] = 'Subject is required.';
if (empty($message))                           $errors[] = 'Message is required.';

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO contact_messages 
        (name, email, phone, subject, message, status, created_at)
        VALUES (?, ?, ?, ?, ?, 'unread', NOW())");
    $stmt->execute([$name, $email, $phone, $subject, $message]);

    echo json_encode([
        'success' => true,
        'message' => '✅ Message sent successfully! We\'ll get back to you within 24 hours.'
    ]);
} catch (PDOException $e) {
    error_log('Contact form DB error: ' . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}