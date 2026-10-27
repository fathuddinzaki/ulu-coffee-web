<?php
session_start();

// Security Check
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'] ?? null;
if ($id) {
    global $conn;
    // Note: session_start() and require 'header.php' (which has db.php via functions.php?) 
    // Wait, product_delete.php has manual session_start and no header include.
    // So we must include db.php manually.
    require_once '../includes/db.php';
    
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header('Location: products.php');
exit;
