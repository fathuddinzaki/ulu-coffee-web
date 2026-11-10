<?php
// Midtrans Configuration
// Isi dengan server key dan client key Midtrans sandbox atau production Anda jika ingin mengaktifkan pembayaran online
define('MIDTRANS_SERVER_KEY', 'SB-Mid-server-placeholder'); 
define('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-placeholder');
define('MIDTRANS_IS_PRODUCTION', false); // Set to true untuk Production

// URL API Midtrans
define('MIDTRANS_SNAP_URL', MIDTRANS_IS_PRODUCTION 
    ? 'https://app.midtrans.com/snap/snap.js' 
    : 'https://app.sandbox.midtrans.com/snap/snap.js');
?>

