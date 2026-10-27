<?php
// Run this once to migrate data or ensure status exists
$file = 'data/orders.json';
if (file_exists($file)) {
    $orders = json_decode(file_get_contents($file), true);
    if ($orders) {
        foreach ($orders as &$order) {
            if (!isset($order['status'])) {
                $order['status'] = 'Pending';
            }
        }
        file_put_contents($file, json_encode($orders, JSON_PRETTY_PRINT));
        echo "Orders updated with default status.";
    }
}
?>
