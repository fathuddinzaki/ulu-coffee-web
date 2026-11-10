<?php
require_once '../includes/db.php';
require_once '../includes/payment_config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid Request Method']);
    exit;
}

// Get JSON Input
$input = json_decode(file_get_contents('php://input'), true);
$orderId = $input['order_id'] ?? null;

if (!$orderId) {
    echo json_encode(['error' => 'Order ID Required']);
    exit;
}

// Fetch Order from DB
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("s", $orderId);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    echo json_encode(['error' => 'Order Not Found']);
    exit;
}

// Fetch Items
$stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
$stmt->bind_param("s", $orderId);
$stmt->execute();
$resultItems = $stmt->get_result();
$items = [];
while ($row = $resultItems->fetch_assoc()) {
    $items[] = [
        'id' => $row['product_id'],
        'price' => (int)$row['price'],
        'quantity' => (int)$row['qty'],
        'name' => substr($row['product_name'], 0, 50)
    ];
}

// Prepare Midtrans Payload
$transaction_details = [
    'order_id' => $orderId,
    'gross_amount' => (int)$order['total']
];

$customer_details = [
    'first_name' => $order['customer_name'],
    'email' => $order['user_email'],
    'phone' => $order['customer_phone']
];

$payload = [
    'transaction_details' => $transaction_details,
    'item_details' => $items,
    'customer_details' => $customer_details
];

// Handle Specific Payment Methods
$paymentType = $input['payment_type'] ?? 'midtrans';
$enabled_payments = [];

switch ($paymentType) {
    case 'bca': $enabled_payments = ['bca_va']; break;
    case 'mandiri': $enabled_payments = ['echannel']; break;
    case 'bni': $enabled_payments = ['bni_va']; break;
    case 'bri': $enabled_payments = ['bri_va']; break;
    case 'gopay': $enabled_payments = ['gopay']; break;
    case 'shopeepay': $enabled_payments = ['shopeepay']; break;
    case 'dana': $enabled_payments = ['other_qris', 'gopay']; break; // Dana usually via QRIS
    case 'ovo': $enabled_payments = ['other_qris', 'gopay']; break;  // OVO usually via QRIS
    case 'qris': $enabled_payments = ['other_qris', 'gopay']; break;
    default: $enabled_payments = []; // Show all if 'midtrans' or unknown
}

// if (!empty($enabled_payments)) {
//     $payload['enabled_payments'] = $enabled_payments;
// }

// Check for Dummy Key removed to allow actual API response testing
// if (strpos(MIDTRANS_SERVER_KEY, 'dummy-key') !== false) { ... }

// Call Midtrans API via cURL
$auth = base64_encode(MIDTRANS_SERVER_KEY . ':');
$url = MIDTRANS_IS_PRODUCTION 
    ? 'https://app.midtrans.com/snap/v1/transactions' 
    : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json',
    'Authorization: Basic ' . $auth
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Fix for XAMPP Localhost
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    file_put_contents('midtrans_debug.log', date('Y-m-d H:i:s') . " CURL Error: " . $error_msg . "\n", FILE_APPEND);
}
curl_close($ch);

if ($httpCode === 201 || $httpCode === 200) {
    echo $response; // Returns token and redirect_url
} else {
    // Log Error
    file_put_contents('midtrans_debug.log', date('Y-m-d H:i:s') . " API Error ($httpCode): " . $response . "\n", FILE_APPEND);
    echo json_encode(['error' => 'Midtrans Error (' . $httpCode . ')', 'details' => json_decode($response)]);
}
?>
