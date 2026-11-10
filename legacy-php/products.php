<?php include 'includes/header.php'; ?>
<?php
$category = $_GET['category'] ?? null;
$search = $_GET['search'] ?? null;

$products = filterProducts($category, $search);
$allCategories = ['Kopi', 'Non Kopi', 'Makanan', 'Snack'];
?>

<div class="container page-layout-full">
    <!-- Filter Bar -->
    <div class="filter-bar">
        <form action="products.php" method="get" class="search-form">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" class="search-input" placeholder="Cari produk..." value="<?= htmlspecialchars($search ?? '') ?>">
            </div>
        </form>
        
        <div class="category-pills">
            <a href="products.php" class="category-pill <?= !$category ? 'active' : '' ?>">Semua</a>
            <?php foreach ($allCategories as $cat): ?>
                <a href="products.php?category=<?= $cat ?>" class="category-pill <?= $category === $cat ? 'active' : '' ?>"><?= $cat ?></a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <h1 style="font-size: 2rem;">
            <?= $category ? "Kategori: $category" : ($search ? "Hasil Cari: \"$search\"" : "Semua Koleksi") ?>
        </h1>
        <span style="color: var(--text-light);"><?= count($products) ?> Produk</span>
    </div>

    <!-- Product Grid -->
    <?php if (empty($products)): ?>
        <div class="empty-state">
            <i class="fas fa-search" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 20px;"></i>
            <h3>Produk tidak ditemukan</h3>
            <p style="color: var(--text-light);">Coba kata kunci lain atau reset filter.</p>
            <a href="products.php" class="btn btn-outline" style="margin-top: 20px; border-color: var(--primary); color: var(--primary);">Reset Filter</a>
        </div>
    <?php else: ?>
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
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
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
