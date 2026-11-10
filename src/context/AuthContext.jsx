import React, { createContext, useContext, useState, useEffect } from 'react';

const AuthContext = createContext();

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
    // Admin check
    if (email === 'admin@toko.com' && password === 'admin123') {
      const adminUser = {
        id: 'ADM-001',
        name: 'Administrator Ulu',
        email: 'admin@toko.com',
        role: 'admin',
        phone: '08123456789'
      };
      setUser(adminUser);
      return { success: true, user: adminUser };
    }

    // Regular users storage check
    const users = JSON.parse(localStorage.getItem('ulu_registered_users') || '[]');
    const found = users.find((u) => u.email.toLowerCase() === email.toLowerCase());

    if (found && found.password === password) {
      const loggedUser = {
        id: found.id,
        name: found.name,
        email: found.email,
        phone: found.phone || '',
        address: found.address || '',
        role: found.role || 'user'
      };
      setUser(loggedUser);
      return { success: true, user: loggedUser };
    }

    // Quick demo login if user types anything valid
    if (email && password) {
      const demoUser = {
        id: 'USR-' + Math.floor(1000 + Math.random() * 9000),
        name: email.split('@')[0],
        email: email,
        phone: '0812' + Math.floor(10000000 + Math.random() * 90000000),
        address: 'Padang, Sumatera Barat',
        role: 'user'
      };
      setUser(demoUser);
      return { success: true, user: demoUser };
    }

    return { success: false, message: 'Email atau password salah' };
  };

  const register = ({ name, email, password, phone, address }) => {
    const users = JSON.parse(localStorage.getItem('ulu_registered_users') || '[]');
    if (users.some((u) => u.email.toLowerCase() === email.toLowerCase())) {
      return { success: false, message: 'Email sudah terdaftar!' };
    }

    const newUser = {
      id: 'USR-' + Date.now(),
      name,
      email,
      password,
      phone,
      address,
      role: 'user'
    };

    users.push(newUser);
    localStorage.setItem('ulu_registered_users', JSON.stringify(users));

    const loggedUser = {
      id: newUser.id,
      name: newUser.name,
      email: newUser.email,
      phone: newUser.phone,
      address: newUser.address,
      role: 'user'
    };
    setUser(loggedUser);
    return { success: true, user: loggedUser };
  };

  const logout = () => {
    setUser(null);
  };

  const updateProfile = (data) => {
    setUser((prev) => ({ ...prev, ...data }));
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

