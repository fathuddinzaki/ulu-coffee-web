import React, { useState } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import { useOrders } from '../context/OrderContext';
import { formatRupiah } from '../data/products';
import { User, LogOut, Package, Phone, Mail, MapPin, Shield, Edit3, Check } from 'lucide-react';

export const Profile = () => {
  const { user, logout, updateProfile } = useAuth();
  const { orders } = useOrders();
  const navigate = useNavigate();

  const [isEditing, setIsEditing] = useState(false);
  const [name, setName] = useState(user?.name || '');
  const [phone, setPhone] = useState(user?.phone || '');
  const [address, setAddress] = useState(user?.address || '');

  if (!user) {
    navigate('/login');
    return null;
  }

  const handleSaveProfile = (e) => {
    e.preventDefault();
    updateProfile({ name, phone, address });
    setIsEditing(false);
  };

  const userOrders = orders.filter(
    (o) => o.customerEmail?.toLowerCase() === user.email?.toLowerCase() || user.role === 'admin'
  );

  return (
    <div className="container" style={{ paddingTop: '40px', paddingBottom: '80px', maxWidth: '850px' }}>
      
      {/* Profile Card */}
      <div
        style={{
          background: '#ffffff',
          borderRadius: 'var(--radius-lg)',
          padding: '36px',
          border: '1px solid var(--border)',
          boxShadow: 'var(--shadow-sm)',
          marginBottom: '40px',
          display: 'flex',
          flexWrap: 'wrap',
          alignItems: 'center',
          justifyContent: 'space-between',
          gap: '24px'
        }}
      >
        <div style={{ display: 'flex', alignItems: 'center', gap: '20px' }}>
          <div
            style={{
              width: '70px',
              height: '70px',
              borderRadius: '50%',
              background: 'var(--secondary)',
              border: '2px solid var(--gold)',
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'center',
              color: 'var(--gold-dark)'
            }}
          >
            <User size={36} />
          </div>

          <div>
            <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
              <h2 style={{ fontSize: '1.6rem', margin: 0 }}>{user.name}</h2>
              {user.role === 'admin' && (
                <span className="badge badge-processing" style={{ display: 'flex', alignItems: 'center', gap: '4px' }}>
                  <Shield size={12} /> Admin
                </span>
              )}
            </div>
            <p style={{ color: 'var(--text-light)', margin: '4px 0 0 0', fontSize: '0.9rem' }}>
              {user.email} • {user.phone || 'Nomor HP belum diatur'}
            </p>
          </div>
        </div>

        <div style={{ display: 'flex', gap: '12px' }}>
          {user.role === 'admin' && (
            <Link to="/admin" className="btn btn-accent" style={{ padding: '10px 18px', fontSize: '0.9rem' }}>
              Buka POS Admin
            </Link>
          )}

          <button
            onClick={() => setIsEditing(!isEditing)}
            className="btn btn-outline"
            style={{ padding: '10px 18px', fontSize: '0.9rem', display: 'flex', alignItems: 'center', gap: '6px' }}
          >
            <Edit3 size={16} />
            <span>Edit Profil</span>
          </button>

          <button
            onClick={() => { logout(); navigate('/'); }}
            style={{
              background: '#fee2e2',
              color: '#b91c1c',
              border: 'none',
              padding: '10px 16px',
              borderRadius: '8px',
              cursor: 'pointer',
              fontWeight: 600,
              fontSize: '0.9rem',
              display: 'flex',
              alignItems: 'center',
              gap: '6px'
            }}
          >
            <LogOut size={16} />
            <span>Keluar</span>
          </button>
        </div>
      </div>

      {/* Edit Profile Form */}
      {isEditing && (
        <form
          onSubmit={handleSaveProfile}
          style={{
            background: '#ffffff',
            borderRadius: 'var(--radius-md)',
            padding: '28px',
            border: '1px solid var(--border)',
            boxShadow: 'var(--shadow-sm)',
            marginBottom: '40px',
            display: 'flex',
            flexDirection: 'column',
            gap: '16px'
          }}
        >
          <h3 style={{ margin: 0, fontSize: '1.2rem' }}>Perbarui Informasi Akun</h3>
          
          <div>
            <label style={{ display: 'block', fontSize: '0.85rem', fontWeight: 600, marginBottom: '6px' }}>Nama Lengkap</label>
            <input
              type="text"
              value={name}
              onChange={(e) => setName(e.target.value)}
              style={{ width: '100%', padding: '10px 14px', borderRadius: '8px', border: '1px solid var(--border)', boxSizing: 'border-box' }}
            />
          </div>

          <div>
            <label style={{ display: 'block', fontSize: '0.85rem', fontWeight: 600, marginBottom: '6px' }}>Nomor HP</label>
            <input
              type="tel"
              value={phone}
              onChange={(e) => setPhone(e.target.value)}
              style={{ width: '100%', padding: '10px 14px', borderRadius: '8px', border: '1px solid var(--border)', boxSizing: 'border-box' }}
            />
          </div>

          <div>
            <label style={{ display: 'block', fontSize: '0.85rem', fontWeight: 600, marginBottom: '6px' }}>Alamat</label>
            <textarea
              rows={2}
              value={address}
              onChange={(e) => setAddress(e.target.value)}
              style={{ width: '100%', padding: '10px 14px', borderRadius: '8px', border: '1px solid var(--border)', boxSizing: 'border-box' }}
            />
          </div>

          <div style={{ display: 'flex', gap: '10px', marginTop: '8px' }}>
            <button type="submit" className="btn btn-accent" style={{ padding: '10px 20px' }}>
              Simpan Perubahan
            </button>
            <button type="button" onClick={() => setIsEditing(false)} className="btn btn-outline" style={{ padding: '10px 20px' }}>
              Batal
            </button>
          </div>
        </form>
      )}

      {/* Order History */}
      <div>
        <div style={{ display: 'flex', alignItems: 'center', gap: '10px', marginBottom: '24px' }}>
          <Package size={24} color="var(--gold-dark)" />
          <h2 style={{ fontSize: '1.6rem', margin: 0 }}>Riwayat Pesanan</h2>
        </div>

        {userOrders.length === 0 ? (
          <div
            style={{
              background: '#ffffff',
              borderRadius: 'var(--radius-md)',
              padding: '48px 20px',
              textAlign: 'center',
              border: '1px solid var(--border)'
            }}
          >
            <p style={{ color: 'var(--text-light)', marginBottom: '20px' }}>
              Anda belum memiliki riwayat pesanan di Ulu Coffee.
            </p>
            <Link to="/menu" className="btn btn-accent">
              Pesan Menu Sekarang
            </Link>
          </div>
        ) : (
          <div style={{ display: 'flex', flexDirection: 'column', gap: '20px' }}>
            {userOrders.map((ord) => (
              <div
                key={ord.id}
                style={{
                  background: '#ffffff',
                  borderRadius: 'var(--radius-md)',
                  padding: '24px',
                  border: '1px solid var(--border)',
                  boxShadow: 'var(--shadow-sm)'
                }}
              >
                <div style={{ display: 'flex', flexWrap: 'wrap', justifyContent: 'space-between', alignItems: 'center', gap: '10px', borderBottom: '1px solid var(--border)', paddingBottom: '14px', marginBottom: '14px' }}>
                  <div>
                    <span style={{ fontWeight: 700, fontSize: '1.05rem', color: 'var(--text)' }}>{ord.id}</span>
                    <span style={{ color: 'var(--text-light)', fontSize: '0.85rem', marginLeft: '12px' }}>{ord.orderDate}</span>
                  </div>
                  <span
                    className={`badge ${
                      ord.status === 'Selesai'
                        ? 'badge-completed'
                        : ord.status === 'Dibatalkan'
                        ? 'badge-cancelled'
                        : 'badge-processing'
                    }`}
                  >
                    {ord.status}
                  </span>
                </div>

                <div style={{ display: 'flex', flexDirection: 'column', gap: '8px', marginBottom: '16px' }}>
                  {ord.items?.map((item, idx) => (
                    <div key={idx} style={{ display: 'flex', justifyContent: 'space-between', fontSize: '0.9rem' }}>
                      <span>{item.qty}x {item.name}</span>
                      <span style={{ fontWeight: 500 }}>{formatRupiah(item.price * item.qty)}</span>
                    </div>
                  ))}
                </div>

                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', borderTop: '1px solid var(--border)', paddingTop: '14px' }}>
                  <span style={{ fontSize: '0.85rem', color: 'var(--text-light)' }}>
                    Metode: <strong>{ord.paymentMethod}</strong>
                  </span>
                  <div style={{ fontSize: '1.15rem', fontWeight: 700, color: 'var(--gold-dark)' }}>
                    Total: {formatRupiah(ord.total)}
                  </div>
                </div>
              </div>
            ))}
          </div>
        )}
      </div>

    </div>
  );
};

