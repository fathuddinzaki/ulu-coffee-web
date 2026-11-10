<?php include 'includes/header.php'; ?>
<?php
// Load Products
$products = getProducts();
?>

<div class="table-container">
    <div class="table-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Daftar Produk</h3>
        <a href="product_add.php" class="btn btn-sm btn-accent"><i class="fas fa-plus"></i> Tambah Produk</a>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Belum ada produk.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td>
                            <div style="width: 50px; height: 50px; border-radius: 8px; overflow: hidden; background: #f8f9fa;">
                                <img src="<?= strpos($product['image'], 'http') === 0 ? $product['image'] : '../' . $product['image'] ?>" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </td>
                        <td style="font-weight: 500;"><?= htmlspecialchars($product['name']) ?></td>
                        <td><span style="font-size: 0.85rem; background: #e2e8f0; padding: 4px 10px; border-radius: 20px;"><?= htmlspecialchars($product['category']) ?></span></td>
                        <td style="font-weight: 600;">Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
                        <td>
                            <a href="product_edit.php?id=<?= $product['id'] ?>" style="color: var(--accent); margin-right: 10px;"><i class="fas fa-edit"></i></a>
                            <a href="product_delete.php?id=<?= $product['id'] ?>" onclick="return confirm('Yakin ingin menghapus produk ini?')" style="color: #dc3545;"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
