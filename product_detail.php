<?php include 'includes/header.php'; ?>
<?php
$id = $_GET['id'] ?? null;
$product = getProductById($id);

if (!$product) {
    echo "<div class='container' style='padding: 100px 0; text-align: center;'><h2>Produk tidak ditemukan.</h2><a href='products.php' class='btn'>Kembali ke Katalog</a></div>";
    include 'includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    addToCart($product['id'], $_POST['qty']);
    echo "<script>window.location.href='cart.php';</script>";
}
?>

<div class="container" style="padding-top: 40px; padding-bottom: 80px;">
    <div class="detail-layout">
        <!-- Image Section -->
        <div class="detail-img">
            <div style="position: sticky; top: 100px;">
                <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" style="width: 100%; border-radius: var(--radius-md); box-shadow: var(--shadow-md);">
            </div>
        </div>

        <!-- Info Section -->
        <div class="detail-info">
            <div style="margin-bottom: 20px;">
                <span style="background: var(--bg-gold-gradient); color: #fff; padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">
                    <?= $product['category'] ?>
                </span>
            </div>
            
            <h1 style="font-size: 2.8rem; margin-bottom: 20px; line-height: 1.1;"><?= $product['name'] ?></h1>
            
            <div class="detail-price" style="font-size: 2.2rem; margin-bottom: 30px; font-weight: 700; color: var(--gold);">
                <?= formatRupiah($product['price']) ?>
            </div>

            <p style="font-size: 1.05rem; color: var(--text-light); line-height: 1.8; margin-bottom: 40px; border-bottom: 1px solid var(--border); padding-bottom: 30px;">
                <?= $product['description'] ?>
            </p>

            <form method="post" class="detail-add-form" style="display: flex; gap: 20px; align-items: flex-end; margin-bottom: 40px;">
                <div class="form-group" style="margin-bottom: 0; width: 100px;">
                    <label style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700; color: var(--text-light);">Jumlah</label>
                    <input type="number" name="qty" value="1" min="1" class="form-control" style="font-size: 1.2rem; font-weight: 600; text-align: center; padding: 12px;">
                </div>
                <button type="submit" name="add_to_cart" class="btn btn-accent" style="flex: 1; height: 53px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                    <i class="fas fa-shopping-cart" style="margin-right: 10px;"></i> Tambah Keranjang
                </button>
            </form>

            <div class="detail-features" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="display: flex; gap: 15px; align-items: start;">
                    <i class="fas fa-mug-hot" style="font-size: 1.5rem; color: var(--gold);"></i>
                    <div>
                        <h5 style="margin-bottom: 5px;">Freshly Made</h5>
                        <p style="font-size: 0.85rem; color: var(--text-light);">Dibuat segar saat dipesan.</p>
                    </div>
                </div>
                <div style="display: flex; gap: 15px; align-items: start;">
                    <i class="fas fa-store" style="font-size: 1.5rem; color: var(--gold);"></i>
                    <div>
                        <h5 style="margin-bottom: 5px;">Dine-in & Take Away</h5>
                        <p style="font-size: 0.85rem; color: var(--text-light);">Nikmati di tempat atau bawa pulang.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Products -->
<section class="container" style="margin-bottom: 80px;">
    <h3 class="section-title" style="text-align: left; font-size: 2rem; margin-bottom: 40px;">Produk Lainnya</h3>
    <?php 
    $moreProducts = array_slice(getProducts(), 0, 4); 
    ?>
    <div class="product-grid">
        <?php foreach ($moreProducts as $p): ?>
            <?php if ($p['id'] == $id) continue; ?>
            <div class="product-card">
                <a href="product_detail.php?id=<?= $p['id'] ?>" style="display: block; height: 100%;">
                    <div class="card-img-wrapper">
                        <img src="<?= $p['image'] ?>" class="product-image">
                        <div class="card-actions">
                            <span class="btn btn-sm btn-accent">Lihat Detail</span>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-category"><?= $p['category'] ?></div>
                        <h3 class="product-title"><?= $p['name'] ?></h3>
                        <div class="product-price"><?= formatRupiah($p['price']) ?></div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
