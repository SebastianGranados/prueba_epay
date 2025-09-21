import React from 'react';
import { Routes, Route } from 'react-router-dom';
import Customer from '../modules/customer/pages/Customer';

const PublicRoutes: React.FC = () => {
  return (
    <Routes>
      <Route path="/customer" element={<Customer />} />
      {/* Agrega aquí otras rutas públicas */}
    </Routes>
  );
};

export default PublicRoutes;
