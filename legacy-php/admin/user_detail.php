<?php include 'includes/header.php'; ?>
<?php
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: users.php');
    exit;
}

// Load User from DB
global $conn;
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    echo "Pengguna tidak ditemukan!";
    exit;
}

// Load Orders for this user from DB
$user_orders = [];
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_email = ? ORDER BY order_date DESC");
$stmt->bind_param("s", $user['email']);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $user_orders[] = [
        'id' => $row['id'],
        'date' => $row['order_date'],
        'total' => $row['total'],
        'status' => $row['status']
    ];
}
?>

<div class="form-container" style="margin: 0 auto; max-width: 900px; padding: 0;">
    <div style="padding: 30px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="margin: 0; font-size: 1.5rem; color: var(--primary);">Detail Pengguna</h2>
            <p style="margin: 5px 0 0; color: var(--text-light); font-family: monospace;"><?= $user['id'] ?></p>
        </div>
        <a href="users.php" class="btn btn-sm btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <div style="padding: 30px;">
        <div style="display: flex; gap: 30px; margin-bottom: 40px; align-items: flex-start;">
            <div style="width: 100px; height: 100px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: bold; color: var(--text-light); flex-shrink: 0;">
                <?= strtoupper(substr($user['name'], 0, 1)) ?>
            </div>
            <div style="flex: 1;">
                 <h3 style="margin-top: 0; margin-bottom: 5px;"><?= htmlspecialchars($user['name']) ?></h3>
                 <div style="color: var(--text-light); margin-bottom: 15px;"><?= htmlspecialchars($user['email']) ?></div>
                 
                 <div style="display: flex; gap: 10px;">
                    <?php if ($user['role'] === 'admin'): ?>
                        <span style="background: #cff4fc; color: #055160; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">Admin</span>
                    <?php else: ?>
                        <span style="background: #f8f9fa; color: var(--text-light); padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; border: 1px solid #e2e8f0;">Customer</span>
                    <?php endif; ?>
                    
                    <span style="background: #f0f0f0; color: var(--text-light); padding: 4px 12px; border-radius: 20px; font-size: 0.85rem;">
                        <i class="far fa-calendar-alt"></i> Joined <?= date('d M Y', strtotime($user['created_at'])) ?>
                    </span>
                 </div>
            </div>
        </div>

        <h3 style="font-size: 1.1rem; margin-bottom: 20px; border-bottom: 1px solid var(--border); padding-bottom: 10px;">
            <i class="fas fa-shopping-bag" style="color: var(--accent); margin-right: 8px;"></i> Riwayat Pesanan
        </h3>
        
        <?php if (empty($user_orders)): ?>
            <div style="text-align: center; padding: 40px; background: #f8f9fa; border-radius: 8px; color: var(--text-light);">
                <i class="fas fa-shopping-cart" style="font-size: 2rem; margin-bottom: 10px; opacity: 0.5;"></i>
                <p>Pengguna ini belum pernah melakukan pemesanan.</p>
            </div>
        <?php else: ?>
            <div style="background: #fff; border-radius: 8px; overflow: hidden; border: 1px solid var(--border);">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8f9fa; text-align: left; border-bottom: 1px solid var(--border);">
                            <th style="padding: 12px 20px; font-size: 0.9rem;">ID Pesanan</th>
                            <th style="padding: 12px 20px; font-size: 0.9rem;">Tanggal</th>
                            <th style="padding: 12px 20px; font-size: 0.9rem;">Total</th>
                            <th style="padding: 12px 20px; font-size: 0.9rem;">Metode</th>
                            <th style="padding: 12px 20px; font-size: 0.9rem;">Status</th>
                            <th style="padding: 12px 20px; font-size: 0.9rem; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_reverse($user_orders) as $order): ?>
                        <tr style="border-bottom: 1px solid var(--border);">
                            <td style="padding: 12px 20px; font-family: monospace; font-weight: 500; color: var(--primary);">
                                #<?= substr($order['id'], -6) ?>
                            </td>
                            <td style="padding: 12px 20px; font-size: 0.9rem;">
                                <?= date('d M Y, H:i', strtotime($order['date'])) ?>
                            </td>
                            <td style="padding: 12px 20px; font-weight: 600;">
                                Rp <?= number_format($order['total'], 0, ',', '.') ?>
                            </td>
                            <td style="padding: 12px 20px; font-size: 0.9rem; color: var(--text);">
                                <?= htmlspecialchars($order['payment_method'] ?? 'Manual') ?>
                            </td>
                            <td style="padding: 12px 20px;">
                                <?php
                                $status = $order['status'] ?? 'Pending';
                                $badge_bg = $status === 'Completed' ? '#d4edda' : '#fff3cd';
                                $badge_color = $status === 'Completed' ? '#155724' : '#856404';
                                ?>
                                <span style="background: <?= $badge_bg ?>; color: <?= $badge_color ?>; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;"><?= $status ?></span>
                            </td>
                            <td style="padding: 12px 20px; text-align: right;">
                                <a href="order_detail.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-outline" style="padding: 2px 8px; font-size: 0.75rem;">Lihat</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
