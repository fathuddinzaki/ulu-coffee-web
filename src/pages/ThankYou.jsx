import React from 'react';
import { useParams, Link } from 'react-router-dom';
import { useOrders } from '../context/OrderContext';
import { formatRupiah } from '../data/products';
import { CheckCircle2, QrCode, MessageCircle, ArrowRight, Coffee, Calendar, MapPin, Receipt, Printer } from 'lucide-react';

export const ThankYou = () => {
  const { orderId } = useParams();
  const { orders } = useOrders();

  const order = orders.find((o) => o.id === orderId) || orders[0];

  return (
    <div className="container" style={{ paddingTop: '50px', paddingBottom: '90px', maxWidth: '750px' }}>
      
      <div
        style={{
          background: '#ffffff',
          borderRadius: 'var(--radius-lg)',
          padding: '40px 32px',
          border: '1px solid var(--border)',
          boxShadow: 'var(--shadow-md)',
          textAlign: 'center'
        }}
      >
        {/* Success Icon */}
        <div
          style={{
            width: '80px',
            height: '80px',
            borderRadius: '50%',
            background: '#dcfce7',
            color: '#16a34a',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center',
            margin: '0 auto 20px'
          }}
        >
          <CheckCircle2 size={46} />
        </div>

        <h1 style={{ fontSize: '2.2rem', marginBottom: '8px' }}>Pesanan Berhasil Dibuat!</h1>
        <p style={{ color: 'var(--text-light)', fontSize: '1.05rem', marginBottom: '24px' }}>
          Terima kasih telah memesan di Ulu Coffee. Barista kami sedang mempersiapkan sajian terbaik Anda.
        </p>

        {/* Order ID Badge */}
        <div
          style={{
            display: 'inline-flex',
            alignItems: 'center',
            gap: '8px',
            background: 'var(--secondary)',
            padding: '8px 20px',
            borderRadius: '999px',
            fontWeight: 700,
            fontSize: '1rem',
            color: 'var(--gold-dark)',
            marginBottom: '32px'
          }}
        >
          <Receipt size={18} />
          ID Pesanan: {order ? order.id : orderId}
        </div>

        {/* Payment Simulation Section */}
        {order?.paymentMethod === 'QRIS' && (
          <div
            style={{
              background: '#fafafc',
              border: '2px dashed var(--gold)',
              borderRadius: 'var(--radius-md)',
              padding: '24px',
              maxWidth: '340px',
              margin: '0 auto 32px'
            }}
          >
            <div style={{ fontWeight: 700, marginBottom: '8px', fontSize: '1rem' }}>Scan QRIS untuk Bayar</div>
            <p style={{ fontSize: '0.8rem', color: 'var(--text-light)', margin: '0 0 16px 0' }}>
              Buka aplikasi GoPay / BCA / Livin / ShopeePay Anda
            </p>
            
            {/* Simulated QR Code */}
            <div
              style={{
                width: '180px',
                height: '180px',
                background: '#ffffff',
                border: '1px solid var(--border)',
                margin: '0 auto 16px',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                borderRadius: '12px',
                boxShadow: '0 4px 12px rgba(0,0,0,0.06)'
              }}
            >
              <QrCode size={130} color="#1d1d1f" />
            </div>

            <div style={{ fontSize: '1.2rem', fontWeight: 700, color: 'var(--gold-dark)' }}>
              {formatRupiah(order.total)}
            </div>
            <span style={{ fontSize: '0.75rem', color: '#16a34a', fontWeight: 600 }}>
              Menunggu Pembayaran (Otomatis Verifikasi)
            </span>
          </div>
        )}

        {/* Order Summary Box */}
        {order && (
          <div
            style={{
              textAlign: 'left',
              background: 'var(--secondary)',
              borderRadius: 'var(--radius-md)',
              padding: '24px',
              marginBottom: '32px',
              fontSize: '0.9rem'
            }}
          >
            <h4 style={{ margin: '0 0 16px 0', fontSize: '1.05rem', borderBottom: '1px solid var(--border)', paddingBottom: '10px' }}>
              Rincian Pesanan
            </h4>

            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '12px', marginBottom: '16px' }}>
              <div>
                <span style={{ color: 'var(--text-light)', display: 'block', fontSize: '0.8rem' }}>Nama Pemesan:</span>
                <strong>{order.customerName}</strong>
              </div>
              <div>
                <span style={{ color: 'var(--text-light)', display: 'block', fontSize: '0.8rem' }}>Metode Pembayaran:</span>
                <strong>{order.paymentMethod}</strong>
              </div>
              <div>
                <span style={{ color: 'var(--text-light)', display: 'block', fontSize: '0.8rem' }}>Tujuan / Lokasi:</span>
                <strong>{order.customerAddress}</strong>
              </div>
              <div>
                <span style={{ color: 'var(--text-light)', display: 'block', fontSize: '0.8rem' }}>Status Pesanan:</span>
                <span className="badge badge-processing">{order.status}</span>
              </div>
            </div>

            <div style={{ borderTop: '1px solid var(--border)', paddingTop: '12px', display: 'flex', flexDirection: 'column', gap: '8px' }}>
              {order.items?.map((it, idx) => (
                <div key={idx} style={{ display: 'flex', justifyContent: 'space-between' }}>
                  <span>{it.qty}x {it.name}</span>
                  <span>{formatRupiah(it.price * it.qty)}</span>
                </div>
              ))}
              <div style={{ display: 'flex', justifyContent: 'space-between', borderTop: '1px solid var(--border)', paddingTop: '10px', marginTop: '6px', fontWeight: 700, fontSize: '1.05rem' }}>
                <span>Total:</span>
                <span style={{ color: 'var(--gold-dark)' }}>{formatRupiah(order.total)}</span>
              </div>
            </div>
          </div>
        )}

        {/* Buttons */}
        <div style={{ display: 'flex', flexWrap: 'wrap', gap: '14px', justifyContent: 'center' }}>
          <button
            onClick={() => window.print()}
            className="btn btn-outline"
            style={{ display: 'inline-flex', alignItems: 'center', gap: '8px' }}
          >
            <Printer size={18} />
            <span>Cetak Struk</span>
          </button>

          <a
            href={`https://wa.me/6281234567890?text=${encodeURIComponent(`Halo Kasir Ulu Coffee, saya sudah memesan dengan nomor pesanan: ${order?.id || orderId}`)}`}
            target="_blank"
            rel="noreferrer"
            className="btn btn-outline"
            style={{ display: 'inline-flex', alignItems: 'center', gap: '8px', color: '#16a34a', borderColor: '#16a34a' }}
          >
            <MessageCircle size={18} />
            <span>Konfirmasi ke WhatsApp Kasir</span>
          </a>

          <Link to="/menu" className="btn btn-accent" style={{ display: 'inline-flex', alignItems: 'center', gap: '8px' }}>
            <span>Pesan Lagi</span>
            <ArrowRight size={18} />
          </Link>
        </div>

      </div>
    </div>
  );
};

