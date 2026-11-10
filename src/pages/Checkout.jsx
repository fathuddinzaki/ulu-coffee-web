import React, { useState } from 'react';
import { useNavigate, useLocation } from 'react-router-dom';
import { useCart } from '../context/CartContext';
import { useAuth } from '../context/AuthContext';
import { useOrders } from '../context/OrderContext';
import { formatRupiah } from '../data/products';
import { CreditCard, QrCode, Wallet, Banknote, ShieldCheck, MapPin, Coffee, ArrowLeft } from 'lucide-react';

export const Checkout = () => {
  const { cart, totalPrice, clearCart } = useCart();
  const { user } = useAuth();
  const { placeOrder } = useOrders();
  const navigate = useNavigate();
  const location = useLocation();

  const discountAmount = location.state?.discountAmount || 0;
  const serviceFee = location.state?.serviceFee || (cart.length > 0 ? 2000 : 0);
  const grandTotal = location.state?.grandTotal || Math.max(0, totalPrice - discountAmount + serviceFee);

  const [orderType, setOrderType] = useState('dine-in'); // 'dine-in', 'takeaway', 'delivery'
  const [name, setName] = useState(user?.name || '');
  const [email, setEmail] = useState(user?.email || '');
  const [phone, setPhone] = useState(user?.phone || '');
  const [address, setAddress] = useState(user?.address || '');
  const [tableNumber, setTableNumber] = useState('');
  const [notes, setNotes] = useState('');
  const [paymentMethod, setPaymentMethod] = useState('QRIS');
  const [isSubmitting, setIsSubmitting] = useState(false);

  if (cart.length === 0) {
    navigate('/cart');
    return null;
  }

  const handleSubmitOrder = (e) => {
    e.preventDefault();
    if (!name || !phone) {
      alert('Mohon isi nama lengkap dan nomor telepon/WhatsApp Anda.');
      return;
    }

    if (orderType === 'delivery' && !address) {
      alert('Mohon isi alamat pengiriman.');
      return;
    }

    setIsSubmitting(true);

    setTimeout(() => {
      const order = placeOrder({
        customerName: name,
        customerEmail: email || 'tamu@ulucoffee.id',
        customerPhone: phone,
        customerAddress: orderType === 'delivery' ? address : (orderType === 'dine-in' ? `Dine-in (Meja #${tableNumber || '-'})` : 'Takeaway (Bawa Pulang)'),
        orderType,
        tableNumber,
        notes,
        items: cart.map((i) => ({
          id: i.id,
          name: i.name,
          price: i.price,
          qty: i.qty,
          subtotal: i.price * i.qty,
          image: i.image
        })),
        subtotal: totalPrice,
        discount: discountAmount,
        serviceFee,
        total: grandTotal,
        paymentMethod
      });

      clearCart();
      setIsSubmitting(false);
      navigate(`/thankyou/${order.id}`);
    }, 600);
  };

  return (
    <div className="container" style={{ paddingTop: '40px', paddingBottom: '80px' }}>
      
      <button
        onClick={() => navigate('/cart')}
        style={{
          background: 'none',
          border: 'none',
          cursor: 'pointer',
          display: 'inline-flex',
          alignItems: 'center',
          gap: '8px',
          color: 'var(--text-light)',
          fontSize: '0.9rem',
          marginBottom: '24px',
          padding: 0
        }}
      >
        <ArrowLeft size={16} />
        Kembali ke Keranjang
      </button>

      <h1 style={{ fontSize: '2.2rem', marginBottom: '32px' }}>Konfirmasi & Pembayaran</h1>

      <form onSubmit={handleSubmitOrder}>
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(320px, 1fr))', gap: '32px', alignItems: 'start' }}>
          
          {/* Left Form: Details */}
          <div style={{ display: 'flex', flexDirection: 'column', gap: '24px' }}>
            
            {/* Step 1: Order Type */}
            <div style={{ background: '#fff', padding: '24px', borderRadius: 'var(--radius-md)', border: '1px solid var(--border)', boxShadow: 'var(--shadow-sm)' }}>
              <h3 style={{ fontSize: '1.2rem', marginBottom: '16px' }}>1. Pilih Tipe Pesanan</h3>
              <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: '12px' }}>
                <button
                  type="button"
                  onClick={() => setOrderType('dine-in')}
                  style={{
                    padding: '14px 10px',
                    borderRadius: '10px',
                    border: orderType === 'dine-in' ? '2px solid var(--gold)' : '1px solid var(--border)',
                    background: orderType === 'dine-in' ? 'rgba(198, 167, 78, 0.08)' : '#fff',
                    color: orderType === 'dine-in' ? 'var(--gold-dark)' : 'var(--text)',
                    fontWeight: 600,
                    cursor: 'pointer',
                    fontSize: '0.9rem',
                    textAlign: 'center'
                  }}
                >
                  Dine-in (Di Tempat)
                </button>

                <button
                  type="button"
                  onClick={() => setOrderType('takeaway')}
                  style={{
                    padding: '14px 10px',
                    borderRadius: '10px',
                    border: orderType === 'takeaway' ? '2px solid var(--gold)' : '1px solid var(--border)',
                    background: orderType === 'takeaway' ? 'rgba(198, 167, 78, 0.08)' : '#fff',
                    color: orderType === 'takeaway' ? 'var(--gold-dark)' : 'var(--text)',
                    fontWeight: 600,
                    cursor: 'pointer',
                    fontSize: '0.9rem',
                    textAlign: 'center'
                  }}
                >
                  Takeaway (Bawa Pulang)
                </button>

                <button
                  type="button"
                  onClick={() => setOrderType('delivery')}
                  style={{
                    padding: '14px 10px',
                    borderRadius: '10px',
                    border: orderType === 'delivery' ? '2px solid var(--gold)' : '1px solid var(--border)',
                    background: orderType === 'delivery' ? 'rgba(198, 167, 78, 0.08)' : '#fff',
                    color: orderType === 'delivery' ? 'var(--gold-dark)' : 'var(--text)',
                    fontWeight: 600,
                    cursor: 'pointer',
                    fontSize: '0.9rem',
                    textAlign: 'center'
                  }}
                >
                  Delivery (Antar)
                </button>
              </div>

              {orderType === 'dine-in' && (
                <div style={{ marginTop: '16px' }}>
                  <label style={{ display: 'block', fontSize: '0.85rem', fontWeight: 600, marginBottom: '6px' }}>
                    Nomor Meja (Opsional):
                  </label>
                  <input
                    type="text"
                    placeholder="Contoh: Meja 05"
                    value={tableNumber}
                    onChange={(e) => setTableNumber(e.target.value)}
                    style={{ width: '100%', padding: '10px 14px', borderRadius: '8px', border: '1px solid var(--border)', boxSizing: 'border-box' }}
                  />
                </div>
              )}
            </div>

            {/* Step 2: Customer Contact Info */}
            <div style={{ background: '#fff', padding: '24px', borderRadius: 'var(--radius-md)', border: '1px solid var(--border)', boxShadow: 'var(--shadow-sm)' }}>
              <h3 style={{ fontSize: '1.2rem', marginBottom: '16px' }}>2. Data Pemesan</h3>
              
              <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(220px, 1fr))', gap: '16px', marginBottom: '16px' }}>
                <div>
                  <label style={{ display: 'block', fontSize: '0.85rem', fontWeight: 600, marginBottom: '6px' }}>Nama Lengkap *</label>
                  <input
                    type="text"
                    required
                    placeholder="Nama Anda"
                    value={name}
                    onChange={(e) => setName(e.target.value)}
                    style={{ width: '100%', padding: '10px 14px', borderRadius: '8px', border: '1px solid var(--border)', boxSizing: 'border-box' }}
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
                    style={{ width: '100%', padding: '10px 14px', borderRadius: '8px', border: '1px solid var(--border)', boxSizing: 'border-box' }}
                  />
                </div>
              </div>

              <div style={{ marginBottom: '16px' }}>
                <label style={{ display: 'block', fontSize: '0.85rem', fontWeight: 600, marginBottom: '6px' }}>Email (Opsional)</label>
                <input
                  type="email"
                  placeholder="email@example.com"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  style={{ width: '100%', padding: '10px 14px', borderRadius: '8px', border: '1px solid var(--border)', boxSizing: 'border-box' }}
                />
              </div>

              {orderType === 'delivery' && (
                <div style={{ marginBottom: '16px' }}>
                  <label style={{ display: 'block', fontSize: '0.85rem', fontWeight: 600, marginBottom: '6px' }}>Alamat Lengkap Pengantaran *</label>
                  <textarea
                    rows={3}
                    required
                    placeholder="Alamat jalan, nomor rumah, patokan..."
                    value={address}
                    onChange={(e) => setAddress(e.target.value)}
                    style={{ width: '100%', padding: '10px 14px', borderRadius: '8px', border: '1px solid var(--border)', boxSizing: 'border-box' }}
                  />
                </div>
              )}

              <div>
                <label style={{ display: 'block', fontSize: '0.85rem', fontWeight: 600, marginBottom: '6px' }}>Catatan untuk Barista/Dapur</label>
                <input
                  type="text"
                  placeholder="Contoh: Less sugar, es dipisah, pedas sedang..."
                  value={notes}
                  onChange={(e) => setNotes(e.target.value)}
                  style={{ width: '100%', padding: '10px 14px', borderRadius: '8px', border: '1px solid var(--border)', boxSizing: 'border-box' }}
                />
              </div>
            </div>

            {/* Step 3: Payment Method */}
            <div style={{ background: '#fff', padding: '24px', borderRadius: 'var(--radius-md)', border: '1px solid var(--border)', boxShadow: 'var(--shadow-sm)' }}>
              <h3 style={{ fontSize: '1.2rem', marginBottom: '16px' }}>3. Metode Pembayaran</h3>
              
              <div style={{ display: 'flex', flexDirection: 'column', gap: '12px' }}>
                <label
                  style={{
                    display: 'flex',
                    alignItems: 'center',
                    gap: '14px',
                    padding: '14px',
                    borderRadius: '10px',
                    border: paymentMethod === 'QRIS' ? '2px solid var(--gold)' : '1px solid var(--border)',
                    background: paymentMethod === 'QRIS' ? 'rgba(198, 167, 78, 0.05)' : '#fff',
                    cursor: 'pointer'
                  }}
                >
                  <input
                    type="radio"
                    name="payment"
                    value="QRIS"
                    checked={paymentMethod === 'QRIS'}
                    onChange={() => setPaymentMethod('QRIS')}
                  />
                  <QrCode size={22} color="var(--gold-dark)" />
                  <div style={{ flex: 1 }}>
                    <div style={{ fontWeight: 600 }}>QRIS (Instan & Bebas Biaya)</div>
                    <div style={{ fontSize: '0.8rem', color: 'var(--text-light)' }}>BCA, GoPay, OVO, ShopeePay, Dana, LinkAja, Livin Mandiri</div>
                  </div>
                </label>

                <label
                  style={{
                    display: 'flex',
                    alignItems: 'center',
                    gap: '14px',
                    padding: '14px',
                    borderRadius: '10px',
                    border: paymentMethod === 'Virtual Account BCA' ? '2px solid var(--gold)' : '1px solid var(--border)',
                    background: paymentMethod === 'Virtual Account BCA' ? 'rgba(198, 167, 78, 0.05)' : '#fff',
                    cursor: 'pointer'
                  }}
                >
                  <input
                    type="radio"
                    name="payment"
                    value="Virtual Account BCA"
                    checked={paymentMethod === 'Virtual Account BCA'}
                    onChange={() => setPaymentMethod('Virtual Account BCA')}
                  />
                  <CreditCard size={22} color="var(--gold-dark)" />
                  <div style={{ flex: 1 }}>
                    <div style={{ fontWeight: 600 }}>Virtual Account Bank (BCA / Mandiri / BRI)</div>
                    <div style={{ fontSize: '0.8rem', color: 'var(--text-light)' }}>Transfer otomatis diverifikasi sistem</div>
                  </div>
                </label>

                <label
                  style={{
                    display: 'flex',
                    alignItems: 'center',
                    gap: '14px',
                    padding: '14px',
                    borderRadius: '10px',
                    border: paymentMethod === 'Tunai di Kasir' ? '2px solid var(--gold)' : '1px solid var(--border)',
                    background: paymentMethod === 'Tunai di Kasir' ? 'rgba(198, 167, 78, 0.05)' : '#fff',
                    cursor: 'pointer'
                  }}
                >
                  <input
                    type="radio"
                    name="payment"
                    value="Tunai di Kasir"
                    checked={paymentMethod === 'Tunai di Kasir'}
                    onChange={() => setPaymentMethod('Tunai di Kasir')}
                  />
                  <Banknote size={22} color="var(--gold-dark)" />
                  <div style={{ flex: 1 }}>
                    <div style={{ fontWeight: 600 }}>Bayar Tunai di Kasir</div>
                    <div style={{ fontSize: '0.8rem', color: 'var(--text-light)' }}>Bayar langsung saat mengambil pesanan atau saat pelayan datang</div>
                  </div>
                </label>
              </div>
            </div>

          </div>

          {/* Right Summary */}
          <div style={{ background: '#fff', padding: '28px', borderRadius: 'var(--radius-md)', border: '1px solid var(--border)', boxShadow: 'var(--shadow-sm)', position: 'sticky', top: '100px' }}>
            <h3 style={{ fontSize: '1.25rem', marginBottom: '16px' }}>Detail Pesanan ({cart.length} Item)</h3>

            <div style={{ maxHeight: '240px', overflowY: 'auto', marginBottom: '16px', display: 'flex', flexDirection: 'column', gap: '12px' }}>
              {cart.map((item) => (
                <div key={item.id} style={{ display: 'flex', justifyContent: 'space-between', fontSize: '0.9rem' }}>
                  <span>{item.qty}x {item.name}</span>
                  <span style={{ fontWeight: 600 }}>{formatRupiah(item.price * item.qty)}</span>
                </div>
              ))}
            </div>

            <div style={{ borderTop: '1px solid var(--border)', paddingTop: '16px', display: 'flex', flexDirection: 'column', gap: '10px', fontSize: '0.9rem' }}>
              <div style={{ display: 'flex', justifyContent: 'space-between' }}>
                <span style={{ color: 'var(--text-light)' }}>Subtotal</span>
                <span>{formatRupiah(totalPrice)}</span>
              </div>
              {discountAmount > 0 && (
                <div style={{ display: 'flex', justifyContent: 'space-between', color: '#16a34a' }}>
                  <span>Diskon</span>
                  <span>-{formatRupiah(discountAmount)}</span>
                </div>
              )}
              <div style={{ display: 'flex', justifyContent: 'space-between' }}>
                <span style={{ color: 'var(--text-light)' }}>Biaya Layanan</span>
                <span>{formatRupiah(serviceFee)}</span>
              </div>
              <div style={{ display: 'flex', justifyContent: 'space-between', borderTop: '1px solid var(--border)', paddingTop: '12px', marginTop: '6px', fontSize: '1.1rem', fontWeight: 700 }}>
                <span>Total Bayar</span>
                <span style={{ color: 'var(--gold-dark)' }}>{formatRupiah(grandTotal)}</span>
              </div>
            </div>

            <button
              type="submit"
              disabled={isSubmitting}
              className="btn btn-accent"
              style={{ width: '100%', marginTop: '24px', padding: '16px', fontSize: '1.05rem', cursor: isSubmitting ? 'not-allowed' : 'pointer' }}
            >
              {isSubmitting ? 'Memproses Pesanan...' : 'Pesan Sekarang'}
            </button>

            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '8px', marginTop: '16px', fontSize: '0.8rem', color: 'var(--text-light)' }}>
              <ShieldCheck size={16} color="#16a34a" />
              <span>Transaksi Anda aman & tercatat otomatis di sistem</span>
            </div>
          </div>

        </div>
      </form>
    </div>
  );
};

