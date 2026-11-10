<?php include 'includes/header.php'; ?>
<?php
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
$orders = getUserOrders($user['email']);
?>

<div class="container" style="padding-top: 40px; padding-bottom: 80px;">
    <div class="page-layout" style="padding: 0;">
        <!-- Sidebar Profile -->
        <div class="profile-sidebar">
            <div style="background: #fff; padding: 30px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); text-align: center; border: 1px solid var(--border);">
                <div style="width: 100px; height: 100px; background: var(--secondary); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: var(--gold);">
                    <i class="fas fa-user"></i>
                </div>
                <h3 style="margin-bottom: 5px;"><?= $user['name'] ?></h3>
                <p style="color: var(--text-light); margin-bottom: 20px;"><?= $user['email'] ?></p>
                <div style="text-align: left; border-top: 1px solid var(--border); padding-top: 20px;">
                    <p style="margin-bottom: 10px;"><strong>Member sejak:</strong> <br> <?= date('d M Y', strtotime($user['created_at'])) ?></p>
                </div>
                <a href="profile_edit.php" class="btn btn-outline" style="width: 100%; margin-top: 20px; border-color: var(--gold); color: var(--gold);">Edit Profil</a>
                <a href="logout.php" class="btn btn-outline" style="width: 100%; margin-top: 10px; border-color: #ef4444; color: #ef4444;">Logout</a>
            </div>
        </div>

        <!-- Main Content (Orders) -->
        <div class="profile-main">
            <h2 style="margin-bottom: 30px;">Riwayat Pesanan</h2>

            <?php if (empty($orders)): ?>
                <div style="background: #fff; padding: 40px; border-radius: var(--radius-md); text-align: center; border: 1px dashed var(--border);">
                    <i class="fas fa-box-open" style="font-size: 3rem; color: var(--text-light); margin-bottom: 20px;"></i>
                    <h3>Belum ada pesanan</h3>
                    <p style="color: var(--text-light); margin-bottom: 20px;">Yuk mulai belanja koleksi terbaru kami.</p>
                    <a href="products.php" class="btn btn-accent">Mulai Belanja</a>
                </div>
            <?php else: ?>
                <?php foreach ($orders as $order): 
                    $status = $order['status'];
                    $badgeBg = '#dcfce7';
                    $badgeColor = '#15803d';
                    $statusLabel = 'Selesai';
                    
                    if ($status == 'Pending') {
                        $badgeBg = '#fff7ed';
                        $badgeColor = '#c2410c';
                        $statusLabel = 'Menunggu Pembayaran';
                    } elseif ($status == 'Cancelled') {
                        $badgeBg = '#fef2f2';
                        $badgeColor = '#b91c1c';
                        $statusLabel = 'Dibatalkan';
                    } elseif ($status == 'Completed') {
                        $statusLabel = 'Selesai';
                    }
                ?>
                <div style="background: #fff; padding: 20px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); margin-bottom: 16px; border: 1px solid var(--border);">
                    <div class="order-card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid var(--secondary);">
                        <div>
                            <span style="font-weight: 700; color: var(--gold);">Order #<?= $order['id'] ?></span>
                            <div style="font-size: 0.85rem; color: var(--text-light);"><?= date('d M Y H:i', strtotime($order['date'])) ?></div>
                        </div>
                        <div>
                            <span style="display: inline-block; padding: 5px 12px; background: <?= $badgeBg ?>; color: <?= $badgeColor ?>; border-radius: 20px; font-size: 0.8rem; font-weight: 600;"><?= $statusLabel ?></span>
                        </div>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <?php foreach ($order['items'] as $item): ?>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 0.9rem;">
                                <span><?= $item['name'] ?> <span style="color: var(--text-light);">x<?= $item['qty'] ?></span></span>
                                <span><?= formatRupiah($item['subtotal']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="order-card-footer" style="display: flex; justify-content: space-between; align-items: center; padding-top: 12px; border-top: 1px dashed var(--border);">
                        <div>
                            <span style="font-weight: 600; display: block; font-size: 0.85rem; color: var(--text-light);">Total Pembayaran</span>
                            <span style="font-weight: 700; font-size: 1.1rem; color: var(--gold);"><?= formatRupiah($order['total']) ?></span>
                        </div>
                        <div>
                            <?php if ($status == 'Pending'): ?>
                                <a href="payment.php?order_id=<?= $order['id'] ?>" class="btn btn-sm btn-accent">Bayar Sekarang</a>
                            <?php elseif ($status == 'Completed' || $status == 'Paid'): ?>
                                <a href="thankyou.php?order_id=<?= $order['id'] ?>&status=success" class="btn btn-sm btn-outline">Lihat Struk</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
