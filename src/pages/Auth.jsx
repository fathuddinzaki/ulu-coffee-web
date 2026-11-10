import React, { useState } from 'react';
import { useNavigate, useLocation } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import { User, Lock, Mail, Phone, Coffee, ArrowRight, Shield } from 'lucide-react';

export const Auth = () => {
  const [isRegister, setIsRegister] = useState(false);
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [name, setName] = useState('');
  const [phone, setPhone] = useState('');
  const [address, setAddress] = useState('');
  const [error, setError] = useState('');

  const { login, register, user } = useAuth();
  const navigate = useNavigate();

  // If already logged in
  if (user) {
    navigate('/profile');
    return null;
  }

  const handleLogin = (e) => {
    e.preventDefault();
    setError('');
    const res = login(email, password);
    if (res.success) {
      if (res.user.role === 'admin') {
        navigate('/admin');
      } else {
        navigate('/profile');
      }
    } else {
      setError(res.message);
    }
  };

  const handleRegister = (e) => {
    e.preventDefault();
    setError('');
    const res = register({ name, email, password, phone, address });
    if (res.success) {
      navigate('/profile');
    } else {
      setError(res.message);
    }
  };

  const fillAdminDemo = () => {
    setEmail('admin@toko.com');
    setPassword('admin123');
    setIsRegister(false);
  };

  return (
    <div className="container" style={{ paddingTop: '60px', paddingBottom: '90px', maxWidth: '480px' }}>
      <div
        style={{
          background: '#ffffff',
          borderRadius: 'var(--radius-lg)',
          padding: '36px',
          border: '1px solid var(--border)',
          boxShadow: 'var(--shadow-md)'
        }}
      >
        <div style={{ textAlign: 'center', marginBottom: '28px' }}>
          <div
            style={{
              width: '56px',
              height: '56px',
              borderRadius: '50%',
              background: 'var(--secondary)',
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'center',
              margin: '0 auto 16px',
              color: 'var(--gold-dark)'
            }}
          >
            <Coffee size={28} />
          </div>
          <h1 style={{ fontSize: '1.8rem', margin: '0 0 8px 0' }}>
            {isRegister ? 'Daftar Akun Baru' : 'Masuk ke Ulu Coffee'}
          </h1>
          <p style={{ color: 'var(--text-light)', fontSize: '0.9rem', margin: 0 }}>
            {isRegister ? 'Nikmati promo member dan kemudahan checkout' : 'Kelola pesanan dan nikmati kopi favorit Anda'}
          </p>
        </div>

        {/* Tab Switcher */}
        <div style={{ display: 'flex', background: 'var(--secondary)', borderRadius: '10px', padding: '4px', marginBottom: '24px' }}>
          <button
            type="button"
            onClick={() => { setIsRegister(false); setError(''); }}
            style={{
              flex: 1,
              padding: '10px',
              borderRadius: '8px',
              border: 'none',
              background: !isRegister ? '#fff' : 'transparent',
              fontWeight: !isRegister ? 700 : 500,
              boxShadow: !isRegister ? '0 2px 8px rgba(0,0,0,0.06)' : 'none',
              cursor: 'pointer',
              color: 'var(--text)'
            }}
          >
            Masuk
          </button>
          <button
            type="button"
            onClick={() => { setIsRegister(true); setError(''); }}
            style={{
              flex: 1,
              padding: '10px',
              borderRadius: '8px',
              border: 'none',
              background: isRegister ? '#fff' : 'transparent',
              fontWeight: isRegister ? 700 : 500,
              boxShadow: isRegister ? '0 2px 8px rgba(0,0,0,0.06)' : 'none',
              cursor: 'pointer',
              color: 'var(--text)'
            }}
          >
            Daftar
          </button>
        </div>

        {error && (
          <div style={{ background: '#fee2e2', color: '#b91c1c', padding: '10px 14px', borderRadius: '8px', fontSize: '0.85rem', marginBottom: '18px' }}>
            {error}
          </div>
        )}

        {/* Forms */}
        {!isRegister ? (
          <form onSubmit={handleLogin} style={{ display: 'flex', flexDirection: 'column', gap: '16px' }}>
            <div>
              <label style={{ display: 'block', fontSize: '0.85rem', fontWeight: 600, marginBottom: '6px' }}>Email</label>
              <div style={{ position: 'relative' }}>
                <Mail size={16} color="var(--text-light)" style={{ position: 'absolute', left: '12px', top: '50%', transform: 'translateY(-50%)' }} />
                <input
                  type="email"
                  required
                  placeholder="admin@toko.com atau email Anda"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  style={{ width: '100%', padding: '12px 14px 12px 38px', borderRadius: '8px', border: '1px solid var(--border)', boxSizing: 'border-box' }}
                />
              </div>
            </div>

            <div>
              <label style={{ display: 'block', fontSize: '0.85rem', fontWeight: 600, marginBottom: '6px' }}>Password</label>
              <div style={{ position: 'relative' }}>
                <Lock size={16} color="var(--text-light)" style={{ position: 'absolute', left: '12px', top: '50%', transform: 'translateY(-50%)' }} />
                <input
                  type="password"
                  required
                  placeholder="Password"
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  style={{ width: '100%', padding: '12px 14px 12px 38px', borderRadius: '8px', border: '1px solid var(--border)', boxSizing: 'border-box' }}
                />
              </div>
            </div>

            <button type="submit" className="btn btn-accent" style={{ padding: '14px', marginTop: '8px' }}>
              Masuk Sekarang
            </button>

            {/* Quick Demo Credentials */}
            <div style={{ borderTop: '1px solid var(--border)', paddingTop: '16px', marginTop: '10px', textAlign: 'center' }}>
              <button
                type="button"
                onClick={fillAdminDemo}
                style={{
                  background: 'none',
                  border: 'none',
                  color: 'var(--gold-dark)',
                  fontSize: '0.85rem',
                  fontWeight: 600,
                  cursor: 'pointer',
                  display: 'inline-flex',
                  alignItems: 'center',
                  gap: '6px'
                }}
              >
                <Shield size={14} />
                <span>Klik di sini untuk Akun Demo Admin</span>
              </button>
            </div>
          </form>
        ) : (
          <form onSubmit={handleRegister} style={{ display: 'flex', flexDirection: 'column', gap: '16px' }}>
            <div>
              <label style={{ display: 'block', fontSize: '0.85rem', fontWeight: 600, marginBottom: '6px' }}>Nama Lengkap *</label>
              <input
                type="text"
                required
                placeholder="Nama Anda"
                value={name}
                onChange={(e) => setName(e.target.value)}
                style={{ width: '100%', padding: '12px 14px', borderRadius: '8px', border: '1px solid var(--border)', boxSizing: 'border-box' }}
              />
            </div>

            <div>
              <label style={{ display: 'block', fontSize: '0.85rem', fontWeight: 600, marginBottom: '6px' }}>Email *</label>
              <input
                type="email"
                required
                placeholder="nama@email.com"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                style={{ width: '100%', padding: '12px 14px', borderRadius: '8px', border: '1px solid var(--border)', boxSizing: 'border-box' }}
              />
            </div>

            <div>
              <label style={{ display: 'block', fontSize: '0.85rem', fontWeight: 600, marginBottom: '6px' }}>Password *</label>
              <input
                type="password"
                required
                placeholder="Minimal 6 karakter"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                style={{ width: '100%', padding: '12px 14px', borderRadius: '8px', border: '1px solid var(--border)', boxSizing: 'border-box' }}
              />
            </div>

            <div>
              <label style={{ display: 'block', fontSize: '0.85rem', fontWeight: 600, marginBottom: '6px' }}>Nomor WhatsApp *</label>
              <input
                type="tel"
                required
                placeholder="08123456789"
                value={phone}
                onChange={(e) => setPhone(e.target.value)}
                style={{ width: '100%', padding: '12px 14px', borderRadius: '8px', border: '1px solid var(--border)', boxSizing: 'border-box' }}
              />
            </div>

            <button type="submit" className="btn btn-accent" style={{ padding: '14px', marginTop: '8px' }}>
              Daftar Akun Baru
            </button>
          </form>
        )}
      </div>
    </div>
  );
};

