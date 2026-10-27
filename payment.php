<?php include 'includes/header.php'; ?>
<?php
require_once 'includes/payment_config.php';

$id = $_GET['order_id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

// Check Order
$order = getOrderById($id); // Assuming this function exists or we use raw query
// Re-implement basic fetch if function not available in scoped context
if (!$order) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();
}

if (!$order) {
    echo "Order not found.";
    exit;
    exit;
}
$paymentMethod = $_GET['method'] ?? 'midtrans'; // Default to auto
?>

<div class="container page-layout">
    <div style="max-width: 500px; margin: 40px auto; text-align: center;">
        <div style="background: var(--white); padding: 40px; border-radius: 12px; box-shadow: var(--shadow); border: 1px solid var(--border);">
            <i class="fas fa-wallet" style="font-size: 4rem; color: var(--accent); margin-bottom: 20px;"></i>
            <h2 style="margin-bottom: 10px;">Selesaikan Pembayaran</h2>
            <p style="color: var(--text-light); margin-bottom: 30px;">Order ID: <strong><?= $order['id'] ?></strong></p>
            
            <div style="font-size: 2rem; font-weight: 700; color: var(--primary); margin-bottom: 30px;">
                Rp <?= number_format($order['total'], 0, ',', '.') ?>
            </div>

            <button id="pay-button" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 1.1rem; border-radius: 50px;">
                bayar Sekarang
            </button>
            
            <p style="margin-top: 20px; font-size: 0.9rem; color: var(--text-light); line-height: 1.5;">
                Klik tombol di atas untuk memilih metode pembayaran:<br>
                <strong>BCA, Mandiri, BRI, BNI, GoPay, ShopeePay, QRIS, dll.</strong><br>
                <span style="font-size: 0.8rem; color: var(--text-light);">Pembayaran diamankan oleh Midtrans Gateway</span>
            </p>
        </div>
    </div>
</div>

<script src="<?= MIDTRANS_SNAP_URL ?>" data-client-key="<?= MIDTRANS_CLIENT_KEY ?>"></script>
<script>
    const payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        // Disable button
        payButton.disabled = true;
        payButton.innerHTML = 'Memproses...';

        // Get Token
        fetch('api/payment_token.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ 
                order_id: '<?= $order['id'] ?>',
                payment_type: '<?= $paymentMethod ?>'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.token) {
                // Open Snap
                window.snap.pay(data.token, {
                    onSuccess: function(result){
                        window.location.href = 'thankyou.php?order_id=<?= $order['id'] ?>&status=success';
                    },
                    onPending: function(result){
                        window.location.href = 'thankyou.php?order_id=<?= $order['id'] ?>&status=pending';
                    },
                    onError: function(result){
                        alert("Pembayaran gagal!");
                        payButton.disabled = false;
                        payButton.innerHTML = 'Bayar Sekarang';
                    },
                    onClose: function(){
                        payButton.disabled = false;
                        payButton.innerHTML = 'Bayar Sekarang';
                    }
                });
            } else {
                // FALLBACK: SIMULATION MODE (Agar demo 'jalan' tanpa API Key asli)
                // Jika error karena Key Salah/Dummy, kita anggap 'Simulator Sukses'
                console.warn("Midtrans Error:", data.error);
                
                if (confirm('⚠️ Note: Server Key masih DUMMY/Salah.\n\nApakah Anda ingin MELANJUTKAN sebagai SIMULASI (Anggap Pembayaran Berhasil)?')) {
                    // Simulate Success Redirect
                    window.location.href = 'thankyou.php?order_id=<?= $order['id'] ?>&status=success';
                } else {
                     let errorMsg = data.error;
                    if (data.details) {
                        errorMsg += '\n' + JSON.stringify(data.details);
                    }
                    alert('Gagal mendapatkan token pembayaran.\n' + errorMsg);
                    payButton.disabled = false;
                    payButton.innerHTML = 'Bayar Sekarang';
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan sistem.');
            payButton.disabled = false;
            payButton.innerHTML = 'Bayar Sekarang';
        });
    });
</script>

<?php include 'includes/footer.php'; ?>
