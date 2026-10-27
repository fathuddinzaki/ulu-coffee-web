<?php include 'includes/header.php'; ?>
<?php
// Load Messages
$messages = getMessages();
?>

<div class="table-container">
    <div class="table-header">
        <h3>Pesan Masuk</h3>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Pesan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($messages)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Belum ada pesan masuk.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($messages as $msg): ?>
                    <tr>
                        <td style="white-space: nowrap; color: var(--text-light); font-size: 0.85rem;">
                            <?= date('d M Y, H:i', strtotime($msg['created_at'])) ?>
                        </td>
                        <td style="font-weight: 500;"><?= htmlspecialchars($msg['name']) ?></td>
                        <td><?= htmlspecialchars($msg['email']) ?></td>
                        <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
                        <td>
                            <a href="mailto:<?= htmlspecialchars($msg['email']) ?>?subject=Balasan: Ulu Coffe&body=Halo <?= htmlspecialchars($msg['name']) ?>,%0D%0A%0D%0AMenanggapi pesan Anda:%0D%0A> <?= rawurlencode($msg['message']) ?>%0D%0A%0D%0A" class="btn btn-sm btn-primary" style="padding: 4px 10px; font-size: 0.8rem;">
                                <i class="fas fa-reply"></i> Balas
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
