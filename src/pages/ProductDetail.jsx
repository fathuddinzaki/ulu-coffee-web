import React, { useState } from 'react';
import { useParams, Link, useNavigate } from 'react-router-dom';
import { initialProducts, formatRupiah } from '../data/products';
import { useCart } from '../context/CartContext';
import { ProductCard } from '../components/ProductCard';
import { ArrowLeft, ShoppingBag, Zap, Star, ShieldCheck, Heart } from 'lucide-react';

export const ProductDetail = () => {
  const { id } = useParams();
  const navigate = useNavigate();
  const { addToCart } = useCart();
  const [quantity, setQuantity] = useState(1);
  const [isLiked, setIsLiked] = useState(false);

  const product = initialProducts.find((p) => p.id === Number(id));

  if (!product) {
    return (
      <div className="container" style={{ padding: '80px 20px', textAlign: 'center' }}>
        <h2>Produk Tidak Ditemukan</h2>
        <p style={{ color: 'var(--text-light)', marginBottom: '24px' }}>
          Menu yang Anda cari mungkin sudah tidak tersedia atau link salah.
        </p>
        <Link to="/menu" className="btn btn-accent">Kembali ke Menu</Link>
      </div>
    );
  }

  const relatedProducts = initialProducts
    .filter((p) => p.category === product.category && p.id !== product.id)
    .slice(0, 4);

  const handleAddToCart = () => {
    addToCart(product, quantity);
  };

  const handleBuyNow = () => {
    addToCart(product, quantity);
    navigate('/checkout');
  };

  return (
    <div className="container" style={{ paddingTop: '30px', paddingBottom: '80px' }}>
      
      {/* Back Button */}
      <Link
        to="/menu"
        style={{
          display: 'inline-flex',
          alignItems: 'center',
          gap: '8px',
          color: 'var(--text-light)',
          fontSize: '0.9rem',
          marginBottom: '24px',
          fontWeight: 500
        }}
      >
        <ArrowLeft size={16} />
        Kembali ke Daftar Menu
      </Link>

      {/* Main Detail Grid */}
      <div
        style={{
          display: 'grid',
          gridTemplateColumns: 'repeat(auto-fit, minmax(320px, 1fr))',
          gap: '40px',
          background: '#ffffff',
          borderRadius: 'var(--radius-lg)',
          padding: '36px',
          border: '1px solid var(--border)',
          boxShadow: 'var(--shadow-sm)',
          marginBottom: '60px'
        }}
      >
        {/* Left: Product Image */}
        <div style={{ position: 'relative' }}>
          <div
            style={{
              borderRadius: 'var(--radius-md)',
              overflow: 'hidden',
              background: 'var(--secondary)',
              aspectRatio: '1/1',
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'center',
              border: '1px solid var(--border)'
            }}
          >
            <img
              src={product.image}
              alt={product.name}
              style={{ width: '100%', height: '100%', objectFit: 'cover' }}
              onError={(e) => {
                e.target.src = '/assets/img/Espresso.jpeg';
              }}
            />
          </div>

          <button
            onClick={() => setIsLiked(!isLiked)}
            style={{
              position: 'absolute',
              top: '16px',
              right: '16px',
              width: '42px',
              height: '42px',
              borderRadius: '50%',
              background: 'rgba(255,255,255,0.9)',
              backdropFilter: 'blur(10px)',
              border: 'none',
              cursor: 'pointer',
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'center',
              boxShadow: '0 4px 12px rgba(0,0,0,0.1)'
            }}
          >
            <Heart size={20} color={isLiked ? '#ef4444' : '#64748b'} fill={isLiked ? '#ef4444' : 'none'} />
          </button>
        </div>

        {/* Right: Info & Actions */}
        <div style={{ display: 'flex', flexDirection: 'column' }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: '12px', marginBottom: '8px' }}>
            <span
              style={{
                background: 'var(--secondary)',
                color: 'var(--gold-dark)',
                padding: '4px 12px',
                borderRadius: '999px',
                fontSize: '0.8rem',
                fontWeight: 600
              }}
            >
              {product.category}
            </span>
            <span style={{ display: 'flex', alignItems: 'center', gap: '4px', fontSize: '0.9rem', color: '#eab308', fontWeight: 600 }}>
              <Star size={16} fill="#eab308" />
              {product.rating || '4.8'} (50+ Ulasan)
            </span>
          </div>

          <h1 style={{ fontSize: '2.2rem', margin: '0 0 16px 0', lineHeight: '1.2' }}>
            {product.name}
          </h1>

          <div style={{ fontSize: '1.8rem', fontWeight: 700, color: 'var(--gold-dark)', marginBottom: '20px' }}>
            {formatRupiah(product.price)}
          </div>

          <p style={{ color: '#4b5563', lineHeight: '1.7', fontSize: '1rem', marginBottom: '28px' }}>
            {product.description}
          </p>

          <div style={{ borderTop: '1px solid var(--border)', paddingTop: '24px', marginTop: 'auto' }}>
            {/* Quantity Selector */}
            <div style={{ display: 'flex', alignItems: 'center', gap: '20px', marginBottom: '24px' }}>
              <span style={{ fontWeight: 600, fontSize: '0.95rem' }}>Jumlah:</span>
              <div className="qty-control">
                <button
                  className="qty-btn"
                  onClick={() => setQuantity((q) => Math.max(1, q - 1))}
                  disabled={quantity <= 1}
                >
                  -
                </button>
                <span className="qty-input">{quantity}</span>
                <button
                  className="qty-btn"
                  onClick={() => setQuantity((q) => q + 1)}
                >
                  +
                </button>
              </div>
              <span style={{ fontSize: '0.85rem', color: '#16a34a', fontWeight: 600 }}>
                Stok Tersedia ({product.stock} porsi)
              </span>
            </div>

            {/* Action Buttons */}
            <div style={{ display: 'flex', flexWrap: 'wrap', gap: '16px' }}>
              <button
                onClick={handleAddToCart}
                className="btn btn-outline"
                style={{ flex: '1 1 180px', display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '8px' }}
              >
                <ShoppingBag size={18} />
                <span>+ Keranjang</span>
              </button>
              
              <button
                onClick={handleBuyNow}
                className="btn btn-accent"
                style={{ flex: '1 1 180px', display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '8px' }}
              >
                <Zap size={18} />
                <span>Beli Sekarang</span>
              </button>
            </div>

            <div style={{ display: 'flex', alignItems: 'center', gap: '10px', marginTop: '20px', fontSize: '0.85rem', color: 'var(--text-light)' }}>
              <ShieldCheck size={18} color="#16a34a" />
              <span>Jaminan kualitas rasa terbaik & higienis dari Ulu Coffee.</span>
            </div>
          </div>
        </div>
      </div>

      {/* Related Products */}
      {relatedProducts.length > 0 && (
        <div>
          <h2 style={{ fontSize: '1.6rem', marginBottom: '24px' }}>Menu Serupa yang Mungkin Anda Suka</h2>
          <div className="product-grid">
            {relatedProducts.map((p) => (
              <ProductCard key={p.id} product={p} />
            ))}
          </div>
        </div>
      )}
    </div>
  );
};

