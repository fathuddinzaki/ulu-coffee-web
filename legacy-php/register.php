<?php include 'includes/header.php'; ?>
<?php
if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (registerUser($name, $email, $password)) {
        // Auto login after register
        $user = loginUser($email, $password);
        $_SESSION['user'] = $user;
        echo "<script>alert('Registrasi berhasil!'); window.location.href='index.php';</script>";
        exit;
    } else {
        $error = 'Email sudah terdaftar!';
    }
}
?>

<div class="container" style="min-height: 70vh; display: flex; align-items: center; justify-content: center;">
    <div class="form-container" style="width: 100%;">
        <h2 style="text-align: center; margin-bottom: 10px;">Buat Akun Baru</h2>
        <p style="text-align: center; color: var(--text-light); margin-bottom: 30px;">Bergabunglah dengan member eksklusif kami.</p>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Nama Anda" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="******" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">Daftar Member</button>
            
            <p style="text-align: center; margin-top: 20px; font-size: 0.9rem;">
                Sudah punya akun? <a href="login.php" style="color: var(--accent); font-weight: 600;">Masuk disini</a>
            </p>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
