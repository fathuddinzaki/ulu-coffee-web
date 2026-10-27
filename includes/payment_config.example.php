<?php
// Midtrans Configuration Example
// Salin file ini menjadi payment_config.php dan isi dengan key Midtrans Anda
define('MIDTRANS_SERVER_KEY', 'YOUR_MIDTRANS_SERVER_KEY'); 
define('MIDTRANS_CLIENT_KEY', 'YOUR_MIDTRANS_CLIENT_KEY');
define('MIDTRANS_IS_PRODUCTION', false); // Set to true untuk Production

// URL API Midtrans
define('MIDTRANS_SNAP_URL', MIDTRANS_IS_PRODUCTION 
    ? 'https://app.midtrans.com/snap/snap.js' 
    : 'https://app.sandbox.midtrans.com/snap/snap.js');
?>
