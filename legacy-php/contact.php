<?php include 'includes/header.php'; ?>
<?php
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');

    if ($name && $email && $message) {
        if (saveMessage($name, $email, $message)) {
            $success_message = "Pesan Anda telah terkirim! Kami akan segera menghubungi Anda.";
        } else {
            $error_message = "Gagal menyimpan pesan. Silakan coba lagi.";
        }
    } else {
        $error_message = "Mohon lengkapi semua field.";
    }
}
?>

<section class="hero" style="height: 50vh; margin-bottom: 40px;">
    <div class="hero-content">
        <h1>Hubungi Kami</h1>
        <p>Kami siap membantu Anda</p>
    </div>
</section>

<div class="container" style="margin-bottom: 80px;">
    <div class="contact-grid">
        <!-- Contact Info -->
        <div>
            <h2 class="section-title" style="text-align: left; margin-bottom: 30px;">Informasi Kontak</h2>
            <p style="margin-bottom: 40px; color: var(--text-light);">
                Punya pertanyaan tentang produk atau pesanan Anda? Jangan ragu untuk menghubungi kami melalui saluran di bawah ini atau kirimkan pesan melalui formulir.
            </p>

            <div style="display: flex; flex-direction: column; gap: 30px;">
                <div style="display: flex; gap: 20px;">
                    <div style="width: 50px; height: 50px; background: var(--secondary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--gold); font-size: 1.2rem; flex-shrink: 0;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h4 style="margin-bottom: 5px;">Alamat</h4>
                        <p style="color: var(--text-light);">Jl. Jendral Sudirman No. 123<br>Padang, Sumatera Barat</p>
                    </div>
                </div>

                <div style="display: flex; gap: 20px;">
                    <div style="width: 50px; height: 50px; background: var(--secondary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--gold); font-size: 1.2rem; flex-shrink: 0;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h4 style="margin-bottom: 5px;">Email</h4>
                        <p style="color: var(--text-light);">hello@ulucoffe.com</p>
                    </div>
                </div>

                <div style="display: flex; gap: 20px;">
                    <div style="width: 50px; height: 50px; background: var(--secondary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--gold); font-size: 1.2rem; flex-shrink: 0;">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div>
                        <h4 style="margin-bottom: 5px;">WhatsApp</h4>
                        <p style="color: var(--text-light);">+62 856-5864-0208</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="form-container" style="margin: 0; max-width: 100%; padding: 40px; box-shadow: var(--shadow-md);">
            <h3 style="margin-bottom: 20px;">Kirim Pesan</h3>
            
            <?php if ($success_message): ?>
                <div class="alert alert-success"><?= $success_message ?></div>
            <?php endif; ?>
            
            <?php if ($error_message): ?>
                <div class="alert alert-danger"><?= $error_message ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="form-control" required placeholder="Masukkan nama Anda">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required placeholder="Masukkan email Anda">
                </div>
                <div class="form-group">
                    <label for="message">Pesan</label>
                    <textarea id="message" name="message" class="form-control" rows="5" required placeholder="Tuliskan pesan Anda disini..."></textarea>
                </div>
                <button type="submit" class="btn btn-accent" style="width: 100%;">Kirim Pesan</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
