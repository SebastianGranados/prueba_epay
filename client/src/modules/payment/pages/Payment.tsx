import React, { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";

import { usePaymentRequest } from "../hooks/usePaymentRequest";

import Input from "../../../components/input/Input";

import type { PaymentForm } from "../types";

export default function Payment() {
  const [form, setForm] = useState<PaymentForm>({
    document: "",
    phone: "",
    value: "",
  });

  const { submit, loading, data } = usePaymentRequest();
  const navigate = useNavigate();

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setForm((prev) => ({
      ...prev,
      [name]: name === "value" ? Number(value) : value,
    }));
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    void submit(form);
  };

  useEffect(() => {
    if (data?.session_id) {
      navigate(`/payment/${data.session_id}`);
    }
  }, [data, navigate]);

  return (
    <div className="flex flex-col items-center justify-center min-h-screen p-6">
      <form
        onSubmit={handleSubmit}
        className="w-full max-w-lg bg-white shadow-md rounded-md p-8 space-y-6 border border-gray-200"
      >
        <h2 className="text-3xl font-bold text-gray-800 text-center">
          Solicitar Pago
        </h2>

        <div className="space-y-4">
          <Input
            label="Documento"
            type="text"
            name="document"
            value={form.document}
            onChange={handleChange}
            required
          />
          <Input
            label="Teléfono"
            type="tel"
            name="phone"
            value={form.phone}
            onChange={handleChange}
            required
          />
          <Input
            label="Valor"
            type="number"
            name="value"
            value={form.value}
            onChange={handleChange}
            required
            min={1}
          />
        </div>

        <button
          type="submit"
          disabled={loading}
          className="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition disabled:opacity-50 disabled:cursor-not-allowed"
        >
          {loading ? "Cargando..." : "Solicitar Pago"}
        </button>
      </form>
    </div>
  );
}
