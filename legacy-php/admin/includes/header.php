<?php
require_once '../includes/functions.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Security Check
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Ulu Coffe</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="assets/css/admin.css?v=<?= time() ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="admin-layout">
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <a href="../index.php" class="sidebar-brand">Ulu Coffe</a>
        </div>
        <nav class="sidebar-menu">
            <a href="index.php" class="menu-item <?= $current_page === 'index.php' ? 'active' : '' ?>">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <a href="products.php" class="menu-item <?= $current_page === 'products.php' ? 'active' : '' ?>">
                <i class="fas fa-shopping-bag"></i> Products
            </a>
            <a href="orders.php" class="menu-item <?= $current_page === 'orders.php' ? 'active' : '' ?>">
                <i class="fas fa-shopping-cart"></i> Orders
            </a>
            <a href="messages.php" class="menu-item <?= $current_page === 'messages.php' ? 'active' : '' ?>">
                <i class="fas fa-envelope"></i> Messages
            </a>
            <a href="users.php" class="menu-item <?= $current_page === 'users.php' ? 'active' : '' ?>">
                <i class="fas fa-users"></i> Users
            </a>
            <a href="pos.php" class="menu-item <?= $current_page === 'pos.php' ? 'active' : '' ?>" style="color: var(--accent); font-weight: bold;">
                <i class="fas fa-cash-register"></i> Kasir (POS)
            </a>
            <a href="http://localhost/phpmyadmin/" target="_blank" class="menu-item">
                <i class="fas fa-database"></i> Database
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="../logout.php" class="menu-item" style="color: #dc3545; padding-left: 0;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>

    <main class="admin-main">
        <header class="admin-header">
            <h2 style="font-size: 1.2rem; margin: 0;">Overview</h2>
            <div class="user-profile">
                <!-- Simple Admin Profile Display -->
            <div class="user-profile">
                <!-- Simple Admin Profile Display -->
                <div class="admin-profile">
                    <div class="admin-info">
                        <span class="admin-name"><?= $_SESSION['user']['name'] ?></span>
                        <span class="admin-role">Administrator</span>
                    </div>
                    <div class="admin-avatar">
                        A
                    </div>
                </div>
            </div>
            </div>
        </header>
        <div class="admin-content">
