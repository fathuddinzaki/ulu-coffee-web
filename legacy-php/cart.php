<?php include 'includes/header.php'; ?>
<?php
if (isset($_GET['remove'])) {
    $removeId = $_GET['remove'];
    unset($_SESSION['cart'][$removeId]);
    header('Location: cart.php');
    exit;
}
$cart = getCartDetails();
$cartItems = $cart['items'];
$total = $cart['total'];
?>

<div class="container" style="padding-top: 40px; padding-bottom: 80px;">
    <h1 style="margin-bottom: 30px; text-align: center; font-size: 2rem;">Keranjang Belanja</h1>

    <?php if (empty($cartItems)): ?>
        <div style="background: #fff; padding: 80px 20px; text-align: center; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--border);">
            <div style="width: 120px; height: 120px; background: var(--secondary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px;">
                <i class="fas fa-shopping-basket" style="font-size: 3rem; color: #cbd5e1;"></i>
            </div>
            <h3 style="margin-bottom: 15px;">Keranjang Anda kosong</h3>
            <p style="color: var(--text-light); margin-bottom: 40px;">Yuk pilih menu favoritmu terlebih dahulu!</p>
            <a href="products.php" class="btn btn-accent">Lihat Menu</a>
        </div>
    <?php else: ?>
        <div class="page-layout">
            <div style="flex: 2; min-width: 0;">
                <!-- Desktop Table -->
                <div class="cart-table-desktop" style="background: #fff; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); overflow-x: auto; border: 1px solid var(--border);">
                    <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                        <thead style="background: var(--secondary); border-bottom: 1px solid var(--border);">
                            <tr>
                                <th style="padding: 20px; text-align: left; color: var(--text-light); font-weight: 600;">Produk</th>
                                <th style="padding: 20px; text-align: left; color: var(--text-light); font-weight: 600;">Harga</th>
                                <th style="padding: 20px; text-align: left; color: var(--text-light); font-weight: 600;">Qty</th>
                                <th style="padding: 20px; text-align: right; color: var(--text-light); font-weight: 600;">Total</th>
                                <th style="padding: 20px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item): ?>
                                <tr style="border-bottom: 1px solid var(--border);">
                                    <td style="padding: 20px;">
                                        <div style="display: flex; align-items: center; gap: 20px;">
                                            <img src="<?= $item['image'] ?>" alt="" style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px;">
                                            <div>
                                                <div style="font-weight: 600; margin-bottom: 4px;"><?= $item['name'] ?></div>
                                                <div style="font-size: 0.85rem; color: var(--text-light);"><?= $item['category'] ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 20px;"><?= formatRupiah($item['price']) ?></td>
                                    <td style="padding: 20px;">
                                        <div style="display: inline-flex; align-items: center; border: 1px solid var(--border); border-radius: 6px; padding: 5px 10px; background: var(--secondary); font-weight: 600;">
                                            <?= $item['qty'] ?>
                                        </div>
                                    </td>
                                    <td style="padding: 20px; text-align: right; font-weight: 600;"><?= formatRupiah($item['subtotal']) ?></td>
                                    <td style="padding: 20px; text-align: center;">
                                        <a href="cart.php?remove=<?= $item['id'] ?>" class="nav-icon" style="color: #ef4444;">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="cart-item-mobile">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="cart-card">
                            <div class="cart-card-top">
                                <img src="<?= $item['image'] ?>" alt="" class="cart-card-img">
                                <div class="cart-card-info">
                                    <div class="cart-card-name"><?= $item['name'] ?></div>
                                    <div class="cart-card-cat"><?= $item['category'] ?></div>
                                    <div style="margin-top: 6px; font-weight: 600; font-size: 0.9rem;"><?= formatRupiah($item['price']) ?></div>
                                </div>
                                <a href="cart.php?remove=<?= $item['id'] ?>" class="cart-card-remove">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                            <div class="cart-card-bottom">
                                <span class="cart-card-qty">Qty: <?= $item['qty'] ?></span>
                                <span class="cart-card-price"><?= formatRupiah($item['subtotal']) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div style="margin-top: 30px; text-align: left;">
                    <a href="products.php" class="btn btn-outline" style="border-color: var(--border); color: var(--text);"><i class="fas fa-arrow-left"></i> Lanjut Belanja</a>
                </div>
            </div>
            
            <div class="sidebar">
                <div style="background: #fff; padding: 30px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--border); position: sticky; top: 100px;">
                    <h3 style="margin-bottom: 24px;">Ringkasan Belanja</h3>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 16px; color: var(--text-light);">
                        <span>Subtotal</span>
                        <span style="color: var(--text); font-weight: 600;"><?= formatRupiah($total) ?></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 16px; color: var(--text-light);">
                        <span>Biaya Layanan</span>
                        <span style="color: #15803d; font-weight: 600;">Gratis</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 24px; color: var(--text-light);">
                        <span>Pajak</span>
                        <span>-</span>
                    </div>
                    
                    <hr style="margin: 24px 0; border: none; border-top: 1px dashed var(--border);">
                    
                    <div style="display: flex; justify-content: space-between; font-weight: 800; font-size: 1.3rem; margin-bottom: 30px;">
                        <span>Total</span>
                        <span style="color: var(--gold);"><?= formatRupiah($total) ?></span>
                    </div>
                    
                    <a href="checkout.php" class="btn btn-accent" style="width: 100%; text-align: center;">
                        Checkout Sekarang <i class="fas fa-arrow-right"></i>
                    </a>
                    
                    <p style="text-align: center; margin-top: 20px; font-size: 0.8rem; color: var(--text-light);">
                        <i class="fas fa-lock"></i> Pembayaran Aman & Terpercaya
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
