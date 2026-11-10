import React, { useState, useMemo } from 'react';
import { initialProducts, categories } from '../data/products';
import { ProductCard } from '../components/ProductCard';
import { Search, X, SlidersHorizontal, Coffee } from 'lucide-react';

export const Menu = () => {
  const [selectedCategory, setSelectedCategory] = useState("Semua");
  const [searchQuery, setSearchQuery] = useState("");
  const [sortBy, setSortBy] = useState("default");

  const filteredProducts = useMemo(() => {
    return initialProducts
      .filter((product) => {
        const matchesCategory =
          selectedCategory === "Semua" || product.category === selectedCategory;
        const matchesSearch =
          product.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
          product.description.toLowerCase().includes(searchQuery.toLowerCase());
        return matchesCategory && matchesSearch;
      })
      .sort((a, b) => {
        if (sortBy === "price-low") return a.price - b.price;
        if (sortBy === "price-high") return b.price - a.price;
        if (sortBy === "rating") return (b.rating || 0) - (a.rating || 0);
        if (sortBy === "name") return a.name.localeCompare(b.name);
        return 0;
      });
  }, [selectedCategory, searchQuery, sortBy]);

  const clearFilter = () => {
    setSelectedCategory("Semua");
    setSearchQuery("");
    setSortBy("default");
  };

  return (
    <div className="container" style={{ paddingTop: '40px', paddingBottom: '80px' }}>
      
      {/* Header Title */}
      <div style={{ textAlign: 'center', marginBottom: '36px' }}>
        <h1 style={{ fontSize: '2.4rem', marginBottom: '8px' }}>Daftar Menu Ulu Coffee</h1>
        <p style={{ color: 'var(--text-light)', maxWidth: '500px', margin: '0 auto' }}>
          Dari espresso bold, kopi susu gula aren, hingga camilan renyah untuk menemani setiap tegukan.
        </p>
      </div>

      {/* Filter and Search Bar */}
      <div
        style={{
          background: '#ffffff',
          borderRadius: 'var(--radius-md)',
          padding: '20px',
          boxShadow: 'var(--shadow-sm)',
          border: '1px solid var(--border)',
          marginBottom: '36px',
          display: 'flex',
          flexDirection: 'column',
          gap: '20px'
        }}
      >
        {/* Search & Sort Controls */}
        <div style={{ display: 'flex', flexWrap: 'wrap', gap: '16px', alignItems: 'center', justifyContent: 'space-between' }}>
          
          {/* Search Box */}
          <div style={{ position: 'relative', flex: '1 1 280px', maxWidth: '420px' }}>
            <Search size={18} color="var(--text-light)" style={{ position: 'absolute', left: '16px', top: '50%', transform: 'translateY(-50%)' }} />
            <input
              type="text"
              placeholder="Cari kopi, mie, snack..."
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
              style={{
                width: '100%',
                padding: '12px 16px 12px 42px',
                borderRadius: '999px',
                border: '1px solid var(--border)',
                background: 'var(--secondary)',
                fontSize: '0.95rem',
                outline: 'none',
                boxSizing: 'border-box'
              }}
            />
            {searchQuery && (
              <button
                onClick={() => setSearchQuery("")}
                style={{
                  position: 'absolute',
                  right: '12px',
                  top: '50%',
                  transform: 'translateY(-50%)',
                  background: 'none',
                  border: 'none',
                  cursor: 'pointer',
                  color: 'var(--text-light)'
                }}
              >
                <X size={16} />
              </button>
            )}
          </div>

          {/* Sort Dropdown */}
          <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
            <SlidersHorizontal size={18} color="var(--text-light)" />
            <select
              value={sortBy}
              onChange={(e) => setSortBy(e.target.value)}
              style={{
                padding: '10px 16px',
                borderRadius: '8px',
                border: '1px solid var(--border)',
                background: '#ffffff',
                color: 'var(--text)',
                fontSize: '0.9rem',
                cursor: 'pointer',
                outline: 'none'
              }}
            >
              <option value="default">Urutkan: Rekomendasi</option>
              <option value="price-low">Harga: Termurah</option>
              <option value="price-high">Harga: Termahal</option>
              <option value="rating">Rating Tertinggi</option>
              <option value="name">Nama: A - Z</option>
            </select>
          </div>
        </div>

        {/* Category Pills */}
        <div style={{ display: 'flex', flexWrap: 'wrap', gap: '10px', borderTop: '1px solid var(--border)', paddingTop: '16px' }}>
          {categories.map((cat) => (
            <button
              key={cat}
              onClick={() => setSelectedCategory(cat)}
              className={`category-pill ${selectedCategory === cat ? 'active' : ''}`}
              style={{
                cursor: 'pointer',
                padding: '8px 20px',
                borderRadius: '999px',
                border: selectedCategory === cat ? '1px solid var(--gold)' : '1px solid var(--border)',
                background: selectedCategory === cat ? 'var(--gold)' : 'var(--secondary)',
                color: selectedCategory === cat ? '#ffffff' : 'var(--text)',
                fontWeight: selectedCategory === cat ? 600 : 500,
                fontSize: '0.9rem',
                transition: 'all 0.2s'
              }}
            >
              {cat}
            </button>
          ))}
        </div>
      </div>

      {/* Product Grid / Result Count */}
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '24px' }}>
        <h2 style={{ fontSize: '1.25rem', margin: 0 }}>
          {selectedCategory === "Semua" ? "Semua Koleksi Menu" : `Kategori: ${selectedCategory}`}
        </h2>
        <span style={{ color: 'var(--text-light)', fontSize: '0.9rem' }}>
          Menampilkan {filteredProducts.length} menu
        </span>
      </div>

      {filteredProducts.length === 0 ? (
        <div
          style={{
            background: '#ffffff',
            borderRadius: 'var(--radius-md)',
            padding: '60px 20px',
            textAlign: 'center',
            border: '1px solid var(--border)'
          }}
        >
          <Coffee size={48} color="#cbd5e1" style={{ margin: '0 auto 16px' }} />
          <h3 style={{ marginBottom: '8px' }}>Menu tidak ditemukan</h3>
          <p style={{ color: 'var(--text-light)', maxWidth: '400px', margin: '0 auto 24px' }}>
            Tidak ada produk yang cocok dengan pencarian "{searchQuery}". Coba kata kunci lain atau reset filter.
          </p>
          <button onClick={clearFilter} className="btn btn-outline">
            Reset Filter
          </button>
        </div>
      ) : (
        <div className="product-grid">
          {filteredProducts.map((product) => (
            <ProductCard key={product.id} product={product} />
          ))}
        </div>
      )}
    </div>
  );
};

