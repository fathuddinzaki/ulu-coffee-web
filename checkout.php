<?php
session_start();
require_once 'includes/functions.php';
require_once 'includes/db.php'; // Ensure DB is connected

$cart = getCartDetails();
$cartItems = $cart['items'];
$total = $cart['total'];

if (empty($cartItems)) {
    header('Location: cart.php');
    exit;
}

// Prefill data if logged in
$user = $_SESSION['user'] ?? null;
$prefillName = $user ? $user['name'] : '';
$prefillEmail = $user ? $user['email'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = uniqid('ORD-');
    $date = date('Y-m-d H:i:s');
    
    // Customer Data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $paymentCode = $_POST['payment'] ?? 'manual';
    
    // Map Payment Code to Readable Name
    $paymentMap = [
        'bca' => 'BCA Virtual Account',
        'mandiri' => 'Mandiri Bill Payment',
        'bri' => 'BRI Virtual Account',
        'bni' => 'BNI Virtual Account',
        'gopay' => 'GoPay',
        'shopeepay' => 'ShopeePay',
        'dana' => 'Dana',
        'ovo' => 'OVO',
        'qris' => 'QRIS',
        'manual' => 'Transfer Manual',
        'tunai' => 'Tunai (Bayar di Kasir)'
    ];
    $paymentMethod = $paymentMap[$paymentCode] ?? 'Otomatis (Midtrans)';

    // Save Order Header
    $stmt = $conn->prepare("INSERT INTO orders (id, user_email, customer_name, customer_phone, customer_address, total, status, order_date, payment_method) VALUES (?, ?, ?, ?, ?, ?, 'Pending', ?, ?)");
    $stmt->bind_param("sssssdss", $orderId, $email, $name, $phone, $address, $total, $date, $paymentMethod);
    
    if ($stmt->execute()) {
        // Save Order Items
        $stmtItem = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, price, qty, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
        
        foreach ($cartItems as $item) {
            $subtotal = $item['price'] * $item['qty'];
            $stmtItem->bind_param("sisdid", $orderId, $item['id'], $item['name'], $item['price'], $item['qty'], $subtotal);
            $stmtItem->execute();
        }
        
        unset($_SESSION['cart']);

        // Redirect based on payment method
        if ($paymentCode !== 'manual' && $paymentCode !== 'tunai') {
            // Treats bca, gopay, etc as midtrans flow
            header('Location: payment.php?order_id=' . $orderId . '&method=' . $paymentCode);
        } else {
            header('Location: thankyou.php?order_id=' . $orderId);
        }
        exit;
    } else {
        echo "Error saving order: " . $conn->error;
    }
}
?>
<?php include 'includes/header.php'; ?>

