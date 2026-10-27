<?php include 'includes/header.php'; ?>
<?php
$token = $_GET['token'] ?? null;
$error = '';
$success = '';

if (!$token) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($password !== $confirm) {
        $error = "Password konfirmasi tidak cocok.";
    } else {
        if (resetPassword($token, $password)) {
            $success = "Password berhasil diubah! Silakan login dengan password baru.";
        } else {
            $error = "Token reset tidak valid atau sudah kadaluarsa.";
        }
    }
}
?>

<div class="container page-layout">
    <div style="max-width: 450px; margin: 40px auto; width: 100%;">
        <div style="background: var(--white); padding: 40px; border-radius: 12px; box-shadow: var(--shadow-sm); border: 1px solid var(--border);">
            <div style="text-align: center; margin-bottom: 30px;">
                <h2 style="font-family: 'Playfair Display', serif; color: var(--primary);">Reset Password</h2>
                <p style="color: var(--text-light); font-size: 0.9rem;">Masukkan password baru Anda.</p>
            </div>

            <?php if ($success): ?>
                <div class="alert alert-success" style="margin-bottom: 20px; background: #d1fae5; color: #065f46; padding: 10px; border-radius: 6px;">
                    <i class="fas fa-check-circle"></i> <?= $success ?>
                </div>
                <a href="login.php" class="btn btn-primary" style="width: 100%;">Login Sekarang</a>
            <?php else: ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger" style="margin-bottom: 20px; background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 6px;">
                        <i class="fas fa-exclamation-circle"></i> <?= $error ?>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 20px; padding: 12px;">Ubah Password</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
