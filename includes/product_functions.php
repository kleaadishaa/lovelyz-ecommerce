<?php
function displayProductsByCategory($conn, $category) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE category = ?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        echo "<div class='product-grid'>";
        while ($p = $result->fetch_assoc()) {
            $hasStock = $p['in_stock'] > 0;
            $description = htmlspecialchars($p['description'] ?? '');
            $name = htmlspecialchars($p['name']);
            $image = htmlspecialchars($p['image']);
            $disabled = !$hasStock ? " disabled" : "";

            echo "
                <div class='product-card " . (!$hasStock ? "out-of-stock-card" : "") . "' data-id='{$p['id']}'>
                    <img class='product-img' src='{$image}' alt='{$name}'>
                    <h3 class='product-title'>{$name}</h3>
                    <p class='price'>
                        <span class='new-price'>" . number_format($p['price'], 2) . " €</span>
                    </p>
                    <p class='" . ($hasStock ? "in-stock" : "out-of-stock") . "'>
                        " . ($hasStock ? "In stock ({$p['in_stock']})" : "Out of stock") . "
                    </p>
                    <div class='quantity-wrapper'>
                        <button onclick='changeQuantity(this, -1)'{$disabled}>−</button>
                        <input type='number' class='quantity' value='1' min='1' data-max='{$p['in_stock']}' readonly>
                        <button onclick='changeQuantity(this, 1)'{$disabled}>+</button>
                    </div>
                    <button class='detail_button' onclick='toggleDetails(this)'>View Details</button>
                    <div class='details'>{$description}</div>
                    <button class='add-to-cart-btn' onclick='addToCart(\"" . addslashes($p['name']) . "\", {$p['price']}, this)'{$disabled}>
                        Add to Cart 🛒
                    </button>
                </div>
            ";
        }
        echo "</div>";
    }
}
?>