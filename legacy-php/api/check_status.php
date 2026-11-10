<?php
require_once '../includes/db.php';
require_once '../includes/payment_config.php';

header('Content-Type: application/json');

$order_id = $_GET['order_id'] ?? null;

if (!$order_id) {
    echo json_encode(['status' => 'error', 'message' => 'Order ID required']);
    exit;
}

// 1. Get Status from Midtrans API
$url = MIDTRANS_IS_PRODUCTION 
    ? 'https://api.midtrans.com/v2/' . $order_id . '/status'
    : 'https://api.sandbox.midtrans.com/v2/' . $order_id . '/status';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json',
    'Authorization: Basic ' . base64_encode(MIDTRANS_SERVER_KEY . ':')
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200) {
    echo json_encode(['status' => 'error', 'message' => 'Midtrans Error: ' . $httpCode, 'details' => $response]);
    exit;
}

$result = json_decode($response, true);
$transaction_status = $result['transaction_status'] ?? 'unknown';
$fraud_status = $result['fraud_status'] ?? '';

// 2. Determine Local Status
$newStatus = 'Pending';
if ($transaction_status == 'capture') {
    if ($fraud_status == 'challenge') {
        $newStatus = 'Challenge';
    } else {
        $newStatus = 'Completed'; // Paid
    }
} else if ($transaction_status == 'settlement') {
    $newStatus = 'Completed';
} else if ($transaction_status == 'pending') {
    $newStatus = 'Pending';
} else if ($transaction_status == 'deny' || $transaction_status == 'expire' || $transaction_status == 'cancel') {
    $newStatus = 'Cancelled';
}

// 3. Update Database
$stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
$stmt->bind_param("ss", $newStatus, $order_id);
if ($stmt->execute()) {
    echo json_encode([
        'status' => 'success', 
        'data' => [
            'status' => $newStatus, 
            'midtrans_status' => $transaction_status
        ]
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database Update Failed']);
}
?>
