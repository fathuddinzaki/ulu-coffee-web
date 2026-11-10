import React from 'react';
import { Link } from 'react-router-dom';
import { Coffee, MapPin, Phone, Mail, Clock } from 'lucide-react';

export const Footer = () => {
  return (
    <footer style={{ background: '#1d1d1f', color: '#f5f5f7', paddingTop: '60px', paddingBottom: '30px', marginTop: 'auto' }}>
      <div className="container">
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(240px, 1fr))', gap: '40px', marginBottom: '40px' }}>
          
          {/* Brand & Story */}
          <div>
            <div style={{ display: 'flex', alignItems: 'center', gap: '10px', marginBottom: '16px', fontSize: '1.4rem', fontWeight: 700, color: '#ffffff' }}>
              <Coffee color="var(--gold)" />
              <span>Ulu <span style={{ color: 'var(--gold)' }}>Coffe.</span></span>
            </div>
            <p style={{ color: '#a1a1a6', fontSize: '0.9rem', lineHeight: '1.6', marginBottom: '20px' }}>
              Kedai kopi artisan yang menghadirkan biji kopi lokal terbaik dengan sentuhan modern, menyajikan kenyamanan di setiap seduhan untuk hari istimewa Anda.
            </p>
            <div style={{ display: 'flex', gap: '14px' }}>
              <a href="https://instagram.com" target="_blank" rel="noreferrer" style={{ width: '36px', height: '36px', borderRadius: '50%', background: 'rgba(255,255,255,0.1)', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#fff' }}>
                <i className="fab fa-instagram"></i>
              </a>
              <a href="https://facebook.com" target="_blank" rel="noreferrer" style={{ width: '36px', height: '36px', borderRadius: '50%', background: 'rgba(255,255,255,0.1)', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#fff' }}>
                <i className="fab fa-facebook-f"></i>
              </a>
            </div>
          </div>

          {/* Quick Links */}
          <div>
            <h4 style={{ color: '#fff', fontSize: '1.1rem', marginBottom: '20px' }}>Navigasi Cepat</h4>
            <ul style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex', flexDirection: 'column', gap: '10px', fontSize: '0.9rem' }}>
              <li><Link to="/" style={{ color: '#a1a1a6' }}>Beranda</Link></li>
              <li><Link to="/menu" style={{ color: '#a1a1a6' }}>Daftar Menu & Kopi</Link></li>
              <li><Link to="/about" style={{ color: '#a1a1a6' }}>Tentang Kami</Link></li>
              <li><Link to="/contact" style={{ color: '#a1a1a6' }}>Kontak & Lokasi</Link></li>
              <li><Link to="/cart" style={{ color: '#a1a1a6' }}>Keranjang Pesanan</Link></li>
            </ul>
          </div>

          {/* Contact Details */}
          <div>
            <h4 style={{ color: '#fff', fontSize: '1.1rem', marginBottom: '20px' }}>Hubungi Kami</h4>
            <ul style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex', flexDirection: 'column', gap: '14px', fontSize: '0.9rem', color: '#a1a1a6' }}>
              <li style={{ display: 'flex', gap: '12px' }}>
                <MapPin size={18} color="var(--gold)" style={{ flexShrink: 0, marginTop: '2px' }} />
                <span>Jl. Jendral Sudirman No. 123, Padang, Sumatera Barat</span>
              </li>
              <li style={{ display: 'flex', gap: '12px' }}>
                <Phone size={18} color="var(--gold)" style={{ flexShrink: 0 }} />
                <span>+62 812-3456-7890</span>
              </li>
              <li style={{ display: 'flex', gap: '12px' }}>
                <Mail size={18} color="var(--gold)" style={{ flexShrink: 0 }} />
                <span>halo@ulucoffee.id</span>
              </li>
            </ul>
          </div>

          {/* Operating Hours */}
          <div>
            <h4 style={{ color: '#fff', fontSize: '1.1rem', marginBottom: '20px' }}>Jam Buka</h4>
            <div style={{ display: 'flex', gap: '12px', color: '#a1a1a6', fontSize: '0.9rem', lineHeight: '1.6' }}>
              <Clock size={18} color="var(--gold)" style={{ flexShrink: 0, marginTop: '2px' }} />
              <div>
                <p style={{ margin: 0, color: '#fff', fontWeight: 600 }}>Senin - Minggu</p>
                <p style={{ margin: '4px 0 0 0' }}>09:00 - 23:00 WIB</p>
                <p style={{ margin: '8px 0 0 0', color: 'var(--gold)', fontSize: '0.85rem' }}>Dine-in, Takeaway & Online Delivery</p>
              </div>
            </div>
          </div>

        </div>

        <div style={{ borderTop: '1px solid rgba(255,255,255,0.1)', paddingTop: '24px', textAlign: 'center', fontSize: '0.85rem', color: '#86868b' }}>
          &copy; {new Date().getFullYear()} Ulu Coffee Indonesia. Dilindungi Hak Cipta. Dikembangkan dengan React.js.
        </div>
      </div>
    </footer>
  );
};
