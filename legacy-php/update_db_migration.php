<?php
require_once 'includes/db.php';

// Add columns for Forgot Password
$sql1 = "ALTER TABLE users ADD COLUMN reset_token VARCHAR(255) NULL AFTER role";
$sql2 = "ALTER TABLE users ADD COLUMN reset_expiry DATETIME NULL AFTER reset_token";

if ($conn->query($sql1) === TRUE) {
    echo "Column 'reset_token' added successfully.<br>";
} else {
    echo "Error adding column 'reset_token': " . $conn->error . "<br>";
}

if ($conn->query($sql2) === TRUE) {
    echo "Column 'reset_expiry' added successfully.<br>";
} else {
    echo "Error adding column 'reset_expiry': " . $conn->error . "<br>";
}

echo "Database update process completed.";
?>
