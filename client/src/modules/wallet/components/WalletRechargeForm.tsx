import React, { useState } from "react";

import { useRechargeWallet } from "../hooks/useRechargeWallet";

import Input from "../../../components/input/Input";

import type { WalletRechargeForm } from "../types";

export default function WalletRechargeForm() {
  const [form, setForm] = useState<WalletRechargeForm>({
    document: "",
    phone: "",
    value: "",
  });

  const { submit, loading } = useRechargeWallet();

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setForm((prev) => ({
      ...prev,
      [name]: name === "value" ? Number(value) : value,
    }));
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    submit(form);
  };

  return (
    <form
      onSubmit={handleSubmit}
      className="w-full max-w-lg bg-white shadow-md rounded-md p-8 space-y-6 border border-gray-200"
    >
      <h2 className="text-3xl font-bold text-gray-800 text-center">
        Recargar Wallet
      </h2>

      <div className="space-y-4">
        <Input label="Documento" type="text" name="document" value={form.document} onChange={handleChange} required />
        <Input label="Teléfono" type="tel" name="phone" value={form.phone} onChange={handleChange} required />
        <Input label="Monto" type="number" name="value" value={form.value} onChange={handleChange} required />
      </div>

      <button
        type="submit"
        disabled={loading}
        className="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition disabled:opacity-50 disabled:cursor-not-allowed"
      >
        {loading ? "Cargando..." : "Recargar"}
      </button>
    </form>
  );
}
