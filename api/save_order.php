<?php
session_start();
header('Content-Type: application/json');
include '../includes/db.php';

// Get cart from POST body
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['cart']) || !is_array($input['cart']) || empty($input['cart'])) {
    echo json_encode(['success' => false, 'message' => 'Cart is empty or invalid.']);
    exit;
}

$sessionId = session_id();
$conn->begin_transaction();

try {
    // Calculate total price
    $totalPrice = 0;
    foreach ($input['cart'] as $item) {
        $totalPrice += floatval($item['price']) * intval($item['quantity']);
    }

    // Remove any previous pending order for this session
    $delDetails = $conn->prepare("
        DELETE od 
        FROM order_details od
        JOIN orders o ON od.order_id = o.id
        WHERE o.session_id = ? AND o.status = 'pending'
    ");
    $delDetails->bind_param("s", $sessionId);
    $delDetails->execute();
    $delDetails->close();

    $delOrder = $conn->prepare("DELETE FROM orders WHERE session_id = ? AND status = 'pending'");
    $delOrder->bind_param("s", $sessionId);
    $delOrder->execute();
    $delOrder->close();

    // Insert new order
    $stmtOrder = $conn->prepare("
        INSERT INTO orders (session_id, status, total_price, created_at) 
        VALUES (?, 'pending', ?, NOW())
    ");
    $stmtOrder->bind_param("sd", $sessionId, $totalPrice);
    $stmtOrder->execute();
    $orderId = $stmtOrder->insert_id;
    $stmtOrder->close();

    //  Prepare order_details insert
    $stmtDetails = $conn->prepare("
        INSERT INTO order_details (order_id, product_id, product_name, price, quantity)
        VALUES (?, ?, ?, ?, ?)
    ");

    //  Prepare stock update
    $updateStock = $conn->prepare("
        UPDATE products SET in_stock = in_stock - ? 
        WHERE id = ? AND in_stock >= ?
    ");

    foreach ($input['cart'] as $item) {
        $productId   = intval($item['id']);
        $productName = $item['name'];
        $price       = floatval($item['price']);
        $quantity    = intval($item['quantity']);

        if ($productId <= 0 || $quantity <= 0 || $price <= 0) continue;

        // Deduct stock
        $updateStock->bind_param("iii", $quantity, $productId, $quantity);
        $updateStock->execute();
        if ($updateStock->affected_rows === 0) {
            throw new Exception("Not enough stock for product: $productName");
        }

        // Insert into order_details
        $stmtDetails->bind_param("iisdi", $orderId, $productId, $productName, $price, $quantity);
        $stmtDetails->execute();
    }

    $stmtDetails->close();
    $updateStock->close();

    $conn->commit();
    echo json_encode(['success' => true, 'order_id' => $orderId]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
