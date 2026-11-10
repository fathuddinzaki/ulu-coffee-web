<?php include 'includes/header.php'; ?>
<?php
// Load Users
$all_users = getUsers();
?>

<div class="table-container">
    <div class="table-header">
        <h3>Pengguna Terdaftar</h3>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($all_users)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Belum ada pengguna.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($all_users as $u): ?>
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 32px; height: 32px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: var(--text-light);">
                                    <?= strtoupper(substr($u['name'], 0, 1)) ?>
                                </div>
                                <span style="font-weight: 500;"><?= htmlspecialchars($u['name']) ?></span>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td>
                            <?php if ($u['role'] === 'admin'): ?>
                                <span style="background: #cff4fc; color: #055160; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">Admin</span>
                            <?php else: ?>
                                <span style="background: #f8f9fa; color: var(--text-light); padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; border: 1px solid #e2e8f0;">Customer</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                        <td>
                        <td>
                            <a href="user_detail.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-outline" style="padding: 4px 10px; font-size: 0.8rem;">Detail</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
