<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db.php';

// -- Product Functions --
function getProducts() {
    global $conn;
    $sql = "SELECT * FROM products ORDER BY id DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getProductById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function filterProducts($category = null, $search = null) {
    global $conn;
    $sql = "SELECT * FROM products WHERE 1=1";
    $types = "";
    $params = [];

    if ($category) {
        $sql .= " AND category = ?";
        $types .= "s";
        $params[] = $category;
    }

    if ($search) {
        $sql .= " AND (name LIKE ? OR description LIKE ?)";
        $types .= "ss";
        $searchTerm = "%" . $search . "%";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
    }

    if (empty($params)) {
        return getProducts();
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function formatRupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}

// -- Cart Functions --
function addToCart($id, $qty = 1) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += $qty;
    } else {
        $_SESSION['cart'][$id] = $qty;
    }
}

function getCartCount() {
    if (!isset($_SESSION['cart'])) return 0;
    return array_sum($_SESSION['cart']);
}

function getCartDetails() {
    $cartItems = [];
    $total = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $id => $qty) {
            $product = getProductById($id);
            if ($product) {
                $product['qty'] = $qty;
                $product['subtotal'] = $product['price'] * $qty;
                $cartItems[] = $product;
                $total += $product['subtotal'];
            }
        }
    }
    return ['items' => $cartItems, 'total' => $total];
}

// -- User Auth Functions --
function getUsers() {
    global $conn;
    $result = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function saveUser($user) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO users (id, name, email, password, created_at, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $user['id'], $user['name'], $user['email'], $user['password'], $user['created_at'], $user['role']);
    return $stmt->execute();
}

function registerUser($name, $email, $password) {
    global $conn;
    
    // Check if email exists
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        return false;
    }

    $id = uniqid('USR-');
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $created_at = date('Y-m-d H:i:s');
    $role = 'user';

    $stmt = $conn->prepare("INSERT INTO users (id, name, email, password, created_at, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $id, $name, $email, $hashed_password, $created_at, $role);
    return $stmt->execute();
}

function loginUser($email, $password) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            return $user;
        }
    }
    return false;
}

function updateUser($id, $name, $phone, $address, $password = null) {
    global $conn;
    
    if ($password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET name = ?, phone = ?, address = ?, password = ? WHERE id = ?");
        $stmt->bind_param("sssss", $name, $phone, $address, $hashed_password, $id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET name = ?, phone = ?, address = ? WHERE id = ?");
        $stmt->bind_param("ssss", $name, $phone, $address, $id);
    }
    
    if ($stmt->execute()) {
        // Refresh session data
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $_SESSION['user'] = $user;
        return true;
    }
    return false;
}

// -- Forgot Password --
function requestPasswordReset($email) {
    global $conn;
    
    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows === 0) {
        return false; // Email not found
    }
    
    $token = bin2hex(random_bytes(32));
    $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
    $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_expiry = ? WHERE email = ?");
    $stmt->bind_param("sss", $token, $expiry, $email);
    
    if ($stmt->execute()) {
        return $token;
    }
    return false;
}

function resetPassword($token, $newPassword) {
    global $conn;
    
    // Verify token
    $now = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_expiry > ?");
    $stmt->bind_param("ss", $token, $now);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expiry = NULL WHERE reset_token = ?");
        $stmt->bind_param("ss", $hashed_password, $token);
        return $stmt->execute();
    }
    return false; // Invalid or expired token
}

// -- Order History --
function buildOrderStructure($orderRow, $items) {
    if (!$orderRow) return null;
    return [
        'id' => $orderRow['id'],
        'date' => $orderRow['order_date'],
        'total' => (int)$orderRow['total'],
        'status' => $orderRow['status'],
        'payment_method' => $orderRow['payment_method'] ?? 'Transfer Bank (Manual)',
        'customer' => [
            'name' => $orderRow['customer_name'],
            'email' => $orderRow['user_email'],
            'phone' => $orderRow['customer_phone'],
            'address' => $orderRow['customer_address']
        ],
        'items' => $items
    ];
}

function getOrderItems($orderId) {
    global $conn;
    $stmt = $conn->prepare("
        SELECT oi.*, p.image, p.category, p.name as original_name 
        FROM order_items oi 
        LEFT JOIN products p ON oi.product_id = p.id 
        WHERE oi.order_id = ?
    ");
    $stmt->bind_param("s", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    $items = [];
    while ($row = $result->fetch_assoc()) {
        if (empty($row['image'])) $row['image'] = 'assets/img/products/default.jpg';
        if (empty($row['category'])) $row['category'] = 'Uncategorized';
        $row['name'] = !empty($row['original_name']) ? $row['original_name'] : $row['product_name'];
        $items[] = $row;
    }
    return $items;
}

function getAllOrders() {
    global $conn;
    $sql = "SELECT * FROM orders ORDER BY order_date DESC";
    $result = $conn->query($sql);
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $items = getOrderItems($row['id']);
        $orders[] = buildOrderStructure($row, $items);
    }
    return $orders;
}

function getOrderById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if (!$row) return null;
    
    $items = getOrderItems($id);
    return buildOrderStructure($row, $items);
}

function getUserOrders($email) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_email = ? ORDER BY order_date DESC");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $items = getOrderItems($row['id']);
        $orders[] = buildOrderStructure($row, $items);
    }
    return $orders;
}

function getMessages() {
    global $conn;
    $result = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function saveMessage($name, $email, $message) {
    global $conn;
    $id = uniqid('MSG-');
    $stmt = $conn->prepare("INSERT INTO messages (id, name, email, message, created_at, is_read) VALUES (?, ?, ?, ?, NOW(), 0)");
    $stmt->bind_param("ssss", $id, $name, $email, $message);
    return $stmt->execute();
}

?>
