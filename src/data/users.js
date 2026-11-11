/**
 * Data akun bawaan yang disinkronkan dengan tabel `users` di `legacy-php/database.sql`.
 */
export const initialUsers = [
  {
    id: 'ADM-001',
    name: 'Administrator',
    email: 'admin@toko.com',
    password: 'admin123',
    phone: '08123456789',
    address: 'Bandar Lampung, Indonesia',
    role: 'admin',
    createdAt: '2023-01-01 00:00:00'
  },
  {
    id: 'ADM-002',
    name: 'Aditiya Pratama',
    email: 'aditiya@ulucoffee.id',
    password: 'aditiya123',
    phone: '081234567890',
    address: 'Padang, Sumatera Barat',
    role: 'admin',
    createdAt: '2026-11-11 00:00:00'
  }
];

