<?php
// actions/bulk_enquiry.php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $company_name = filter_input(INPUT_POST, 'company_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $product_name = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($name) || empty($phone) || empty($email) || empty($quantity) || empty($address)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Please enter a valid email address.']);
        exit;
    }

    if ($quantity <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Quantity must be a positive number.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO bulk_enquiries (name, company_name, phone, email, product_name, quantity, address, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $company_name, $phone, $email, $product_name, $quantity, $address, $message]);

        echo json_encode(['status' => 'success', 'message' => 'Your quotation request has been submitted successfully. Our sales team will contact you shortly!']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error. Please try again later.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
