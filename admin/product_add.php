<?php include 'includes/header.php'; ?>
<?php
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get basic data
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = (int)$_POST['price'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];

    if (empty($name) || empty($price)) {
        $error = 'Nama dan Harga wajib diisi!';
    } else {
        $finalImage = $image_url ?: 'assets/img/placeholder.jpg';
        
        $stmt = $conn->prepare("INSERT INTO products (name, category, price, description, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $name, $category, $price, $description, $finalImage);
        
        if ($stmt->execute()) {
            $success = 'Produk berhasil ditambahkan!';
        } else {
            $error = 'Gagal menyimpan produk: ' . $conn->error;
        }
    }
}
?>

<div class="form-container" style="margin: 0 auto; max-width: 800px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0; font-size: 1.5rem; color: var(--primary);">Tambah Produk Baru</h2>
        <a href="products.php" class="btn btn-sm btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="name" class="form-control" placeholder="Contoh: Kemeja Flanel" required>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>Kategori</label>
                <select name="category" class="form-control">
                    <option value="Kemeja">Kemeja</option>
                    <option value="Kaos">Kaos</option>
                    <option value="Celana">Celana</option>
                    <option value="Jaket">Jaket</option>
                    <option value="Batik">Batik</option>
                    <option value="Aksesoris">Aksesoris</option>
                </select>
            </div>
            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="price" class="form-control" placeholder="Contoh: 150000" required>
            </div>
        </div>

        <div class="form-group">
            <label>URL Gambar</label>
            <input type="text" name="image_url" class="form-control" placeholder="https://..." required>
            <small style="color: var(--text-light); font-size: 0.8rem;">Masukkan URL gambar langsung dari internet (Unsplash, dll)</small>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Deskripsi lengkap produk..."></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary" style="width: 100%;">
            <i class="fas fa-save"></i> Simpan Produk
        </button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
