import React, { useState } from 'react';
import { useOrders } from '../context/OrderContext';
import { MapPin, Phone, Mail, Clock, Send, CheckCircle2 } from 'lucide-react';

export const Contact = () => {
  const { addMessage } = useOrders();
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [message, setMessage] = useState('');
  const [submitted, setSubmitted] = useState(false);

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!name || !email || !message) return;

    addMessage({ name, email, message });
    setSubmitted(true);
    setName('');
    setEmail('');
    setMessage('');

    setTimeout(() => {
      setSubmitted(false);
    }, 5000);
  };

  return (
    <div>
      <section className="hero" style={{ height: '40vh', minHeight: '300px', marginBottom: '40px' }}>
        <div className="hero-content">
          <h1>Hubungi Kami</h1>
          <p>Kami siap mendengar masukan, pertanyaan, dan reservasi Anda.</p>
        </div>
      </section>

      <div className="container" style={{ paddingBottom: '80px' }}>
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(320px, 1fr))', gap: '48px', alignItems: 'start' }}>
          
          {/* Left Info */}
          <div>
            <span style={{ color: 'var(--gold-dark)', textTransform: 'uppercase', letterSpacing: '0.1em', fontSize: '0.85rem', fontWeight: 700 }}>
              Informasi Kontak
            </span>
            <h2 style={{ fontSize: '2rem', margin: '10px 0 16px 0' }}>Ada Pertanyaan atau Saran?</h2>
            <p style={{ color: 'var(--text-light)', lineHeight: '1.7', marginBottom: '36px' }}>
              Jangan ragu untuk menghubungi tim Ulu Coffee melalui form pesan atau saluran resmi kami di bawah ini.
            </p>

            <div style={{ display: 'flex', flexDirection: 'column', gap: '24px' }}>
              <div style={{ display: 'flex', gap: '16px' }}>
                <div style={{ width: '48px', height: '48px', borderRadius: '50%', background: 'var(--secondary)', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'var(--gold-dark)', flexShrink: 0 }}>
                  <MapPin size={22} />
                </div>
                <div>
                  <h4 style={{ margin: '0 0 4px 0', fontSize: '1rem' }}>Lokasi Kedai</h4>
                  <p style={{ margin: 0, color: 'var(--text-light)', fontSize: '0.9rem', lineHeight: '1.5' }}>
                    Jl. Jendral Sudirman No. 123, Padang, Sumatera Barat
                  </p>
                </div>
              </div>

              <div style={{ display: 'flex', gap: '16px' }}>
                <div style={{ width: '48px', height: '48px', borderRadius: '50%', background: 'var(--secondary)', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'var(--gold-dark)', flexShrink: 0 }}>
                  <Phone size={22} />
                </div>
                <div>
                  <h4 style={{ margin: '0 0 4px 0', fontSize: '1rem' }}>WhatsApp / Telepon</h4>
                  <p style={{ margin: 0, color: 'var(--text-light)', fontSize: '0.9rem' }}>
                    +62 812-3456-7890
                  </p>
                </div>
              </div>

              <div style={{ display: 'flex', gap: '16px' }}>
                <div style={{ width: '48px', height: '48px', borderRadius: '50%', background: 'var(--secondary)', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'var(--gold-dark)', flexShrink: 0 }}>
                  <Mail size={22} />
                </div>
                <div>
                  <h4 style={{ margin: '0 0 4px 0', fontSize: '1rem' }}>Email Resmi</h4>
                  <p style={{ margin: 0, color: 'var(--text-light)', fontSize: '0.9rem' }}>
                    halo@ulucoffee.id
                  </p>
                </div>
              </div>

              <div style={{ display: 'flex', gap: '16px' }}>
                <div style={{ width: '48px', height: '48px', borderRadius: '50%', background: 'var(--secondary)', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'var(--gold-dark)', flexShrink: 0 }}>
                  <Clock size={22} />
                </div>
                <div>
                  <h4 style={{ margin: '0 0 4px 0', fontSize: '1rem' }}>Jam Operasional</h4>
                  <p style={{ margin: 0, color: 'var(--text-light)', fontSize: '0.9rem' }}>
                    Setiap Hari: 09:00 - 23:00 WIB
                  </p>
                </div>
              </div>
            </div>
          </div>

          {/* Right: Message Form */}
          <div
            style={{
              background: '#ffffff',
              borderRadius: 'var(--radius-lg)',
              padding: '36px',
              border: '1px solid var(--border)',
              boxShadow: 'var(--shadow-sm)'
            }}
          >
            <h3 style={{ fontSize: '1.4rem', marginBottom: '8px' }}>Kirim Pesan</h3>
            <p style={{ color: 'var(--text-light)', fontSize: '0.9rem', marginBottom: '24px' }}>
              Isi formulir di bawah ini dan kami akan membalas via email atau WhatsApp.
            </p>

            {submitted && (
              <div
                style={{
                  background: '#dcfce7',
                  color: '#15803d',
                  padding: '14px 18px',
                  borderRadius: '8px',
                  display: 'flex',
                  alignItems: 'center',
                  gap: '10px',
                  marginBottom: '20px',
                  fontSize: '0.9rem',
                  fontWeight: 500
                }}
              >
                <CheckCircle2 size={20} />
                <span>Pesan Anda telah berhasil dikirim! Tim kami akan segera menghubungi Anda.</span>
              </div>
            )}

            <form onSubmit={handleSubmit} style={{ display: 'flex', flexDirection: 'column', gap: '18px' }}>
              <div>
                <label style={{ display: 'block', fontSize: '0.85rem', fontWeight: 600, marginBottom: '6px' }}>Nama Anda *</label>
                <input
                  type="text"
                  required
                  placeholder="Nama Lengkap"
                  value={name}
                  onChange={(e) => setName(e.target.value)}
                  style={{ width: '100%', padding: '12px 14px', borderRadius: '8px', border: '1px solid var(--border)', boxSizing: 'border-box' }}
                />
              </div>

              <div>
                <label style={{ display: 'block', fontSize: '0.85rem', fontWeight: 600, marginBottom: '6px' }}>Alamat Email *</label>
                <input
                  type="email"
                  required
                  placeholder="email@example.com"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  style={{ width: '100%', padding: '12px 14px', borderRadius: '8px', border: '1px solid var(--border)', boxSizing: 'border-box' }}
                />
              </div>

              <div>
                <label style={{ display: 'block', fontSize: '0.85rem', fontWeight: 600, marginBottom: '6px' }}>Pesan / Pertanyaan *</label>
                <textarea
                  rows={4}
                  required
                  placeholder="Tuliskan pesan atau pertanyaan Anda di sini..."
                  value={message}
                  onChange={(e) => setMessage(e.target.value)}
                  style={{ width: '100%', padding: '12px 14px', borderRadius: '8px', border: '1px solid var(--border)', boxSizing: 'border-box' }}
                />
              </div>

              <button
                type="submit"
                className="btn btn-accent"
                style={{ display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '8px', padding: '14px', marginTop: '6px' }}
              >
                <Send size={18} />
                <span>Kirim Pesan Sekarang</span>
              </button>
            </form>
          </div>

        </div>
      </div>
    </div>
  );
};

