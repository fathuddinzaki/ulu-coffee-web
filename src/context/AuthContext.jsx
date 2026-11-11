import React, { createContext, useContext, useState, useEffect } from 'react';
import { initialUsers } from '../data/users';

const AuthContext = createContext();

/**
 * Mengambil seluruh daftar pengguna dari localStorage dan database seed awal.
 */
const getAllUsers = () => {
  try {
    const registered = JSON.parse(localStorage.getItem('ulu_registered_users') || '[]');
    // Hindari duplikasi jika email sudah ada di localStorage
    const seeded = initialUsers.filter(
      (seed) => !registered.some((reg) => reg.email.toLowerCase() === seed.email.toLowerCase())
    );
    return [...seeded, ...registered];
  } catch {
    return initialUsers;
  }
};

const toSessionUser = ({ password: _password, ...safeUser }) => safeUser;

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(() => {
    try {
      const saved = localStorage.getItem('ulu_user');
      return saved ? JSON.parse(saved) : null;
    } catch {
      return null;
    }
  });

  useEffect(() => {
    if (user) {
      localStorage.setItem('ulu_user', JSON.stringify(user));
    } else {
      localStorage.removeItem('ulu_user');
    }
  }, [user]);

  const login = (email, password) => {
    const normalizedEmail = email.trim().toLowerCase();
    const allUsers = getAllUsers();
    const found = allUsers.find((u) => u.email.toLowerCase() === normalizedEmail);

    if (!found) {
      return { success: false, message: 'Email tidak terdaftar di database.' };
    }

    if (found.password !== password) {
      return { success: false, message: 'Password yang Anda masukkan salah.' };
    }

    const sessionUser = toSessionUser(found);
    setUser(sessionUser);
    return { success: true, user: sessionUser };
  };

  const register = ({ name, email, password, phone, address }) => {
    const normalizedEmail = email.trim().toLowerCase();
    const allUsers = getAllUsers();

    if (allUsers.some((u) => u.email.toLowerCase() === normalizedEmail)) {
      return { success: false, message: 'Email sudah terdaftar!' };
    }

    const newUser = {
      id: 'USR-' + Date.now(),
      name: name.trim(),
      email: normalizedEmail,
      password,
      phone: phone?.trim() || '',
      address: address?.trim() || '',
      role: 'user',
      createdAt: new Date().toISOString()
    };

    const registered = JSON.parse(localStorage.getItem('ulu_registered_users') || '[]');
    registered.push(newUser);
    localStorage.setItem('ulu_registered_users', JSON.stringify(registered));

    const sessionUser = toSessionUser(newUser);
    setUser(sessionUser);
    return { success: true, user: sessionUser };
  };

  const logout = () => {
    setUser(null);
  };

  const updateProfile = (data) => {
    setUser((prev) => {
      if (!prev) return prev;
      const updated = { ...prev, ...data };

      // Sinkronkan perubahan profil ke localStorage jika user berasal dari daftar registrasi
      try {
        const registered = JSON.parse(localStorage.getItem('ulu_registered_users') || '[]');
        const idx = registered.findIndex((u) => u.email.toLowerCase() === prev.email.toLowerCase());
        if (idx !== -1) {
          registered[idx] = { ...registered[idx], ...data };
          localStorage.setItem('ulu_registered_users', JSON.stringify(registered));
        }
      } catch (e) {
        console.error('Failed to sync profile update', e);
      }

      return updated;
    });
  };

  return (
    <AuthContext.Provider value={{ user, login, register, logout, updateProfile }}>
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => {
  const context = useContext(AuthContext);
  if (!context) {
    throw new Error('useAuth must be used within an AuthProvider');
  }
  return context;
};
