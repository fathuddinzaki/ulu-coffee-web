<?php include 'includes/header.php'; ?>
<?php
// Fetch all products for the content grid
$products = getProducts(); 
?>

<div class="container-fluid" style="padding: 20px;">
    <div class="row" style="display: flex; gap: 20px;">
        
        <!-- Left Column: Product Grid -->
        <div style="flex: 2;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="margin: 0; color: var(--primary);">Kasir (Point of Sale)</h2>
                <input type="text" id="searchProduct" placeholder="Cari Produk..." style="padding: 10px; border: 1px solid var(--border); border-radius: 6px; width: 300px;">
            </div>

            <div class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 20px;">
                <?php foreach ($products as $product): ?>
                <div class="product-card" onclick="addToCart(<?= htmlspecialchars(json_encode($product), ENT_QUOTES, 'UTF-8') ?>)" style="background: #fff; border: 1px solid var(--border); border-radius: 8px; overflow: hidden; cursor: pointer; transition: transform 0.2s;">
                    <div style="height: 140px; overflow: hidden;">
                        <img src="<?= strpos($product['image'], 'http') === 0 ? $product['image'] : '../' . $product['image'] ?>" alt="<?= $product['name'] ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="padding: 15px;">
                        <h4 style="margin: 0 0 5px; font-size: 1rem;"><?= $product['name'] ?></h4>
                        <div style="color: var(--accent); font-weight: bold;">Rp <?= number_format($product['price'], 0, ',', '.') ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Right Column: Cart/Order Summary -->
        <div style="flex: 1; min-width: 350px;">
            <div style="background: #fff; border: 1px solid var(--border); border-radius: 8px; position: sticky; top: 20px; box-shadow: var(--shadow);">
                <div style="padding: 20px; border-bottom: 1px solid var(--border); background: var(--bg-light); border-radius: 8px 8px 0 0;">
                    <h3 style="margin: 0;">Keranjang Belanja</h3>
                </div>
                
                <div id="cartItems" style="padding: 20px; max-height: 500px; overflow-y: auto; min-height: 200px;">
                    <!-- Cart items will appear here -->
                    <div style="text-align: center; color: var(--text-light); padding: 40px 0;">Belum ada item yang dipilih</div>
                </div>

                <div style="padding: 20px; border-top: 1px solid var(--border); background: #f8f9fa; border-radius: 0 0 8px 8px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 1.2rem; font-weight: bold;">
                        <span>Total:</span>
                        <span id="cartTotal">Rp 0</span>
                    </div>

                    <form id="posForm" action="pos_process.php" method="POST">
                        <input type="hidden" name="cart_data" id="cartData">
                        <div style="margin-bottom: 15px;">
                            <label style="font-size: 0.9rem;">Nama Pelanggan (Opsional)</label>
                            <input type="text" name="customer_name" class="form-control" placeholder="Guest / Nama Pelanggan" value="Guest">
                        </div>
                        <button type="button" onclick="checkout()" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 1.1rem;">
                            <i class="fas fa-money-bill-wave"></i> Bayar (Tunai)
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let cart = {};

function addToCart(product) {
    if (cart[product.id]) {
        cart[product.id].qty++;
    } else {
        cart[product.id] = {
            id: product.id,
            name: product.name,
            price: product.price,
            image: product.image,
            qty: 1
        };
    }
    renderCart();
}

function updateQty(id, change) {
    if (cart[id]) {
        cart[id].qty += change;
        if (cart[id].qty <= 0) {
            delete cart[id];
        }
    }
    renderCart();
}

function renderCart() {
    const container = document.getElementById('cartItems');
    const totalEl = document.getElementById('cartTotal');
    let html = '';
    let total = 0;

    if (Object.keys(cart).length === 0) {
        container.innerHTML = '<div style="text-align: center; color: var(--text-light); padding: 40px 0;">Belum ada item yang dipilih</div>';
        totalEl.innerText = 'Rp 0';
        return;
    }

    for (let id in cart) {
        let item = cart[id];
        let subtotal = item.price * item.qty;
        total += subtotal;

        html += `
        <div style="display: flex; gap: 10px; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px dashed #eee;">
            <div style="width: 50px; height: 50px; border-radius: 4px; overflow: hidden; background: #eee;">
               <img src="${item.image.startsWith('http') ? item.image : '../' + item.image}" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div style="flex: 1;">
                <div style="font-weight: 500; font-size: 0.95rem;">${item.name}</div>
                <div style="color: var(--text-light); font-size: 0.85rem;">@ Rp ${item.price.toLocaleString('id-ID')}</div>
            </div>
            <div style="text-align: right;">
                <div style="font-weight: bold;">Rp ${subtotal.toLocaleString('id-ID')}</div>
                <div style="display: flex; align-items: center; justify-content: flex-end; gap: 5px; margin-top: 5px;">
                    <button type="button" onclick="updateQty('${id}', -1)" style="width: 24px; height: 24px; padding: 0; border: 1px solid #ddd; background: #fff; border-radius: 4px; cursor: pointer;">-</button>
                    <span style="font-size: 0.9rem; min-width: 20px; text-align: center;">${item.qty}</span>
                    <button type="button" onclick="updateQty('${id}', 1)" style="width: 24px; height: 24px; padding: 0; border: 1px solid #ddd; background: #fff; border-radius: 4px; cursor: pointer;">+</button>
                </div>
            </div>
        </div>
        `;
    }

    container.innerHTML = html;
    totalEl.innerText = 'Rp ' + total.toLocaleString('id-ID');
}

function checkout() {
    if (Object.keys(cart).length === 0) {
        alert('Keranjang masih kosong!');
        return;
    }
    
    document.getElementById('cartData').value = JSON.stringify(cart);
    document.getElementById('posForm').submit();
}

// Search Filter
document.getElementById('searchProduct').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let cards = document.querySelectorAll('.product-card');
    
    cards.forEach(card => {
        let name = card.querySelector('h4').innerText.toLowerCase();
        if (name.includes(filter)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>

<?php include 'includes/footer.php'; ?>
