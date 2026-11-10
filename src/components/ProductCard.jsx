import React from 'react';
import { Link } from 'react-router-dom';
import { useCart } from '../context/CartContext';
import { formatRupiah } from '../data/products';
import { Plus, Star } from 'lucide-react';

export const ProductCard = ({ product }) => {
  const { addToCart } = useCart();

  const handleAddClick = (e) => {
    e.preventDefault();
    e.stopPropagation();
    addToCart(product, 1);
  };

  return (
    <div className="product-card" style={{ display: 'flex', flexDirection: 'column', height: '100%' }}>
      <Link to={`/product/${product.id}`} style={{ display: 'block', textDecoration: 'none' }}>
        <div className="card-img-wrapper" style={{ position: 'relative', overflow: 'hidden' }}>
          <img
            src={product.image}
            alt={product.name}
            className="product-image"
            onError={(e) => {
              e.target.src = '/assets/img/Espresso.jpeg';
            }}
          />
          {product.isFeatured && (
            <span
              style={{
                position: 'absolute',
                top: '12px',
                left: '12px',
                background: 'var(--gold)',
                color: '#fff',
                fontSize: '0.75rem',
                fontWeight: 700,
                padding: '4px 10px',
                borderRadius: '999px',
                boxShadow: '0 2px 8px rgba(0,0,0,0.15)'
              }}
            >
              Favorit
            </span>
          )}
          <div className="card-actions">
            <span className="btn btn-sm btn-accent">Lihat Detail</span>
          </div>
        </div>

        <div className="product-info" style={{ padding: '16px', display: 'flex', flexDirection: 'column', flex: 1 }}>
          <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '6px' }}>
            <span className="product-category" style={{ margin: 0 }}>{product.category}</span>
            {product.rating && (
              <span style={{ display: 'flex', alignItems: 'center', gap: '3px', fontSize: '0.8rem', color: '#eab308', fontWeight: 600 }}>
                <Star size={13} fill="#eab308" />
                {product.rating}
              </span>
            )}
          </div>

          <h3 className="product-title" style={{ fontSize: '1.05rem', margin: '0 0 8px 0', minHeight: '2.4em' }}>
            {product.name}
          </h3>

          <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginTop: 'auto', paddingTop: '10px' }}>
            <div className="product-price" style={{ margin: 0, fontSize: '1.1rem' }}>
              {formatRupiah(product.price)}
            </div>

            <button
              onClick={handleAddClick}
              title="Tambah ke Keranjang"
              style={{
                background: 'var(--secondary)',
                border: '1px solid var(--border)',
                borderRadius: '50%',
                width: '36px',
                height: '36px',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                cursor: 'pointer',
                color: 'var(--text)',
                transition: 'all 0.2s ease'
              }}
              onMouseEnter={(e) => {
                e.currentTarget.style.background = 'var(--gold)';
                e.currentTarget.style.color = '#fff';
              }}
              onMouseLeave={(e) => {
                e.currentTarget.style.background = 'var(--secondary)';
                e.currentTarget.style.color = 'var(--text)';
              }}
            >
              <Plus size={18} />
            </button>
          </div>
        </div>
      </Link>
    </div>
  );
};

