<?php 
include 'includes/header.php'; 
require_once 'includes/db.php';

$orderId = $_GET['order_id'] ?? null;
$status = $_GET['status'] ?? 'pending';

if (!$orderId) {
    echo "<script>window.location='index.php';</script>";
    exit;
}

// Fetch Order Details
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("s", $orderId);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    echo "<div class='container page-layout'><div class='alert alert-danger'>Order tidak ditemukan.</div></div>";
    include 'includes/footer.php';
    exit;
}

// Fetch Order Items
$stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
$stmt->bind_param("s", $orderId);
$stmt->execute();
$items = $stmt->get_result();

// Status Mapping
$statusLabel = 'Menunggu Pembayaran';
$statusColor = 'var(--accent)';
$icon = 'fa-clock';

if ($order['status'] == 'Completed' || $status == 'success') {
    $statusLabel = 'Pembayaran Berhasil';
    $statusColor = '#2ecc71';
    $icon = 'fa-check-circle';
} elseif ($order['status'] == 'Cancelled') {
    $statusLabel = 'Dibatalkan';
    $statusColor = '#e74c3c';
    $icon = 'fa-times-circle';
} elseif (strpos($order['payment_method'], 'Tunai') !== false) {
    $statusLabel = 'Silakan Bayar di Kasir';
    $statusColor = '#f39c12'; // Orange/Gold
    $icon = 'fa-cash-register';
}
?>

<div class="container page-layout" style="max-width: 800px; margin: 40px auto;">
    
    <!-- Receipt Styling -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400&display=swap');
        
        .premium-receipt {
            background: #fff;
            max-width: 380px;
            margin: 0 auto;
            font-family: 'Space Mono', monospace;
            color: #333;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            position: relative;
            padding: 30px 25px 50px; /* Extra bottom padding for jagged edge */
        }

        /* Jagged Edge Effect using CSS Gradients */
        .premium-receipt::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 12px;
            background: 
                linear-gradient(135deg, transparent 5px, #f1f5f9 5px) 0 0, 
                linear-gradient(225deg, transparent 5px, #f1f5f9 5px) 0 0;
            background-size: 20px 20px;
            background-repeat: repeat-x;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px dashed #333;
            padding-bottom: 20px;
        }
    
        .receipt-logo {
            width: 70px;
            height: auto;
            margin-bottom: 12px;
            border-radius: 50%;
        }

        .receipt-title {
            font-weight: 700;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .receipt-info {
            font-size: 0.75rem;
            line-height: 1.5;
            color: #555;
        }

        .receipt-body {
            font-size: 0.85rem;
        }

        .receipt-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .receipt-divider {
            border-bottom: 1px dashed #ccc;
            margin: 15px 0;
        }

        .receipt-total {
            font-weight: 700;
            font-size: 1.1rem;
            margin-top: 5px;
        }
        
        .receipt-footer {
            text-align: center;
            font-size: 0.75rem;
            margin-top: 25px;
            opacity: 0.7;
        }

        .status-box {
            text-align: center;
            margin-top: 15px; 
            font-size: 0.8rem;
            padding: 8px;
            border: 1px solid #333;
            border-radius: 4px;
        }
    </style>

    <div class="premium-receipt">
        
        <!-- Header -->
        <div class="receipt-header">
            <img src="assets/img/logo.jpeg" alt="Ulu Coffe" class="receipt-logo">
            <div class="receipt-title">Ulu Coffe</div>
            <div class="receipt-info">
                Jl. Jendral Sudirman No. 123<br>
                Padang, Sumatera Barat<br>
                Telp: 0856-5864-0208
            </div>
        </div>

        <!-- Meta -->
        <div class="receipt-body">
            <div class="receipt-row">
                <span>No Order</span>
                <span style="font-weight: 700;">#<?= substr($orderId, -8) ?></span>
            </div>
            <div class="receipt-row">
                <span>Tanggal</span>
                <span><?= date('d/m/y H:i', strtotime($order['order_date'])) ?></span>
            </div>
            <div class="receipt-row">
                <span>Pelanggan</span>
                <span><?= substr(explode(' ', trim($order['customer_name']))[0], 0, 15) ?></span>
            </div>
            <div class="receipt-divider"></div>
        </div>

        <!-- Items -->
        <div class="receipt-body">
            <?php 
            $items->data_seek(0);
            while($item = $items->fetch_assoc()): 
            ?>
            <div style="margin-bottom: 10px;">
                <div style="font-weight: 700; font-size: 0.9rem;"><?= $item['product_name'] ?></div>
                <div class="receipt-row" style="color: #555;">
                    <span><?= $item['qty'] ?> x <?= number_format($item['price'], 0, ',', '.') ?></span>
                    <span><?= number_format($item['subtotal'], 0, ',', '.') ?></span>
                </div>
            </div>
            <?php endwhile; ?>
            <div class="receipt-divider" style="border-bottom: 2px dashed #333;"></div>
        </div>

        <!-- Total -->
        <div class="receipt-body">
            <div class="receipt-row receipt-total">
                <span>TOTAL</span>
                <span>Rp <?= number_format($order['total'], 0, ',', '.') ?></span>
            </div>
            
            <?php if (strpos($order['payment_method'], 'Tunai') === false): ?>
                <div class="status-box">
                    STATUS: <?= strtoupper($statusLabel) ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Footer -->
        <div class="receipt-footer">
            ~ Terima Kasih ~<br>
            Harap simpan struk ini sebagai bukti pembayaran yang sah.
        </div>

        <!-- Actions -->
        <?php
        $backLink = 'index.php';
        if (isset($_GET['from']) && $_GET['from'] === 'pos') {
            $backLink = 'admin/index.php';
        } elseif (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
            $backLink = 'admin/index.php';
        }
        ?>
        <div class="no-print" style="margin-top: 30px; display: flex; gap: 10px; justify-content: center;">
            <button onclick="window.print()" class="btn btn-primary" style="font-family: inherit; font-size: 0.8rem; padding: 8px 16px; min-width: 100px;">
                <i class="fas fa-print"></i> CETAK
            </button>
            <a href="<?= $backLink ?>" class="btn btn-outline" style="font-family: inherit; font-size: 0.8rem; padding: 8px 16px; border-color: #333; color: #333; min-width: 100px;">
                TUTUP
            </a>
        </div>

    </div>
</div>

<script>
document.getElementById('btn-check-status')?.addEventListener('click', function() {
    const btn = this;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memeriksa...';
    btn.disabled = true;

    fetch('api/check_status.php?order_id=<?= $orderId ?>')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                if (data.data.status === 'Completed') {
                    alert('Pembayaran BERHASIL dikonfirmasi! Halaman akan dimuat ulang.');
                    location.reload();
                } else if (data.data.status === 'Cancelled') {
                    alert('Pesanan telah DIBATALKAN.');
                    location.reload();
                } else {
                    alert('Status masih: ' + data.data.midtrans_status + ' (' + data.data.status + ').\nSilakan tunggu beberapa saat lagi jika Anda baru saja membayar.');
                }
            } else {
                alert('Gagal mengecek status: ' + data.message);
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan koneksi.');
        })
        .finally(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
});
</script>

<?php include 'includes/footer.php'; ?>

