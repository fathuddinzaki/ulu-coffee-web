import React from 'react';
import { Coffee, Heart, Sparkles, MapPin, Award } from 'lucide-react';
import { Link } from 'react-router-dom';

export const About = () => {
  return (
    <div>
      {/* Hero */}
      <section className="hero" style={{ height: '45vh', minHeight: '320px', marginBottom: '40px' }}>
        <div className="hero-content">
          <div style={{ display: 'inline-flex', alignItems: 'center', gap: '8px', background: 'rgba(255,255,255,0.15)', padding: '6px 16px', borderRadius: '999px', color: '#fff', fontSize: '0.85rem', marginBottom: '14px' }}>
            <Sparkles size={16} color="var(--gold)" />
            <span>Kisah Di Balik Cita Rasa</span>
          </div>
          <h1>Tentang Ulu Coffee</h1>
          <p>Membawa kehangatan dan keaslian cita rasa kopi Nusantara ke cangkir Anda.</p>
        </div>
      </section>

      <div className="container" style={{ paddingBottom: '80px' }}>
        
        {/* Story Grid */}
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(320px, 1fr))', gap: '48px', alignItems: 'center', marginBottom: '80px' }}>
          <div>
            <span style={{ color: 'var(--gold-dark)', textTransform: 'uppercase', letterSpacing: '0.1em', fontSize: '0.85rem', fontWeight: 700 }}>
              Filosofi Kami
            </span>
            <h2 style={{ fontSize: '2.2rem', margin: '12px 0 20px 0' }}>Bukan Sekadar Kedai Kopi, Tapi Ruang Berbagi Cerita</h2>
            <p style={{ color: '#4b5563', lineHeight: '1.8', marginBottom: '18px', fontSize: '1rem' }}>
              Ulu Coffee lahir dari kecintaan kami terhadap kekayaan biji kopi Indonesia, khususnya dataran tinggi Sumatera. Kami percaya bahwa setiap cangkir kopi memiliki cerita tentang tanah tempatnya tumbuh dan ketulusan petani yang merawatnya.
            </p>
            <p style={{ color: '#4b5563', lineHeight: '1.8', marginBottom: '28px', fontSize: '1rem' }}>
              Dengan menggabungkan teknik seduh tradisional dan peralatan modern berstandar specialty coffee, barista kami meracik minuman yang tidak hanya memuaskan selera, tetapi juga menyajikan kenyamanan di setiap tegukan.
            </p>
            
            <div style={{ display: 'flex', gap: '30px' }}>
              <div>
                <div style={{ fontSize: '2rem', fontWeight: 800, color: 'var(--gold-dark)' }}>100%</div>
                <div style={{ color: 'var(--text-light)', fontSize: '0.85rem' }}>Biji Kopi Asli Lokal</div>
              </div>
              <div style={{ borderLeft: '1px solid var(--border)', paddingLeft: '30px' }}>
                <div style={{ fontSize: '2rem', fontWeight: 800, color: 'var(--gold-dark)' }}>15.000+</div>
                <div style={{ color: 'var(--text-light)', fontSize: '0.85rem' }}>Cangkir Terjual</div>
              </div>
              <div style={{ borderLeft: '1px solid var(--border)', paddingLeft: '30px' }}>
                <div style={{ fontSize: '2rem', fontWeight: 800, color: 'var(--gold-dark)' }}>4.9 / 5</div>
                <div style={{ color: 'var(--text-light)', fontSize: '0.85rem' }}>Kepuasan Pelanggan</div>
              </div>
            </div>
          </div>

          <div style={{ borderRadius: 'var(--radius-lg)', overflow: 'hidden', border: '1px solid var(--border)', boxShadow: 'var(--shadow-md)' }}>
            <img
              src="/assets/img/b1.jpeg"
              alt="Ulu Coffee Ambiance"
              style={{ width: '100%', height: '420px', objectFit: 'cover' }}
              onError={(e) => {
                e.target.src = '/assets/img/Espresso.jpeg';
              }}
            />
          </div>
        </div>

        {/* Values Cards */}
        <div style={{ background: 'var(--secondary)', borderRadius: 'var(--radius-lg)', padding: '50px 36px', border: '1px solid var(--border)', marginBottom: '80px' }}>
          <div style={{ textAlign: 'center', marginBottom: '40px' }}>
            <h2 style={{ fontSize: '1.8rem' }}>Nilai yang Kami Junjung</h2>
          </div>

          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(260px, 1fr))', gap: '24px' }}>
            <div style={{ background: '#fff', padding: '28px', borderRadius: 'var(--radius-md)', border: '1px solid var(--border)' }}>
              <Coffee size={32} color="var(--gold-dark)" style={{ marginBottom: '14px' }} />
              <h3 style={{ fontSize: '1.2rem', marginBottom: '10px' }}>Freshly Roasted</h3>
              <p style={{ color: 'var(--text-light)', fontSize: '0.9rem', lineHeight: '1.6' }}>
                Biji kopi dipanggang berkala dalam batch kecil untuk memastikan aroma dan kesegaran rasa selalu optimal.
              </p>
            </div>

            <div style={{ background: '#fff', padding: '28px', borderRadius: 'var(--radius-md)', border: '1px solid var(--border)' }}>
              <Heart size={32} color="var(--gold-dark)" style={{ marginBottom: '14px' }} />
              <h3 style={{ fontSize: '1.2rem', marginBottom: '10px' }}>Pelayanan Hangat</h3>
              <p style={{ color: 'var(--text-light)', fontSize: '0.9rem', lineHeight: '1.6' }}>
                Senyum ramah barista kami siap menyambut hari Anda dan merekomendasikan racikan yang paling pas.
              </p>
            </div>

            <div style={{ background: '#fff', padding: '28px', borderRadius: 'var(--radius-md)', border: '1px solid var(--border)' }}>
              <Award size={32} color="var(--gold-dark)" style={{ marginBottom: '14px' }} />
              <h3 style={{ fontSize: '1.2rem', marginBottom: '10px' }}>Standar Kebersihan</h3>
              <p style={{ color: 'var(--text-light)', fontSize: '0.9rem', lineHeight: '1.6' }}>
                Kebersihan dapur, mesin espresso, dan area duduk pelanggan selalu menjadi prioritas utama kami.
              </p>
            </div>
          </div>
        </div>

        {/* CTA */}
        <div style={{ textAlign: 'center' }}>
          <h2 style={{ fontSize: '1.8rem', marginBottom: '12px' }}>Mari Nikmati Kopi Bersama Kami</h2>
          <p style={{ color: 'var(--text-light)', marginBottom: '24px' }}>
            Kunjungi kedai kami langsung di Jl. Jendral Sudirman No. 123, Padang atau pesan secara daring.
          </p>
          <Link to="/menu" className="btn btn-accent" style={{ padding: '14px 32px' }}>
            Jelajahi Menu Sekarang
          </Link>
        </div>

      </div>
    </div>
  );
};

