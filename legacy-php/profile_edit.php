<?php include 'includes/header.php'; ?>
<?php
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = !empty($_POST['password']) ? $_POST['password'] : null;
    $password_confirm = $_POST['password_confirm'] ?? null;

    if ($password && $password !== $password_confirm) {
        $error = 'Konfirmasi password tidak cocok!';
    } else {
        if (updateUser($user['id'], $name, $phone, $address, $password)) {
            $success = 'Profil berhasil diperbarui!';
            $user = $_SESSION['user']; // Refresh data
        } else {
            $error = 'Gagal memperbarui profil. Silakan coba lagi.';
        }
    }
}
?>

<div class="container page-layout">
    <div style="max-width: 600px; margin: 0 auto; width: 100%;">
        <div style="margin-bottom: 20px;">
            <a href="profile.php" class="btn btn-sm btn-outline"><i class="fas fa-arrow-left"></i> Kembali ke Profil</a>
        </div>

        <div style="background: var(--white); padding: 40px; border-radius: var(--radius); box-shadow: var(--shadow-sm); border: 1px solid var(--border);">
            <h2 style="margin-bottom: 30px; text-align: center;">Edit Profil</h2>

            <?php if ($success): ?>
                <div class="alert alert-success" style="margin-bottom: 20px; background: #d1fae5; color: #065f46; padding: 10px; border-radius: 6px;">
                    <i class="fas fa-check-circle"></i> <?= $success ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger" style="margin-bottom: 20px; background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 6px;">
                    <i class="fas fa-exclamation-circle"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <h4 style="margin-bottom: 15px; border-bottom: 1px solid var(--border); padding-bottom: 10px;">Informasi Pribadi</h4>
                
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" disabled style="background: #f1f5f9; cursor: not-allowed;">
                    <small style="color: var(--text-light);">Email tidak dapat diubah.</small>
                </div>

                <div class="form-group">
                    <label>No. WhatsApp / HP</label>
                    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="0812...">
                </div>

                <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <textarea name="address" class="form-control" rows="3" placeholder="Alamat pengiriman..."><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                </div>

                <h4 style="margin-top: 30px; margin-bottom: 15px; border-bottom: 1px solid var(--border); padding-bottom: 10px;">Ganti Password (Opsional)</h4>
                
                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengganti">
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirm" class="form-control" placeholder="Ulangi password baru">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 20px; padding: 12px;">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
