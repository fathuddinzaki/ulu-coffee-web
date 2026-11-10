<?php
require_once '../includes/db.php';
require_once '../includes/payment_config.php';

header('Content-Type: application/json');

// Handle Notification from Midtrans
$json_result = file_get_contents('php://input');
$result = json_decode($json_result, true);

if ($result) {
    $order_id = $result['order_id'];
    $transaction_status = $result['transaction_status'];
    $fraud_status = $result['fraud_status'];
    $payment_type = $result['payment_type'];
    
    // Hash Validation (Security)
    $signature_key = $result['signature_key'];
    $valid_signature = hash("sha512", $order_id . $result['status_code'] . $result['gross_amount'] . MIDTRANS_SERVER_KEY);
    
    if ($signature_key !== $valid_signature) {
        http_response_code(403);
        echo json_encode(['status' => 'error', 'message' => 'Invalid Signature']);
        exit;
    }

    // Logic Status Update
    $status = 'Pending';
    if ($transaction_status == 'capture') {
        if ($fraud_status == 'challenge') {
            $status = 'Challenge';
        } else {
            $status = 'Paid'; // Success
        }
    } else if ($transaction_status == 'settlement') {
        $status = 'Paid'; // Success
    } else if ($transaction_status == 'pending') {
        $status = 'Pending';
    } else if ($transaction_status == 'deny' || $transaction_status == 'expire' || $transaction_status == 'cancel') {
        $status = 'Failed';
    }

    // Update Database
    if ($status === 'Paid') {
        // Change to 'Completed' or 'Processing' depending on your flow. 
        // Here we use 'Completed' as per existing flow, or 'Paid' if you add a new status.
        // Existing flow uses 'Completed' for done. Let's use 'Completed'.
        $stmt = $conn->prepare("UPDATE orders SET status = 'Completed' WHERE id = ?");
        $stmt->bind_param("s", $order_id);
        $stmt->execute();
    } else if ($status === 'Failed') {
        $stmt = $conn->prepare("UPDATE orders SET status = 'Cancelled' WHERE id = ?");
        $stmt->bind_param("s", $order_id);
        $stmt->execute();
    }
    
    echo json_encode(['status' => 'success']);
} else {
    http_response_code(400);
    echo "Invalid Input";
}
?>
