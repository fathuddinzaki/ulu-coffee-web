<?php include 'includes/header.php'; ?>
<?php
if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = loginUser($email, $password);

    if ($user) {
        $_SESSION['user'] = $user;
        if (isset($user['role']) && $user['role'] === 'admin') {
            header('Location: admin/index.php');
        } else {
            header('Location: index.php');
        }
        exit;
    } else {
        $error = 'Email atau password salah!';
    }
}
?>

<div class="container" style="min-height: 70vh; display: flex; align-items: center; justify-content: center;">
    <div class="form-container" style="width: 100%;">
        <h2 style="text-align: center; margin-bottom: 10px;">Selamat Datang Kembali</h2>
        <p style="text-align: center; color: var(--text-light); margin-bottom: 30px;">Silakan masuk untuk melanjutkan belanja.</p>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="******" required>
                <div style="text-align: right; margin-top: 5px;">
                    <a href="forgot_password.php" style="font-size: 0.85rem; color: var(--text-light); text-decoration: none;">Lupa Password?</a>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">Masuk Sekarang</button>
            
            <p style="text-align: center; margin-top: 20px; font-size: 0.9rem;">
                Belum punya akun? <a href="register.php" style="color: var(--accent); font-weight: 600;">Daftar disini</a>
            </p>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
