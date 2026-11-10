import React, { createContext, useContext, useState, useEffect } from 'react';

const OrderContext = createContext();

export const OrderProvider = ({ children }) => {
  const [orders, setOrders] = useState(() => {
    try {
      const saved = localStorage.getItem('ulu_orders');
      if (saved) return JSON.parse(saved);

      // Default sample orders
      return [
        {
          id: 'ORD-173123456',
          customerName: 'Aditiya Pratama',
          customerEmail: 'aditiya@example.com',
          customerPhone: '081234567890',
          customerAddress: 'Jl. Jendral Sudirman No. 45, Padang',
          orderDate: new Date().toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
          }),
          items: [
            { id: 3, name: 'Kopi Susu Ulu', price: 25000, qty: 2, subtotal: 50000, image: '/assets/img/kopsuulu.jpeg' },
            { id: 11, name: 'Risol Mayo Crispy', price: 15000, qty: 1, subtotal: 15000, image: '/assets/img/Risol.jpeg' }
          ],
          total: 65000,
          paymentMethod: 'QRIS',
          status: 'Diproses'
        }
      ];
    } catch {
      return [];
    }
  });

  const [messages, setMessages] = useState(() => {
    try {
      const saved = localStorage.getItem('ulu_messages');
      return saved ? JSON.parse(saved) : [];
    } catch {
      return [];
    }
  });

  useEffect(() => {
    localStorage.setItem('ulu_orders', JSON.stringify(orders));
  }, [orders]);

  useEffect(() => {
    localStorage.setItem('ulu_messages', JSON.stringify(messages));
  }, [messages]);

  const placeOrder = (orderData) => {
    const newOrder = {
      id: 'ORD-' + Math.floor(100000 + Math.random() * 900000),
      orderDate: new Date().toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      }),
      status: 'Pending',
      ...orderData
    };

    setOrders((prev) => [newOrder, ...prev]);
    return newOrder;
  };

  const updateOrderStatus = (orderId, newStatus) => {
    setOrders((prev) =>
      prev.map((order) =>
        order.id === orderId ? { ...order, status: newStatus } : order
      )
    );
  };

  const addMessage = (messageData) => {
    const newMessage = {
      id: 'MSG-' + Date.now(),
      date: new Date().toLocaleDateString('id-ID'),
      ...messageData
    };
    setMessages((prev) => [newMessage, ...prev]);
    return newMessage;
  };

  return (
    <OrderContext.Provider
      value={{
        orders,
        placeOrder,
        updateOrderStatus,
        messages,
        addMessage
      }}
    >
      {children}
    </OrderContext.Provider>
  );
};

export const useOrders = () => {
  const context = useContext(OrderContext);
  if (!context) {
    throw new Error('useOrders must be used within an OrderProvider');
  }
  return context;
};

