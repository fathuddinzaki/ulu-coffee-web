<?php
// Deteksi lingkungan: Localhost vs Online Hosting
$host_server = $_SERVER['HTTP_HOST'] ?? 'localhost';
$is_local = (strpos($host_server, 'localhost') !== false || strpos($host_server, '127.0.0.1') !== false || php_sapi_name() === 'cli');

if ($is_local) {
    // Pengaturan Localhost (XAMPP)
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "ulu_coffee";
} else {
    // Pengaturan Hosting InfinityFree
    $db_host = "sql304.infinityfree.com";
    $db_user = "if0_41889957";
    $db_pass = "uluCoffee12";
    $db_name = "if0_41889957_ulucoffee";
}

// Inisialisasi koneksi MySQL
$conn = @new mysqli($db_host, $db_user, $db_pass, $db_name);

// Fallback otomatis jika remote gagal saat dijalankan lokal
if ($conn->connect_error && !$is_local) {
    $conn = @new mysqli("localhost", "root", "", "ulu_coffee");
}

if ($conn->connect_error) {
    die("Koneksi Database Gagal: " . $conn->connect_error . ". Pastikan MySQL aktif dan database 'ulu_coffee' sudah diimpor.");
}
?>