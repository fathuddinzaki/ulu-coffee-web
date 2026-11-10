import React, { useState } from 'react';
import { useAuth } from '../context/AuthContext';
import { useOrders } from '../context/OrderContext';
import { initialProducts, formatRupiah, categories } from '../data/products';
import { ShoppingCart, CheckCircle, Clock, XCircle, Search, MessageSquare, Plus, Trash2, Printer } from 'lucide-react';
import { Navigate } from 'react-router-dom';

export const Admin = () => {
  const { user } = useAuth();
  const { orders, updateOrderStatus, messages, placeOrder } = useOrders();

  const [activeTab, setActiveTab] = useState('pos'); // 'pos', 'orders', 'messages'

  // POS State
  const [posCart, setPosCart] = useState([]);
  const [posCustomerName, setPosCustomerName] = useState('Pelanggan Walk-in');
  const [posTable, setPosTable] = useState('01');
  const [posPayment, setPosPayment] = useState('Tunai');
  const [posCategory, setPosCategory] = useState('Semua');
  const [posSearch, setPosSearch] = useState('');

  // Orders Filter State
  const [orderFilter, setOrderFilter] = useState('Semua');

  // Verify Admin Access
  if (!user || user.role !== 'admin') {
    return <Navigate to="/login" replace />;
  }

  // POS Logic
  const handleAddToPosCart = (product) => {
    setPosCart((prev) => {
      const existing = prev.find((item) => item.id === product.id);
      if (existing) {
        return prev.map((item) =>
          item.id === product.id ? { ...item, qty: item.qty + 1 } : item
        );
      }
      return [...prev, { ...product, qty: 1 }];
    });
  };

  const handleUpdatePosQty = (id, newQty) => {
    if (newQty <= 0) {
      setPosCart((prev) => prev.filter((item) => item.id !== id));
      return;
    }
    setPosCart((prev) =>
      prev.map((item) => (item.id === id ? { ...item, qty: newQty } : item))
    );
  };

  const posTotal = posCart.reduce((sum, item) => sum + item.price * item.qty, 0);

  const handlePosCheckout = (e) => {
    e.preventDefault();
    if (posCart.length === 0) return;

    placeOrder({
      customerName: posCustomerName,
      customerEmail: 'kasir@ulucoffee.id',
      customerPhone: '0800000000',
      customerAddress: `Dine-in (Meja ${posTable})`,
      orderType: 'dine-in',
      tableNumber: posTable,
      items: posCart.map((i) => ({
        id: i.id,
        name: i.name,
        price: i.price,
        qty: i.qty,
        subtotal: i.price * i.qty,
        image: i.image
      })),
      total: posTotal,
      paymentMethod: posPayment,
      status: 'Selesai'
    });

    alert(`Pesanan Meja ${posTable} berhasil diselesaikan! Total: ${formatRupiah(posTotal)}`);
    setPosCart([]);
  };

  // Filtered Products for POS
  const filteredPosProducts = initialProducts.filter((p) => {
    const matchCat = posCategory === 'Semua' || p.category === posCategory;
    const matchSearch = p.name.toLowerCase().includes(posSearch.toLowerCase());
    return matchCat && matchSearch;
  });

  // Filtered Orders
  const filteredOrders = orders.filter((o) => {
    if (orderFilter === 'Semua') return true;
    return o.status === orderFilter;
  });

  return (
    <div className="container" style={{ paddingTop: '30px', paddingBottom: '80px', maxWidth: '1280px' }}>
      
      {/* Admin Header */}
      <div style={{ display: 'flex', flexWrap: 'wrap', justifyContent: 'space-between', alignItems: 'center', marginBottom: '24px', gap: '16px' }}>
        <div>
          <h1 style={{ fontSize: '2rem', margin: 0 }}>Panel Kasir & Admin Ulu Coffee</h1>
          <p style={{ color: 'var(--text-light)', margin: '4px 0 0 0', fontSize: '0.9rem' }}>
            Login sebagai: <strong>{user.name}</strong> ({user.email})
          </p>
        </div>

        {/* Tab Controls */}
        <div style={{ display: 'flex', background: 'var(--secondary)', borderRadius: '10px', padding: '4px', border: '1px solid var(--border)' }}>
          <button
            onClick={() => setActiveTab('pos')}
            style={{
              padding: '10px 20px',
              borderRadius: '8px',
              border: 'none',
              background: activeTab === 'pos' ? '#ffffff' : 'transparent',
              fontWeight: activeTab === 'pos' ? 700 : 500,
              boxShadow: activeTab === 'pos' ? '0 2px 8px rgba(0,0,0,0.06)' : 'none',
              cursor: 'pointer',
              color: 'var(--text)'
            }}
          >
            Kasir (POS)
          </button>
          <button
            onClick={() => setActiveTab('orders')}
            style={{
              padding: '10px 20px',
              borderRadius: '8px',
              border: 'none',
              background: activeTab === 'orders' ? '#ffffff' : 'transparent',
              fontWeight: activeTab === 'orders' ? 700 : 500,
              boxShadow: activeTab === 'orders' ? '0 2px 8px rgba(0,0,0,0.06)' : 'none',
              cursor: 'pointer',
              color: 'var(--text)'
            }}
          >
            Daftar Pesanan ({orders.length})
          </button>
          <button
            onClick={() => setActiveTab('messages')}
            style={{
              padding: '10px 20px',
              borderRadius: '8px',
              border: 'none',
              background: activeTab === 'messages' ? '#ffffff' : 'transparent',
              fontWeight: activeTab === 'messages' ? 700 : 500,
              boxShadow: activeTab === 'messages' ? '0 2px 8px rgba(0,0,0,0.06)' : 'none',
              cursor: 'pointer',
              color: 'var(--text)'
            }}
          >
            Pesan Masuk ({messages.length})
          </button>
        </div>
      </div>

      {/* TAB 1: POS / KASIR */}
      {activeTab === 'pos' && (
        <div className="pos-container">
          
          {/* Left: Product Selector */}
          <div className="pos-panel" style={{ padding: '20px' }}>
            {/* Search & Categories */}
            <div style={{ display: 'flex', gap: '12px', marginBottom: '16px' }}>
              <input
                type="text"
                placeholder="Cari menu di kasir..."
                value={posSearch}
                onChange={(e) => setPosSearch(e.target.value)}
                style={{ flex: 1, padding: '10px 14px', borderRadius: '8px', border: '1px solid var(--border)', background: 'var(--secondary)' }}
              />
            </div>

            <div style={{ display: 'flex', gap: '8px', overflowX: 'auto', paddingBottom: '12px', marginBottom: '16px' }}>
              {categories.map((c) => (
                <button
                  key={c}
                  onClick={() => setPosCategory(c)}
                  style={{
                    padding: '6px 14px',
                    borderRadius: '999px',
                    border: posCategory === c ? '1px solid var(--gold)' : '1px solid var(--border)',
                    background: posCategory === c ? 'var(--gold)' : '#fff',
                    color: posCategory === c ? '#fff' : 'var(--text)',
                    fontSize: '0.85rem',
                    fontWeight: 600,
                    cursor: 'pointer',
                    whiteSpace: 'nowrap'
                  }}
                >
                  {c}
                </button>
              ))}
            </div>

            {/* Product Cards Grid */}
            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(160px, 1fr))', gap: '14px', overflowY: 'auto' }}>
              {filteredPosProducts.map((p) => (
                <div
                  key={p.id}
                  onClick={() => handleAddToPosCart(p)}
                  style={{
                    background: '#ffffff',
                    border: '1px solid var(--border)',
                    borderRadius: '12px',
                    padding: '12px',
                    cursor: 'pointer',
                    transition: 'all 0.15s ease',
                    boxShadow: '0 2px 6px rgba(0,0,0,0.03)'
                  }}
                  onMouseEnter={(e) => { e.currentTarget.style.borderColor = 'var(--gold)'; }}
                  onMouseLeave={(e) => { e.currentTarget.style.borderColor = 'var(--border)'; }}
                >
                  <img
                    src={p.image}
                    alt={p.name}
                    style={{ width: '100%', height: '100px', objectFit: 'cover', borderRadius: '8px', marginBottom: '8px' }}
                    onError={(e) => { e.target.src = '/assets/img/Espresso.jpeg'; }}
                  />
                  <div style={{ fontWeight: 600, fontSize: '0.9rem', marginBottom: '4px', overflow: 'hidden', textOverflow: 'ellipsis', whiteSpace: 'nowrap' }}>
                    {p.name}
                  </div>
                  <div style={{ color: 'var(--gold-dark)', fontWeight: 700, fontSize: '0.9rem' }}>
                    {formatRupiah(p.price)}
                  </div>
                </div>
              ))}
            </div>
          </div>

          {/* Right: Cashier Receipt & Bill */}
          <div className="pos-panel" style={{ padding: '24px', display: 'flex', flexDirection: 'column' }}>
            <h3 style={{ margin: '0 0 16px 0', fontSize: '1.2rem', borderBottom: '1px solid var(--border)', paddingBottom: '10px' }}>
              Struk Kasir
            </h3>

            {/* Inputs */}
            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '10px', marginBottom: '16px' }}>
              <div>
                <label style={{ display: 'block', fontSize: '0.75rem', fontWeight: 600, marginBottom: '4px' }}>Nomor Meja</label>
                <input
                  type="text"
                  value={posTable}
                  onChange={(e) => setPosTable(e.target.value)}
                  style={{ width: '100%', padding: '8px', borderRadius: '6px', border: '1px solid var(--border)', boxSizing: 'border-box' }}
                />
              </div>
              <div>
                <label style={{ display: 'block', fontSize: '0.75rem', fontWeight: 600, marginBottom: '4px' }}>Metode Bayar</label>
                <select
                  value={posPayment}
                  onChange={(e) => setPosPayment(e.target.value)}
                  style={{ width: '100%', padding: '8px', borderRadius: '6px', border: '1px solid var(--border)', boxSizing: 'border-box' }}
                >
                  <option value="Tunai">Tunai / Cash</option>
                  <option value="QRIS">QRIS</option>
                  <option value="Debit Card">Debit BCA</option>
                </select>
              </div>
            </div>

            {/* Cart Items */}
            <div style={{ flex: 1, overflowY: 'auto', display: 'flex', flexDirection: 'column', gap: '12px', marginBottom: '16px' }}>
              {posCart.length === 0 ? (
                <div style={{ textAlign: 'center', color: 'var(--text-light)', padding: '40px 0', fontSize: '0.9rem' }}>
                  Klik menu di sebelah kiri untuk menambahkan ke struk
                </div>
              ) : (
                posCart.map((item) => (
                  <div key={item.id} style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', fontSize: '0.85rem' }}>
                    <div style={{ flex: 1 }}>
                      <div style={{ fontWeight: 600 }}>{item.name}</div>
                      <div style={{ color: 'var(--text-light)' }}>{formatRupiah(item.price)}</div>
                    </div>
                    
                    <div className="qty-control" style={{ transform: 'scale(0.85)' }}>
                      <button className="qty-btn" onClick={() => handleUpdatePosQty(item.id, item.qty - 1)}>-</button>
                      <span className="qty-input">{item.qty}</span>
                      <button className="qty-btn" onClick={() => handleUpdatePosQty(item.id, item.qty + 1)}>+</button>
                    </div>

                    <div style={{ fontWeight: 700, width: '70px', textAlign: 'right' }}>
                      {formatRupiah(item.price * item.qty)}
                    </div>
                  </div>
                ))
              )}
            </div>

            {/* Summary & Button */}
            <div style={{ borderTop: '2px dashed var(--border)', paddingTop: '16px' }}>
              <div style={{ display: 'flex', justifyContent: 'space-between', fontSize: '1.2rem', fontWeight: 700, marginBottom: '16px' }}>
                <span>Total:</span>
                <span style={{ color: 'var(--gold-dark)' }}>{formatRupiah(posTotal)}</span>
              </div>

              <button
                onClick={handlePosCheckout}
                disabled={posCart.length === 0}
                className="btn btn-accent"
                style={{ width: '100%', padding: '14px', fontSize: '1rem', cursor: posCart.length === 0 ? 'not-allowed' : 'pointer' }}
              >
                Bayar & Cetak Pesanan
              </button>
            </div>
          </div>

        </div>
      )}

      {/* TAB 2: ORDERS MANAGEMENT */}
      {activeTab === 'orders' && (
        <div style={{ background: '#fff', borderRadius: 'var(--radius-md)', padding: '24px', border: '1px solid var(--border)', boxShadow: 'var(--shadow-sm)' }}>
          {/* Status Filters */}
          <div style={{ display: 'flex', gap: '10px', marginBottom: '24px', flexWrap: 'wrap' }}>
            {['Semua', 'Pending', 'Diproses', 'Selesai', 'Dibatalkan'].map((st) => (
              <button
                key={st}
                onClick={() => setOrderFilter(st)}
                style={{
                  padding: '8px 18px',
                  borderRadius: '999px',
                  border: orderFilter === st ? '1px solid var(--gold)' : '1px solid var(--border)',
                  background: orderFilter === st ? 'var(--gold)' : 'var(--secondary)',
                  color: orderFilter === st ? '#fff' : 'var(--text)',
                  fontWeight: 600,
                  fontSize: '0.85rem',
                  cursor: 'pointer'
                }}
              >
                {st}
              </button>
            ))}
          </div>

          {/* Orders Table */}
          <div style={{ overflowX: 'auto' }}>
            <table style={{ width: '100%', borderCollapse: 'collapse', textAlign: 'left', minWidth: '700px' }}>
              <thead>
                <tr style={{ borderBottom: '2px solid var(--border)', color: 'var(--text-light)', fontSize: '0.85rem' }}>
                  <th style={{ padding: '12px' }}>ID Pesanan</th>
                  <th style={{ padding: '12px' }}>Pemesan</th>
                  <th style={{ padding: '12px' }}>Tipe / Meja</th>
                  <th style={{ padding: '12px' }}>Pesanan</th>
                  <th style={{ padding: '12px' }}>Total</th>
                  <th style={{ padding: '12px' }}>Status Saat Ini</th>
                  <th style={{ padding: '12px' }}>Aksi Status</th>
                </tr>
              </thead>
              <tbody>
                {filteredOrders.map((ord) => (
                  <tr key={ord.id} style={{ borderBottom: '1px solid var(--border)', fontSize: '0.9rem' }}>
                    <td style={{ padding: '14px 12px', fontWeight: 700 }}>{ord.id}</td>
                    <td style={{ padding: '14px 12px' }}>
                      <div style={{ fontWeight: 600 }}>{ord.customerName}</div>
                      <div style={{ fontSize: '0.75rem', color: 'var(--text-light)' }}>{ord.customerPhone}</div>
                    </td>
                    <td style={{ padding: '14px 12px' }}>{ord.customerAddress}</td>
                    <td style={{ padding: '14px 12px' }}>
                      {ord.items?.map((it, i) => (
                        <div key={i} style={{ fontSize: '0.8rem' }}>
                          {it.qty}x {it.name}
                        </div>
                      ))}
                    </td>
                    <td style={{ padding: '14px 12px', fontWeight: 700, color: 'var(--gold-dark)' }}>
                      {formatRupiah(ord.total)}
                    </td>
                    <td style={{ padding: '14px 12px' }}>
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
                    </td>
                    <td style={{ padding: '14px 12px' }}>
                      <select
                        value={ord.status}
                        onChange={(e) => updateOrderStatus(ord.id, e.target.value)}
                        style={{ padding: '6px 10px', borderRadius: '6px', border: '1px solid var(--border)', fontSize: '0.85rem' }}
                      >
                        <option value="Pending">Pending</option>
                        <option value="Diproses">Diproses</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Dibatalkan">Dibatalkan</option>
                      </select>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      )}

      {/* TAB 3: MESSAGES */}
      {activeTab === 'messages' && (
        <div style={{ background: '#fff', borderRadius: 'var(--radius-md)', padding: '24px', border: '1px solid var(--border)', boxShadow: 'var(--shadow-sm)' }}>
          <h3 style={{ margin: '0 0 20px 0' }}>Pesan Masuk dari Formulir Kontak ({messages.length})</h3>

          {messages.length === 0 ? (
            <p style={{ color: 'var(--text-light)', textAlign: 'center', padding: '40px 0' }}>
              Belum ada pesan baru dari pelanggan.
            </p>
          ) : (
            <div style={{ display: 'flex', flexDirection: 'column', gap: '16px' }}>
              {messages.map((m) => (
                <div key={m.id} style={{ background: 'var(--secondary)', borderRadius: '10px', padding: '18px', border: '1px solid var(--border)' }}>
                  <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '8px' }}>
                    <strong>{m.name} ({m.email})</strong>
                    <span style={{ fontSize: '0.8rem', color: 'var(--text-light)' }}>{m.date}</span>
                  </div>
                  <p style={{ margin: 0, color: '#374151', fontSize: '0.95rem' }}>{m.message}</p>
                </div>
              ))}
            </div>
          )}
        </div>
      )}

    </div>
  );
};

