import React from 'react';
import { Link } from 'react-router-dom';
import { initialProducts } from '../data/products';
import { ProductCard } from '../components/ProductCard';
import { Coffee, Award, Smile, Zap, ArrowRight } from 'lucide-react';

export const Home = () => {
  const featuredProducts = initialProducts.filter((p) => p.isFeatured).slice(0, 4);

  return (
    <div>
      {/* Hero Section */}
      <section className="hero">
        <div className="hero-content">
          <div style={{ display: 'inline-flex', alignItems: 'center', gap: '8px', background: 'rgba(255,255,255,0.15)', backdropFilter: 'blur(10px)', padding: '6px 16px', borderRadius: '999px', color: '#fff', fontSize: '0.85rem', marginBottom: '18px' }}>
            <Coffee size={16} color="var(--gold)" />
            <span>Kopi Pilihan Asli Indonesia</span>
          </div>
          <h1>Nikmati Kopi Terbaik<br />Setiap Saat</h1>
          <p>Temukan cita rasa kopi artisan pilihan dan camilan nikmat untuk menemani hari-harimu di Ulu Coffee.</p>
          <div className="hero-btns">
            <Link to="/menu" className="btn btn-accent">Pesan Sekarang</Link>
            <Link to="/about" className="btn btn-outline" style={{ borderColor: 'var(--white)', color: 'var(--white)' }}>
              Tentang Kami
            </Link>
          </div>
        </div>
      </section>

      {/* Featured Products */}
      <section id="featured" className="container" style={{ paddingTop: '60px', paddingBottom: '60px' }}>
        <div style={{ textAlign: 'center', marginBottom: '40px' }}>
          <span style={{ color: 'var(--gold-dark)', textTransform: 'uppercase', letterSpacing: '0.1em', fontSize: '0.85rem', fontWeight: 700 }}>
            Paling Populer
          </span>
          <h2 className="section-title" style={{ marginTop: '8px', marginBottom: '12px' }}>Produk Unggulan</h2>
          <p style={{ color: 'var(--text-light)', maxWidth: '540px', margin: '0 auto' }}>
            Pilihan minuman dan sajian favorit racikan barista kami yang paling dicintai pelanggan.
          </p>
        </div>

        <div className="product-grid" style={{ marginBottom: '40px' }}>
          {featuredProducts.map((product) => (
            <ProductCard key={product.id} product={product} />
          ))}
        </div>

        <div style={{ textAlign: 'center' }}>
          <Link to="/menu" className="btn btn-outline" style={{ display: 'inline-flex', alignItems: 'center', gap: '8px' }}>
            <span>Lihat Semua Menu</span>
            <ArrowRight size={18} />
          </Link>
        </div>
      </section>

      {/* Why Choose Us */}
      <section style={{ background: 'var(--secondary)', padding: '80px 0', borderTop: '1px solid var(--border)', borderBottom: '1px solid var(--border)' }}>
        <div className="container">
          <div style={{ textAlign: 'center', marginBottom: '50px' }}>
            <span style={{ color: 'var(--gold-dark)', textTransform: 'uppercase', letterSpacing: '0.1em', fontSize: '0.85rem', fontWeight: 700 }}>
              Kualitas Terbaik
            </span>
            <h2 className="section-title" style={{ marginTop: '8px' }}>Mengapa Memilih Ulu Coffee?</h2>
          </div>

          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(240px, 1fr))', gap: '28px' }}>
            <div style={{ background: '#fff', padding: '32px 24px', borderRadius: 'var(--radius-md)', border: '1px solid var(--border)', textAlign: 'center', boxShadow: 'var(--shadow-sm)' }}>
              <div style={{ width: '60px', height: '60px', background: 'var(--secondary)', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', margin: '0 auto 20px', color: 'var(--gold-dark)' }}>
                <Coffee size={28} />
              </div>
              <h3 style={{ fontSize: '1.2rem', marginBottom: '10px' }}>100% Biji Kopi Lokal</h3>
              <p style={{ color: 'var(--text-light)', fontSize: '0.9rem', lineHeight: '1.6' }}>
                Dipetik langsung dari petani lokal Sumatera dengan roasting profil khusus untuk rasa maksimal.
              </p>
            </div>

            <div style={{ background: '#fff', padding: '32px 24px', borderRadius: 'var(--radius-md)', border: '1px solid var(--border)', textAlign: 'center', boxShadow: 'var(--shadow-sm)' }}>
              <div style={{ width: '60px', height: '60px', background: 'var(--secondary)', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', margin: '0 auto 20px', color: 'var(--gold-dark)' }}>
                <Award size={28} />
              </div>
              <h3 style={{ fontSize: '1.2rem', marginBottom: '10px' }}>Barista Profesional</h3>
              <p style={{ color: 'var(--text-light)', fontSize: '0.9rem', lineHeight: '1.6' }}>
                Diseduh dengan presisi tinggi menggunakan teknik manual brew maupun mesin espresso modern.
              </p>
            </div>

            <div style={{ background: '#fff', padding: '32px 24px', borderRadius: 'var(--radius-md)', border: '1px solid var(--border)', textAlign: 'center', boxShadow: 'var(--shadow-sm)' }}>
              <div style={{ width: '60px', height: '60px', background: 'var(--secondary)', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', margin: '0 auto 20px', color: 'var(--gold-dark)' }}>
                <Smile size={28} />
              </div>
              <h3 style={{ fontSize: '1.2rem', marginBottom: '10px' }}>Suasana Cozy</h3>
              <p style={{ color: 'var(--text-light)', fontSize: '0.9rem', lineHeight: '1.6' }}>
                Tempat nyaman untuk kerja (WFC), nongkrong santai bareng teman, atau meeting santai.
              </p>
            </div>

            <div style={{ background: '#fff', padding: '32px 24px', borderRadius: 'var(--radius-md)', border: '1px solid var(--border)', textAlign: 'center', boxShadow: 'var(--shadow-sm)' }}>
              <div style={{ width: '60px', height: '60px', background: 'var(--secondary)', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', margin: '0 auto 20px', color: 'var(--gold-dark)' }}>
                <Zap size={28} />
              </div>
              <h3 style={{ fontSize: '1.2rem', marginBottom: '10px' }}>Pesan Praktis</h3>
              <p style={{ color: 'var(--text-light)', fontSize: '0.9rem', lineHeight: '1.6' }}>
                Pesan langsung lewat web, pilih bawa pulang atau makan di tempat tanpa perlu antre lama.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* CTA Promo Banner */}
      <section className="container" style={{ padding: '80px 24px' }}>
        <div style={{ background: 'linear-gradient(135deg, #1d1d1f 0%, #2c2c2e 100%)', borderRadius: 'var(--radius-lg)', padding: '60px 40px', color: '#fff', display: 'flex', flexWrap: 'wrap', alignItems: 'center', justifyContent: 'space-between', gap: '30px', boxShadow: 'var(--shadow-md)' }}>
          <div style={{ maxWidth: '580px' }}>
            <span style={{ background: 'var(--gold)', color: '#fff', padding: '4px 12px', borderRadius: '999px', fontSize: '0.8rem', fontWeight: 700, textTransform: 'uppercase' }}>
              Spesial Hari Ini
            </span>
            <h2 style={{ color: '#fff', fontSize: '2.2rem', margin: '16px 0 12px 0' }}>Ingin Segelas Kopi Hangat?</h2>
            <p style={{ color: '#a1a1a6', fontSize: '1.05rem', margin: 0, lineHeight: '1.6' }}>
              Gunakan kode promo <strong style={{ color: 'var(--gold)' }}>ULUKOPI</strong> di halaman keranjang dan dapatkan diskon 10% untuk pesanan pertama Anda!
            </p>
          </div>
          <Link to="/menu" className="btn btn-accent" style={{ padding: '16px 36px', fontSize: '1.05rem' }}>
            Pesan Menu Sekarang
          </Link>
        </div>
      </section>
    </div>
  );
};

