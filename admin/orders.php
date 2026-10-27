<?php include 'includes/header.php'; ?>
<?php
// Load Orders
$orders = getAllOrders();
?>

<div class="table-container">
    <div class="table-header">
        <h3>Daftar Pesanan</h3>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center;">Belum ada pesanan masuk.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach (array_reverse($orders) as $order): ?>
                    <tr>
                        <td style="font-family: monospace; color: var(--primary); font-weight: 600;">#<?= substr($order['id'], -6) ?></td>
                        <td>
                            <div style="font-weight: 500;"><?= htmlspecialchars($order['customer']['name']) ?></div>
                            <div style="font-size: 0.8rem; color: var(--text-light);"><?= htmlspecialchars($order['customer']['email']) ?></div>
                        </td>
                        <td><?= date('d M Y, H:i', strtotime($order['date'])) ?></td>
                        <td style="font-weight: 600;">Rp <?= number_format($order['total'], 0, ',', '.') ?></td>
                        <td>
                            <span style="font-size: 0.85rem; color: var(--text-light); border: 1px solid var(--border); padding: 2px 6px; border-radius: 4px;">
                                <?= htmlspecialchars($order['payment_method'] ?? 'Manual') ?>
                            </span>
                        </td>
                        <?php
                        $status = $order['status'] ?? 'Pending';
                        $badge_bg = $status === 'Completed' ? '#d4edda' : '#fff3cd';
                        $badge_color = $status === 'Completed' ? '#155724' : '#856404';
                        ?>
                        <td><span class="badge badge-success" style="background: <?= $badge_bg ?>; color: <?= $badge_color ?>; padding: 5px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;"><?= $status ?></span></td>
                        <td>
                            <a href="order_detail.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-outline" style="padding: 4px 10px; font-size: 0.8rem;">Detail</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
