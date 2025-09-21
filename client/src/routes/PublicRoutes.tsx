import React from "react";
import { Routes, Route } from "react-router-dom";

import Customer from "../modules/customer/pages/Customer";
import Wallet from "../modules/wallet/pages/Wallet";
import Payment from "../modules/payment/pages/Payment";
import PaymentConfirm from "../modules/payment/pages/PaymentConfirm";

const PublicRoutes: React.FC = () => {
  return (
    <Routes>
      <Route path="/customer" element={<Customer />} />
      <Route path="/wallet" element={<Wallet />} />
      <Route path="/payment" element={<Payment />} />
      <Route path="/payment/:session_id" element={<PaymentConfirm />} />
    </Routes>
  );
};

export default PublicRoutes;
