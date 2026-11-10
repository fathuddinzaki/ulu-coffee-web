import React, { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { useCart } from '../context/CartContext';
import { formatRupiah } from '../data/products';
import { Trash2, ShoppingBag, ArrowRight, ArrowLeft, Tag, CheckCircle } from 'lucide-react';

export const Cart = () => {
  const { cart, updateQty, removeFromCart, totalPrice } = useCart();
  const navigate = useNavigate();

  const [promoCode, setPromoCode] = useState('');
  const [discountPercent, setDiscountPercent] = useState(0);
  const [promoError, setPromoError] = useState('');
  const [promoApplied, setPromoApplied] = useState(false);

  const handleApplyPromo = (e) => {
    e.preventDefault();
    if (promoCode.trim().toUpperCase() === 'ULUKOPI') {
      setDiscountPercent(10);
      setPromoApplied(true);
      setPromoError('');
    } else {
      setPromoError('Kode promo tidak valid. Coba kode: ULUKOPI');
      setDiscountPercent(0);
      setPromoApplied(false);
    }
  };

  const discountAmount = Math.round(totalPrice * (discountPercent / 100));
  const serviceFee = cart.length > 0 ? 2000 : 0;
  const grandTotal = Math.max(0, totalPrice - discountAmount + serviceFee);

  if (cart.length === 0) {
    return (
      <div className="container" style={{ padding: '80px 20px', textAlign: 'center' }}>
        <div
          style={{
            background: '#ffffff',
            borderRadius: 'var(--radius-lg)',
            padding: '60px 24px',
            maxWidth: '560px',
            margin: '0 auto',
            border: '1px solid var(--border)',
            boxShadow: 'var(--shadow-sm)'
          }}
        >
          <div
            style={{
              width: '90px',
              height: '90px',
              borderRadius: '50%',
              background: 'var(--secondary)',
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'center',
              margin: '0 auto 24px',
              color: 'var(--gold-dark)'
            }}
          >
            <ShoppingBag size={42} />
          </div>
          <h2 style={{ fontSize: '1.8rem', marginBottom: '12px' }}>Keranjang Belanja Kosong</h2>
          <p style={{ color: 'var(--text-light)', marginBottom: '32px', lineHeight: '1.6' }}>
            Belum ada menu yang Anda pilih. Yuk jelajahi menu kopi spesial dan hidangan favorit kami!
          </p>
          <Link to="/menu" className="btn btn-accent" style={{ padding: '14px 32px' }}>
            Lihat Menu Kopi
          </Link>
        </div>
      </div>
    );
  }

  return (
    <div className="container" style={{ paddingTop: '40px', paddingBottom: '80px' }}>
      <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '32px' }}>
        <h1 style={{ fontSize: '2.2rem', margin: 0 }}>Keranjang Belanja</h1>
        <Link to="/menu" style={{ display: 'flex', alignItems: 'center', gap: '6px', color: 'var(--text-light)', fontSize: '0.9rem' }}>
          <ArrowLeft size={16} />
          Tambah Menu Lain
        </Link>
      </div>

      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(320px, 1fr))', gap: '32px', alignItems: 'start' }}>
        
        {/* Left: Cart Items List */}
        <div style={{ background: '#ffffff', borderRadius: 'var(--radius-md)', padding: '24px', border: '1px solid var(--border)', boxShadow: 'var(--shadow-sm)' }}>
          <div style={{ display: 'flex', flexDirection: 'column', gap: '20px' }}>
            {cart.map((item) => (
              <div
                key={item.id}
                style={{
                  display: 'flex',
                  alignItems: 'center',
                  justifyContent: 'space-between',
                  paddingBottom: '20px',
                  borderBottom: '1px solid var(--border)',
                  gap: '16px'
                }}
              >
                {/* Image & Title */}
                <div style={{ display: 'flex', alignItems: 'center', gap: '16px', flex: 1 }}>
                  <img
                    src={item.image}
                    alt={item.name}
                    style={{ width: '70px', height: '70px', borderRadius: '10px', objectFit: 'cover' }}
                    onError={(e) => {
                      e.target.src = '/assets/img/Espresso.jpeg';
                    }}
                  />
                  <div>
                    <h4 style={{ margin: '0 0 4px 0', fontSize: '1.05rem' }}>{item.name}</h4>
                    <span style={{ fontSize: '0.8rem', color: 'var(--text-light)' }}>{item.category}</span>
                    <div style={{ fontWeight: 600, color: 'var(--gold-dark)', marginTop: '4px' }}>
                      {formatRupiah(item.price)}
                    </div>
                  </div>
                </div>

                {/* Quantity Controls */}
                <div className="qty-control">
                  <button className="qty-btn" onClick={() => updateQty(item.id, item.qty - 1)}>-</button>
                  <span className="qty-input">{item.qty}</span>
                  <button className="qty-btn" onClick={() => updateQty(item.id, item.qty + 1)}>+</button>
                </div>

                {/* Subtotal & Delete */}
                <div style={{ textAlign: 'right', minWidth: '100px' }}>
                  <div style={{ fontWeight: 700, fontSize: '1rem', marginBottom: '6px' }}>
                    {formatRupiah(item.price * item.qty)}
                  </div>
                  <button
                    onClick={() => removeFromCart(item.id)}
                    style={{ background: 'none', border: 'none', color: '#ef4444', cursor: 'pointer', padding: 0 }}
                    title="Hapus"
                  >
                    <Trash2 size={16} />
                  </button>
                </div>
              </div>
            ))}
          </div>

          {/* Promo Code Form */}
          <form onSubmit={handleApplyPromo} style={{ marginTop: '24px', display: 'flex', gap: '10px' }}>
            <div style={{ position: 'relative', flex: 1 }}>
              <Tag size={16} color="var(--text-light)" style={{ position: 'absolute', left: '14px', top: '50%', transform: 'translateY(-50%)' }} />
              <input
                type="text"
                placeholder="Kode Promo (cth: ULUKOPI)"
                value={promoCode}
                onChange={(e) => setPromoCode(e.target.value)}
                style={{
                  width: '100%',
                  padding: '12px 14px 12px 38px',
                  borderRadius: '8px',
                  border: '1px solid var(--border)',
                  background: 'var(--secondary)',
                  outline: 'none',
                  fontSize: '0.9rem',
                  boxSizing: 'border-box'
                }}
              />
            </div>
            <button type="submit" className="btn btn-outline" style={{ padding: '10px 20px', whiteSpace: 'nowrap' }}>
              Terapkan
            </button>
          </form>

          {promoApplied && (
            <div style={{ display: 'flex', alignItems: 'center', gap: '6px', color: '#16a34a', fontSize: '0.85rem', marginTop: '10px' }}>
              <CheckCircle size={16} />
              <span>Kode promo ULUKOPI berhasil diterapkan (Diskon 10%)!</span>
            </div>
          )}

          {promoError && (
            <div style={{ color: '#ef4444', fontSize: '0.85rem', marginTop: '8px' }}>
              {promoError}
            </div>
          )}
        </div>

        {/* Right: Order Summary Sidebar */}
        <div
          style={{
            background: '#ffffff',
            borderRadius: 'var(--radius-md)',
            padding: '28px',
            border: '1px solid var(--border)',
            boxShadow: 'var(--shadow-sm)'
          }}
        >
          <h3 style={{ fontSize: '1.25rem', marginBottom: '20px' }}>Ringkasan Pesanan</h3>

          <div style={{ display: 'flex', flexDirection: 'column', gap: '14px', fontSize: '0.95rem' }}>
            <div style={{ display: 'flex', justifyContent: 'space-between' }}>
              <span style={{ color: 'var(--text-light)' }}>Subtotal Produk</span>
              <span>{formatRupiah(totalPrice)}</span>
            </div>

            {discountAmount > 0 && (
              <div style={{ display: 'flex', justifyContent: 'space-between', color: '#16a34a' }}>
                <span>Diskon Promo (10%)</span>
                <span>-{formatRupiah(discountAmount)}</span>
              </div>
            )}

            <div style={{ display: 'flex', justifyContent: 'space-between' }}>
              <span style={{ color: 'var(--text-light)' }}>Biaya Layanan & Kemasan</span>
              <span>{formatRupiah(serviceFee)}</span>
            </div>

            <div
              style={{
                borderTop: '1px solid var(--border)',
                paddingTop: '16px',
                marginTop: '10px',
                display: 'flex',
                justifyContent: 'space-between',
                alignItems: 'center'
              }}
            >
              <span style={{ fontSize: '1.1rem', fontWeight: 600 }}>Total Pembayaran</span>
              <span style={{ fontSize: '1.4rem', fontWeight: 700, color: 'var(--gold-dark)' }}>
                {formatRupiah(grandTotal)}
              </span>
            </div>
          </div>

          <button
            onClick={() => navigate('/checkout', { state: { discountAmount, serviceFee, grandTotal } })}
            className="btn btn-accent"
            style={{ width: '100%', marginTop: '24px', padding: '14px', display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '8px' }}
          >
            <span>Lanjut ke Pembayaran</span>
            <ArrowRight size={18} />
          </button>
        </div>
      </div>
    </div>
  );
};

