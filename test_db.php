<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'includes/db.php';

if ($conn->connect_error) {
    echo "<h1>Koneksi Database Gagal!</h1>";
    echo "<p>Error: " . $conn->connect_error . "</p>";
    echo "<p>Pastikan Anda sudah import file database.sql di phpMyAdmin!</p>";
} else {
    echo "<h1>Koneksi Berhasil!</h1>";
    echo "<p>Database terhubung dengan baik.</p>";
    
    $result = $conn->query("SELECT count(*) as total FROM products");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p>Jumlah produk di database: " . $row['total'] . "</p>";
    } else {
        echo "<p>Gagal mengambil data produk: " . $conn->error . "</p>";
    }
}
?>
