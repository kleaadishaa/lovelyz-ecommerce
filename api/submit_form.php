<?php

ob_start();
ini_set('display_errors', 0); 
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

// --- Database connection ---
include __DIR__ . '/../includes/db.php';

if (!$conn || $conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

// --- Only POST requests ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// --- Get and validate input ---
$name    = trim($_POST['name'] ?? '');
$surname = trim($_POST['surname'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$email   = trim($_POST['email'] ?? '');

if (!$name || !$surname || !$phone || !$email) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
    exit;
}

// --- Check for existing email ---
$stmt = $conn->prepare("SELECT id FROM subscribers WHERE email = ? LIMIT 1");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database error.']);
    exit;
}

$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    echo json_encode(['success' => false, 'message' => 'Email already subscribed.']);
    exit;
}
$stmt->close();

// --- Insert subscriber ---
$stmt = $conn->prepare("INSERT INTO subscribers (name, surname, phone, email) VALUES (?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database error.']);
    exit;
}

$stmt->bind_param("ssss", $name, $surname, $phone, $email);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Subscription successful!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to save.']);
}

$stmt->close();
$conn->close();
exit;