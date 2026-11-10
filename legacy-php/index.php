<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php include 'includes/header.php'; ?>
<?php
$products = getProducts();
$featuredProducts = array_slice($products, 0, 4);
?>

<section class="hero">
    <div class="hero-content">
        <h1>Nikmati Kopi Terbaik<br>Setiap Saat</h1>
        <p>Temukan cita rasa kopi pilihan dan camilan nikmat untuk menemani harimu.</p>
        <div class="hero-btns">
            <a href="products.php" class="btn">Pesan Sekarang</a>
            <a href="products.php" class="btn btn-outline" style="border-color: var(--white); color: var(--white);">Lihat Menu</a>
        </div>
    </div>
</section>

<section id="featured" class="container">
    <h2 class="section-title">Produk Unggulan</h2>
    <div class="product-grid">
        <?php foreach ($featuredProducts as $product): ?>
            <div class="product-card">
                <a href="product_detail.php?id=<?= $product['id'] ?>" style="display: block; height: 100%;">
                    <div class="card-img-wrapper">
                        <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="product-image">
                        <div class="card-actions">
                            <span class="btn btn-sm btn-accent">Lihat Detail</span>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-category"><?= $product['category'] ?></div>
                        <h3 class="product-title"><?= $product['name'] ?></h3>
                        <div class="product-price"><?= formatRupiah($product['price']) ?></div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <div style="text-align: center; margin-bottom: 60px;">
        <a href="products.php" class="btn">Lihat Semua Produk</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
