<?php include 'includes/header.php'; ?>

<?php
// Load Data for Stats from Database
global $conn;

// 1. Total Orders
$stmt = $conn->query("SELECT COUNT(*) as total FROM orders");
$total_orders = $stmt->fetch_assoc()['total'];

// 2. Total Revenue
$stmt = $conn->query("SELECT SUM(total) as revenue FROM orders WHERE status != 'Cancelled'"); // Assuming we count pending + paid/completed
$row = $stmt->fetch_assoc();
$total_revenue = $row['revenue'] ?? 0;

// 3. Total Products
$stmt = $conn->query("SELECT COUNT(*) as total FROM products");
$total_products = $stmt->fetch_assoc()['total'];

// 4. Total Users
$stmt = $conn->query("SELECT COUNT(*) as total FROM users WHERE role != 'admin'");
$total_users = $stmt->fetch_assoc()['total'];

// 5. Recent Orders (Fetch raw data for table below)
$orders = [];
$result = $conn->query("SELECT * FROM orders ORDER BY order_date DESC LIMIT 5");
while ($row = $result->fetch_assoc()) {
    // Format similar to what the view expects
    $orders[] = [
        'id' => $row['id'],
        'date' => $row['order_date'],
        'total' => $row['total'],
        'status' => $row['status'],
        'customer' => [
            'name' => $row['customer_name'],
            'email' => $row['user_email']
        ]
    ];
}
?>

<div class="stats-grid">
    <!-- Revenue -->
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(40, 167, 69, 0.1); color: #28a745;">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div class="stat-value">Rp <?= number_format($total_revenue, 0, ',', '.') ?></div>
        <div class="stat-label">Total Pendapatan</div>
    </div>

    <!-- Orders -->
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(0, 123, 255, 0.1); color: #007bff;">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="stat-value"><?= $total_orders ?></div>
        <div class="stat-label">Total Pesanan</div>
    </div>

    <!-- Products -->
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;">
            <i class="fas fa-tshirt"></i>
        </div>
        <div class="stat-value"><?= $total_products ?></div>
        <div class="stat-label">Total Produk</div>
    </div>

    <!-- Users -->
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(23, 162, 184, 0.1); color: #17a2b8;">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-value"><?= $total_users ?></div>
        <div class="stat-label">Pengguna Terdaftar</div>
    </div>
</div>

<div class="table-container">
    <div class="table-header">
        <h3>Pesanan Terbaru</h3>
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
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px; color: var(--text-light);">Belum ada
                            pesanan masuk.</td>
                    </tr>
                <?php else: ?>
                    <?php
                    // Orders are already limited to 5 and sorted in the query above
                    foreach ($orders as $order):
                        ?>
                        <tr>
                            <td style="font-family: monospace; color: var(--primary); font-weight: 600;">
                                #<?= substr($order['id'], -6) ?></td>
                            <td>
                                <div style="font-weight: 500;"><?= htmlspecialchars($order['customer']['name']) ?></div>
                                <div style="font-size: 0.8rem; color: var(--text-light);">
                                    <?= htmlspecialchars($order['customer']['email']) ?></div>
                            </td>
                            <td><?= date('d M Y', strtotime($order['date'])) ?></td>
                            <td style="font-weight: 600;">Rp <?= number_format($order['total'], 0, ',', '.') ?></td>
                            <td>
                                <span
                                    style="font-size: 0.85rem; color: var(--text-light); border: 1px solid var(--border); padding: 2px 6px; border-radius: 4px;">
                                    <?= htmlspecialchars($order['payment_method'] ?? 'Manual') ?>
                                </span>
                            </td>
                            <?php
                            // Badge Logic
                            $status = $order['status'] ?? 'Pending';
                            $badge_bg = $status === 'Completed' || $status === 'Paid' ? '#d4edda' : ($status === 'Cancelled' ? '#f8d7da' : '#fff3cd');
                            $badge_color = $status === 'Completed' || $status === 'Paid' ? '#155724' : ($status === 'Cancelled' ? '#721c24' : '#856404');
                            ?>
                            <td><span class="badge badge-success"
                                    style="background: <?= $badge_bg ?>; color: <?= $badge_color ?>; padding: 5px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;"><?= $status ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>