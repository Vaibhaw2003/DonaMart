<?php
// DonaMart/actions/submit_bulk.php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}

$name         = trim(filter_input(INPUT_POST, 'name',         FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$company_name = trim(filter_input(INPUT_POST, 'company_name', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$phone        = trim(filter_input(INPUT_POST, 'phone',        FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$email        = trim(filter_input(INPUT_POST, 'email',        FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$product_name = trim(filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$quantity     = intval($_POST['quantity'] ?? 0);
$address      = trim(filter_input(INPUT_POST, 'address',      FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$message      = trim(filter_input(INPUT_POST, 'message',      FILTER_SANITIZE_SPECIAL_CHARS) ?? '');

$errors = [];
if (empty($name))                               $errors[] = 'Full name is required.';
if (empty($phone))                              $errors[] = 'Phone number is required.';
if (empty($email))                              $errors[] = 'Email is required.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email.';
if (empty($product_name))                       $errors[] = 'Please select a product.';
if ($quantity < 1)                              $errors[] = 'Quantity must be at least 1.';
if (empty($address))                            $errors[] = 'Delivery address is required.';

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO bulk_enquiries 
        (name, company_name, phone, email, product_name, quantity, address, message, status, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())");
    $stmt->execute([$name, $company_name, $phone, $email, $product_name, $quantity, $address, $message]);

    echo json_encode([
        'success' => true,
        'message' => '✅ Your quotation request has been submitted! Our team will contact you within 24 hours.'
    ]);
} catch (PDOException $e) {
    error_log('Bulk enquiry error: ' . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}