<div class="container page-layout">
    <div class="checkout-form-area">
        <h1 style="margin-bottom: 30px;">Checkout</h1>
        
        <?php if (!$user): ?>
            <div class="alert alert-success" style="background: #f0f9ff; border-color: #e0f2fe; color: #0369a1;">
                <i class="fas fa-info-circle"></i> Sudah punya akun? <a href="login.php" style="font-weight: 700; text-decoration: underline;">Login disini</a> untuk checkout lebih cepat.
            </div>
        <?php endif; ?>

        <form method="post" style="background: #fff; padding: 40px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--border);">
            <h3 style="margin-bottom: 24px;">Alamat Pengiriman</h3>
            
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($prefillName) ?>" required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Email (Untuk konfirmasi)</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($prefillEmail) ?>" required>
                </div>
                <div class="form-group">
                    <label>No. WhatsApp / HP</label>
                    <input type="text" name="phone" class="form-control" placeholder="0812..." required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea name="address" class="form-control" rows="3" placeholder="Jalan, No. Rumah, Kecamatan, Kota, Kode Pos" required></textarea>
            </div>

            <h3 style="margin: 30px 0 20px;">Metode Pembayaran</h3>
            
            <div style="margin-bottom: 20px;">
                <h4 style="font-size: 1rem; margin-bottom: 10px; color: var(--text-light);">Transfer Bank (Virtual Account)</h4>
                <div style="border: 1px solid var(--border); border-radius: 8px; overflow: hidden;">
                    
                    <label style="display: flex; align-items: center; gap: 15px; padding: 15px 20px; cursor: pointer; border-bottom: 1px solid var(--border); background: #fff;">
                        <input type="radio" name="payment" value="bca" checked>
                        <div style="flex: 1; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 600;">BCA Virtual Account</span>
                            <span style="border:1px solid #ddd; padding: 2px 6px; border-radius: 4px; font-weight:bold; font-size: 0.7rem; color: #0060af;">BCA</span>
                        </div>
                    </label>

                    <label style="display: flex; align-items: center; gap: 15px; padding: 15px 20px; cursor: pointer; border-bottom: 1px solid var(--border); background: #fff;">
                        <input type="radio" name="payment" value="mandiri">
                        <div style="flex: 1; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 600;">Mandiri Bill Payment</span>
                            <span style="border:1px solid #ddd; padding: 2px 6px; border-radius: 4px; font-weight:bold; font-size: 0.7rem; color: #003d79;">MANDIRI</span>
                        </div>
                    </label>

                    <label style="display: flex; align-items: center; gap: 15px; padding: 15px 20px; cursor: pointer; border-bottom: 1px solid var(--border); background: #fff;">
                        <input type="radio" name="payment" value="bri">
                        <div style="flex: 1; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 600;">BRI Virtual Account</span>
                            <span style="border:1px solid #ddd; padding: 2px 6px; border-radius: 4px; font-weight:bold; font-size: 0.7rem; color: #00529c;">BRI</span>
                        </div>
                    </label>

                    <label style="display: flex; align-items: center; gap: 15px; padding: 15px 20px; cursor: pointer; background: #fff;">
                        <input type="radio" name="payment" value="bni">
                        <div style="flex: 1; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 600;">BNI Virtual Account</span>
                            <span style="border:1px solid #ddd; padding: 2px 6px; border-radius: 4px; font-weight:bold; font-size: 0.7rem; color: #f15a23;">BNI</span>
                        </div>
                    </label>

                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <h4 style="font-size: 1rem; margin-bottom: 10px; color: var(--text-light);">E-Wallet & QRIS</h4>
                <div style="border: 1px solid var(--border); border-radius: 8px; overflow: hidden;">
                    
                    <label style="display: flex; align-items: center; gap: 15px; padding: 15px 20px; cursor: pointer; border-bottom: 1px solid var(--border); background: #fff;">
                        <input type="radio" name="payment" value="gopay">
                        <div style="flex: 1; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 600;">GoPay</span>
                            <span style="border:1px solid #ddd; padding: 2px 6px; border-radius: 4px; font-weight:bold; font-size: 0.7rem; color: #00aeb6;">GOPAY</span>
                        </div>
                    </label>

                    <label style="display: flex; align-items: center; gap: 15px; padding: 15px 20px; cursor: pointer; border-bottom: 1px solid var(--border); background: #fff;">
                        <input type="radio" name="payment" value="shopeepay">
                        <div style="flex: 1; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 600;">ShopeePay</span>
                            <span style="border:1px solid #ddd; padding: 2px 6px; border-radius: 4px; font-weight:bold; font-size: 0.7rem; color: #ee4d2d;">SHOPEE</span>
                        </div>
                    </label>

                    <label style="display: flex; align-items: center; gap: 15px; padding: 15px 20px; cursor: pointer; border-bottom: 1px solid var(--border); background: #fff;">
                        <input type="radio" name="payment" value="dana">
                        <div style="flex: 1; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 600;">Dana</span>
                            <span style="border:1px solid #ddd; padding: 2px 6px; border-radius: 4px; font-weight:bold; font-size: 0.7rem; color: #118ee9;">DANA</span>
                        </div>
                    </label>

                    <label style="display: flex; align-items: center; gap: 15px; padding: 15px 20px; cursor: pointer; border-bottom: 1px solid var(--border); background: #fff;">
                        <input type="radio" name="payment" value="ovo">
                        <div style="flex: 1; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 600;">OVO</span>
                            <span style="border:1px solid #ddd; padding: 2px 6px; border-radius: 4px; font-weight:bold; font-size: 0.7rem; color: #4c3494;">OVO</span>
                        </div>
                    </label>

                    <label style="display: flex; align-items: center; gap: 15px; padding: 15px 20px; cursor: pointer; background: #fff;">
                        <input type="radio" name="payment" value="qris">
                        <div style="flex: 1; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 600;">QRIS (All E-Wallet)</span>
                            <span style="border:1px solid #ddd; padding: 2px 6px; border-radius: 4px; font-weight:bold; font-size: 0.7rem; color: #000;">QRIS</span>
                        </div>
                    </label>
                    
                </div>
            </div>



            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 30px; padding: 16px; font-size: 1.1rem;">Buat Pesanan Sekarang</button>
        </form>
    </div>

    <div class="checkout-sidebar">
        <div style="background: #fff; padding: 30px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); position: sticky; top: 100px; border: 1px solid var(--border);">
            <h3 style="margin-bottom: 20px;">Ringkasan Pesanan</h3>
            <?php foreach ($cartItems as $item): ?>
                <div style="display: flex; justify-content: space-between; margin-bottom: 16px; font-size: 0.95rem;">
                    <div style="display: flex; gap: 10px;">
                        <img src="<?= $item['image'] ?>" style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px;">
                        <div>
                            <div style="font-weight: 500;"><?= $item['name'] ?></div>
                            <div style="font-size: 0.8rem; color: var(--text-light);">Qty: <?= $item['qty'] ?></div>
                        </div>
                    </div>
                    <span style="font-weight: 600;"><?= formatRupiah($item['subtotal']) ?></span>
                </div>
            <?php endforeach; ?>
            
            <hr style="margin: 20px 0; border: none; border-top: 1px dashed var(--border);">
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px; color: var(--text-light);">
                <span>Subtotal</span>
                <span><?= formatRupiah($total) ?></span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 20px; color: var(--text-light);">
                <span>Pengiriman</span>
                <span style="color: #15803d; font-weight: 600;">Gratis</span>
            </div>
            
            <div style="display: flex; justify-content: space-between; font-weight: 800; font-size: 1.3rem;">
                <span>Total</span>
                <span style="color: var(--accent);"><?= formatRupiah($total) ?></span>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
