<?php include 'includes/header.php'; ?>
<?php
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: orders.php');
    exit;
}

// Find order
$order = getOrderById($id);

if (!$order) {
    echo "Pesanan tidak ditemukan!";
    exit;
}

// Handle Process Order
$success_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'process') {
    global $conn;
    $stmt = $conn->prepare("UPDATE orders SET status = 'Completed' WHERE id = ?");
    $stmt->bind_param("s", $id);
    if ($stmt->execute()) {
        $order['status'] = 'Completed'; // Update local variable
        $success_message = "Pesanan berhasil diproses!";
    }
}
?>
<?php if ($success_message): ?>
<div style="margin: 20px auto; max-width: 900px; background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; border: 1px solid #c3e6cb;">
    <i class="fas fa-check-circle"></i> <?= $success_message ?>
</div>
<?php endif; ?>

<div class="form-container" style="margin: 0 auto; max-width: 900px; padding: 0;">
    <div style="padding: 30px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="margin: 0; font-size: 1.5rem; color: var(--primary);">Detail Pesanan</h2>
            <p style="margin: 5px 0 0; color: var(--text-light); font-family: monospace;">#<?= $order['id'] ?></p>
        </div>
        <a href="orders.php" class="btn btn-sm btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <div style="padding: 30px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 40px;">
            <!-- Customer Info -->
            <div>
                <h3 style="font-size: 1.1rem; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid var(--border);">
                    <i class="fas fa-user-circle" style="color: var(--accent); margin-right: 8px;"></i> Informasi Pelanggan
                </h3>
                <div style="display: grid; grid-template-columns: 100px 1fr; gap: 10px; font-size: 0.95rem;">
                    <div style="color: var(--text-light);">Nama</div>
                    <div style="font-weight: 500;"><?= htmlspecialchars($order['customer']['name']) ?></div>
                    
                    <div style="color: var(--text-light);">Email</div>
                    <div><?= htmlspecialchars($order['customer']['email']) ?></div>
                    
                    <div style="color: var(--text-light);">No. HP</div>
                    <div><?= htmlspecialchars($order['customer']['phone']) ?></div>
                    
                    <div style="color: var(--text-light);">Alamat</div>
                    <div><?= nl2br(htmlspecialchars($order['customer']['address'])) ?></div>
                </div>
            </div>

            <!-- Order Info -->
            <div>
                <h3 style="font-size: 1.1rem; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid var(--border);">
                    <i class="fas fa-receipt" style="color: var(--accent); margin-right: 8px;"></i> Informasi Pesanan
                </h3>
                <div style="display: grid; grid-template-columns: 100px 1fr; gap: 10px; font-size: 0.95rem;">
                    <div style="color: var(--text-light);">Tanggal</div>
                    <div><?= date('d F Y, H:i', strtotime($order['date'])) ?></div>
                    
                    <div style="color: var(--text-light);">Status</div>
                    <?php
                    $status = $order['status'] ?? 'Pending';
                    $badge_bg = $status === 'Completed' ? '#d4edda' : '#fff3cd';
                    $badge_color = $status === 'Completed' ? '#155724' : '#856404';
                    ?>
                    <div><span style="background: <?= $badge_bg ?>; color: <?= $badge_color ?>; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;"><?= $status ?></span></div>
                    
                    <div style="color: var(--text-light);">Pembayaran</div>
                    <div style="font-weight: 600; color: var(--primary);"><?= htmlspecialchars($order['payment_method'] ?? 'Transfer Bank (Manual)') ?></div>
                </div>
            </div>
        </div>

        <h3 style="font-size: 1.1rem; margin-bottom: 20px;">Item Pesanan</h3>
        <div style="background: #f8f9fa; border-radius: 8px; overflow: hidden; border: 1px solid var(--border);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #e2e8f0; text-align: left;">
                        <th style="padding: 15px; font-size: 0.9rem;">Produk</th>
                        <th style="padding: 15px; font-size: 0.9rem; text-align: center;">Qty</th>
                        <th style="padding: 15px; font-size: 0.9rem; text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order['items'] as $item): ?>
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="width: 60px; height: 60px; background: white; border-radius: 6px; overflow: hidden; border: 1px solid var(--border);">
                                    <img src="<?= strpos($item['image'], 'http') === 0 ? $item['image'] : '../' . $item['image'] ?>" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div>
                                    <div style="font-weight: 600; font-size: 0.95rem; margin-bottom: 4px;"><?= htmlspecialchars($item['name']) ?></div>
                                    <div style="color: var(--text-light); font-size: 0.85rem;"><?= ucfirst($item['category']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 15px; text-align: center; font-weight: 500;">x<?= $item['qty'] ?></td>
                        <td style="padding: 15px; text-align: right; font-weight: 600;">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr style="background: white;">
                        <td colspan="2" style="padding: 20px; text-align: right; font-weight: bold; color: var(--text-light);">Total Order</td>
                        <td style="padding: 20px; text-align: right; font-size: 1.25rem; font-weight: 700; color: var(--primary);">Rp <?= number_format($order['total'], 0, ',', '.') ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div style="margin-top: 30px; text-align: right;">
             <button onclick="window.print()" class="btn btn-outline" style="margin-right: 10px;"><i class="fas fa-print"></i> Cetak Invoice</button>
             <?php if (($order['status'] ?? 'Pending') !== 'Completed'): ?>
             <form method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin memproses pesanan ini? Status akan berubah menjadi Completed.');">
                <input type="hidden" name="action" value="process">
                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Proses Pesanan</button>
             </form>
             <?php else: ?>
                <button class="btn btn-primary" disabled style="opacity: 0.6; cursor: not-allowed;"><i class="fas fa-check-double"></i> Pesanan Selesai</button>
             <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
