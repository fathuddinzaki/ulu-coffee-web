<?php include 'includes/header.php'; ?>
<?php
$success = '';
$error = '';
$resetLink = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $token = requestPasswordReset($email);
    
    if ($token) {
        $success = "Link reset password berhasil dibuat!";
        // SIMULATION: Since we don't have an email server, we display the link here.
        $resetLink = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/reset_password.php?token=" . $token;
    } else {
        $error = "Email tidak ditemukan.";
    }
}
?>

<div class="container page-layout">
    <div style="max-width: 450px; margin: 40px auto; width: 100%;">
        <div style="background: var(--white); padding: 40px; border-radius: 12px; box-shadow: var(--shadow-sm); border: 1px solid var(--border);">
            <div style="text-align: center; margin-bottom: 30px;">
                <h2 style="font-family: 'Playfair Display', serif; color: var(--primary);">Lupa Password?</h2>
                <p style="color: var(--text-light); font-size: 0.9rem;">Masukkan email Anda untuk reset password.</p>
            </div>

            <?php if ($success): ?>
                <div class="alert alert-success" style="margin-bottom: 20px; background: #d1fae5; color: #065f46; padding: 10px; border-radius: 6px;">
                    <i class="fas fa-check-circle"></i> <?= $success ?>
                </div>
                <?php if ($resetLink): ?>
                    <div style="background: #f8fafc; padding: 15px; border: 1px dashed #cbd5e1; border-radius: 6px; margin-bottom: 20px; word-break: break-all;">
                        <p style="font-size: 0.85rem; color: var(--text-light); margin-bottom: 5px;"><strong>[Simulasi Email]</strong> Link Reset:</p>
                        <a href="<?= $resetLink ?>" style="font-weight: 600; color: var(--primary);"><?= $resetLink ?></a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger" style="margin-bottom: 20px; background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 6px;">
                    <i class="fas fa-exclamation-circle"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label>Email Terdaftar</label>
                    <div class="input-group">
                        <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 20px; padding: 12px;">Kirim Link Reset</button>
            </form>

            <div style="text-align: center; margin-top: 20px;">
                <a href="login.php" style="color: var(--text-light); font-size: 0.9rem; text-decoration: none;">
                    <i class="fas fa-arrow-left"></i> Kembali ke Login
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
