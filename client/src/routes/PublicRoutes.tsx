import React from 'react';
import { Routes, Route } from 'react-router-dom';

import Customer from '../modules/customer/pages/Customer';
import Wallet from '../modules/wallet/pages/Wallet';

const PublicRoutes: React.FC = () => {
  return (
    <Routes>
      <Route path="/customer" element={<Customer />} />
      <Route path="/wallet" element={<Wallet />} />
    </Routes>
  );
};

export default PublicRoutes;
