import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';

import Layout from './Layout/Layout';
import Customer from './modules/customer/pages/Customer';
import AlertToast from './components/alerts/AlertToast';

function App() {
  return (
    <Router>
      <AlertToast />

      <Routes>
        <Route path="/" element={<Layout />}> 
          <Route index element={<div className="text-center text-gray-700">Bienvenido 👋</div>} />
          <Route path="customer" element={<Customer />} />
        </Route>
      </Routes>
    </Router>
  );
}

export default App;
