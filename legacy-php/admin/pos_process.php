<?php
session_start();
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cartData = json_decode($_POST['cart_data'], true);
    $customerName = $_POST['customer_name'] ?? 'Guest';
    
    if (empty($cartData)) {
        header('Location: pos.php?error=empty_cart');
        exit;
    }

    $orderId = uniqid('ORD-');
    $date = date('Y-m-d H:i:s');
    $total = 0;

    // Calculate Total
    foreach ($cartData as $item) {
        $total += $item['price'] * $item['qty'];
    }

    // Save Order (Method "Tunai", Status "Completed" directly)
    // We use a dummy email/phone for Guest walk-ins if not provided
    $stmt = $conn->prepare("INSERT INTO orders (id, user_email, customer_name, customer_phone, customer_address, total, status, order_date, payment_method) VALUES (?, 'admin@pos.com', ?, '-', 'In-Store Purchase', ?, 'Completed', ?, 'Tunai (Bayar di Kasir)')");
    
    // Bind: s (id), s (name), d (total), s (date)
    $stmt->bind_param("ssds", $orderId, $customerName, $total, $date);
    
    if ($stmt->execute()) {
        // Save Items
        $stmtItem = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, price, qty, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
        
        foreach ($cartData as $item) {
            $subtotal = $item['price'] * $item['qty'];
            // Bind: s (order_id), i (product_id), s (name), d (price), i (qty), d (subtotal)
            $stmtItem->bind_param("sisdid", $orderId, $item['id'], $item['name'], $item['price'], $item['qty'], $subtotal);
            $stmtItem->execute();
        }
        
        // Redirect to Receipt (Root level thankyou.php)
        header('Location: ../thankyou.php?order_id=' . $orderId . '&status=success&from=pos');
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    header('Location: pos.php');
}
