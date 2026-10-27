<?php include 'includes/header.php'; ?>
<?php
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: products.php');
    exit;
}

$products_file = '../data/products.json'; // Keep for safety? No, remove.

// Find product
$product = getProductById($id);

if (!$product) {
    echo "Produk tidak ditemukan!";
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update data
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = (int)$_POST['price'];
    $description = $_POST['description'];
    $image = $_POST['image_url'];

    $stmt = $conn->prepare("UPDATE products SET name=?, category=?, price=?, description=?, image=? WHERE id=?");
    $stmt->bind_param("ssissi", $name, $category, $price, $description, $image, $id);
    
    if ($stmt->execute()) {
        $success = 'Produk berhasil diperbarui!';
        // Refresh variable
        $product = getProductById($id);
    } else {
        $error = "Gagal memperbarui produk: " . $conn->error;
    }
}
?>

<div class="form-container" style="margin: 0 auto; max-width: 800px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0; font-size: 1.5rem; color: var(--primary);">Edit Produk</h2>
        <a href="products.php" class="btn btn-sm btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>Kategori</label>
                <select name="category" class="form-control">
                    <?php
                    $categories = ['Kemeja', 'Kaos', 'Celana', 'Jaket', 'Batik', 'Aksesoris'];
                    foreach ($categories as $cat) {
                        $selected = ($product['category'] === $cat) ? 'selected' : '';
                        echo "<option value=\"$cat\" $selected>$cat</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="price" class="form-control" value="<?= $product['price'] ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label>URL Gambar</label>
            <input type="text" name="image_url" class="form-control" value="<?= htmlspecialchars($product['image']) ?>" required>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($product['description']) ?></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary" style="width: 100%;">
            <i class="fas fa-save"></i> Simpan Perubahan
        </button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
