import React, { useState } from 'react';
import { Link, NavLink, useNavigate } from 'react-router-dom';
import { useCart } from '../context/CartContext';
import { useAuth } from '../context/AuthContext';
import { ShoppingBag, User, Menu, X, Coffee, Shield } from 'lucide-react';

export const Navbar = () => {
  const { totalCount } = useCart();
  const { user } = useAuth();
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const navigate = useNavigate();

  const toggleMobileMenu = () => setMobileMenuOpen(!mobileMenuOpen);
  const closeMobileMenu = () => setMobileMenuOpen(false);

  return (
    <header>
      <div className="container">
        <nav>
          {/* Brand Logo */}
          <Link to="/" className="logo" onClick={closeMobileMenu}>
            <img src="/assets/img/logo.jpeg" alt="Ulu Coffee" className="logo-img" onError={(e) => { e.target.style.display = 'none'; }} />
            <span>Ulu</span> Coffe.
          </Link>

          {/* Desktop Nav Links */}
          <ul className={`nav-links ${mobileMenuOpen ? 'active' : ''}`} style={mobileMenuOpen ? { display: 'flex', flexDirection: 'column', position: 'absolute', top: '72px', left: 0, right: 0, background: '#ffffff', padding: '24px', boxShadow: '0 10px 30px rgba(0,0,0,0.1)', borderBottom: '1px solid var(--border)' } : {}}>
            <li>
              <NavLink to="/" onClick={closeMobileMenu} style={({ isActive }) => ({ color: isActive ? 'var(--gold)' : 'var(--text)', fontWeight: isActive ? 600 : 500 })}>
                Beranda
              </NavLink>
            </li>
            <li>
              <NavLink to="/menu" onClick={closeMobileMenu} style={({ isActive }) => ({ color: isActive ? 'var(--gold)' : 'var(--text)', fontWeight: isActive ? 600 : 500 })}>
                Menu
              </NavLink>
            </li>
            <li>
              <NavLink to="/about" onClick={closeMobileMenu} style={({ isActive }) => ({ color: isActive ? 'var(--gold)' : 'var(--text)', fontWeight: isActive ? 600 : 500 })}>
                Tentang Kami
              </NavLink>
            </li>
            <li>
              <NavLink to="/contact" onClick={closeMobileMenu} style={({ isActive }) => ({ color: isActive ? 'var(--gold)' : 'var(--text)', fontWeight: isActive ? 600 : 500 })}>
                Kontak
              </NavLink>
            </li>
            {user?.role === 'admin' && (
              <li>
                <NavLink to="/admin" onClick={closeMobileMenu} style={({ isActive }) => ({ color: isActive ? 'var(--gold)' : 'var(--text)', fontWeight: 600, display: 'flex', alignItems: 'center', gap: '5px' })}>
                  <Shield size={16} /> Admin POS
                </NavLink>
              </li>
            )}
          </ul>

          {/* Header Action Buttons */}
          <div className="header-actions">
            {/* User Profile / Login */}
            {user ? (
              <Link to="/profile" className="nav-icon" title={`Akun: ${user.name}`} style={{ display: 'flex', alignItems: 'center', gap: '8px', color: 'var(--text)' }}>
                <div style={{ width: '32px', height: '32px', borderRadius: '50%', background: 'var(--secondary)', display: 'flex', alignItems: 'center', justifyContent: 'center', border: '1px solid var(--border)' }}>
                  <User size={18} color="var(--gold-dark)" />
                </div>
                <span style={{ fontSize: '0.9rem', fontWeight: 600, display: window.innerWidth < 640 ? 'none' : 'inline' }}>
                  {user.name.split(' ')[0]}
                </span>
              </Link>
            ) : (
              <Link to="/login" className="btn btn-sm btn-outline" style={{ padding: '6px 14px', fontSize: '0.85rem' }}>
                Masuk
              </Link>
            )}

            {/* Cart Icon with Counter */}
            <Link to="/cart" className="cart-wrapper nav-icon" title="Keranjang Belanja" style={{ position: 'relative', display: 'flex', alignItems: 'center' }}>
              <ShoppingBag size={22} color="var(--text)" />
              {totalCount > 0 && (
                <span className="cart-count" style={{ position: 'absolute', top: '-8px', right: '-10px', background: 'var(--gold)', color: '#fff', fontSize: '0.75rem', fontWeight: 700, width: '20px', height: '20px', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                  {totalCount}
                </span>
              )}
            </Link>

            {/* Mobile Hamburger Button */}
            <button
              className="hamburger"
              onClick={toggleMobileMenu}
              aria-label="Toggle Menu"
              style={{ background: 'transparent', border: 'none', cursor: 'pointer', display: 'none', padding: '6px' }}
            >
              {mobileMenuOpen ? <X size={24} /> : <Menu size={24} />}
            </button>
          </div>
        </nav>
      </div>
    </header>
  );
};

