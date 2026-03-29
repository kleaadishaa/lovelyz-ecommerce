<?php
class OrderModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getPendingOrder($sessionId)
    {
        $stmt = $this->conn->prepare(
            "SELECT id, total_price 
             FROM orders 
             WHERE session_id = ? AND status = 'pending' 
             LIMIT 1"
        );
        $stmt->bind_param("s", $sessionId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getOrderDetails($orderId)
    {
        $stmt = $this->conn->prepare(
            "SELECT product_name AS name, price, quantity, (price * quantity) AS total
             FROM order_details 
             WHERE order_id = ?"
        );
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function completeOrder($orderId)
    {
        $stmt = $this->conn->prepare(
            "UPDATE orders SET status = 'completed' WHERE id = ?"
        );
        $stmt->bind_param("i", $orderId);
        return $stmt->execute();
    }
}
