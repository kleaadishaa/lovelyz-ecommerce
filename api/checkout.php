<?php
session_start();
require_once '../includes/db.php';

header('Content-Type: application/json');

$sessionId = session_id();

// ─── GET: Shfaq produktet dhe totalin
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmtOrder = $conn->prepare("
            SELECT id, total_price 
            FROM orders 
            WHERE session_id = ? AND status = 'pending' 
            LIMIT 1
        ");
        $stmtOrder->bind_param("s", $sessionId);
        $stmtOrder->execute();
        $order = $stmtOrder->get_result()->fetch_assoc();
        $stmtOrder->close();

        if (!$order) {
            echo json_encode(['success' => false, 'message' => 'No pending order found.']);
            exit;
        }

        $orderId = $order['id'];

        $stmtDetails = $conn->prepare("
            SELECT product_name AS name, price, quantity, (price * quantity) AS total
            FROM order_details 
            WHERE order_id = ?
        ");
        $stmtDetails->bind_param("i", $orderId);
        $stmtDetails->execute();
        $items = $stmtDetails->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmtDetails->close();

        echo json_encode([
            'success'   => true,
            'cartItems' => $items,
            'total'     => floatval($order['total_price'])
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    // ─── POST: Konfirmo pagesën
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmtOrder = $conn->prepare("
            SELECT id 
            FROM orders 
            WHERE session_id = ? AND status = 'pending' 
            LIMIT 1
        ");
        $stmtOrder->bind_param("s", $sessionId);
        $stmtOrder->execute();
        $order = $stmtOrder->get_result()->fetch_assoc();
        $stmtOrder->close();

        if (!$order) {
            echo json_encode(['success' => false, 'message' => 'No pending order found.']);
            exit;
        }

        $orderId = $order['id'];

        $update = $conn->prepare("UPDATE orders SET status = 'completed' WHERE id = ?");
        $update->bind_param("i", $orderId);
        $update->execute();
        $update->close();

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

$conn->close();
