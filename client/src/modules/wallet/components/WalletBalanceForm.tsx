import React, { useState } from "react";

import { useWalletBalance } from "../hooks/useWalletBalance";

import Input from "../../../components/input/Input";

import type { WalletBalanceQuery } from "../types";

export default function WalletBalanceForm() {
  const [form, setForm] = useState<WalletBalanceQuery>({
    document: "",
    phone: "",
  });

  const { data, loading, refetch } = useWalletBalance(form);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setForm((prev) => ({ ...prev, [name]: value }));
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    void refetch(form);
  };

  return (
    <form
      onSubmit={handleSubmit}
      className="w-full max-w-lg bg-white shadow-md rounded-md p-8 space-y-6 border border-gray-200"
    >
      <h2 className="text-3xl font-bold text-gray-800 text-center">
        Consultar Balance
      </h2>

      <div className="space-y-4">
        <Input label="Documento" type="text" name="document" value={form.document} onChange={handleChange} required />
        <Input label="Teléfono" type="tel" name="phone" value={form.phone} onChange={handleChange} required />
      </div>

      <button
        type="submit"
        disabled={loading}
        className="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition disabled:opacity-50 disabled:cursor-not-allowed"
      >
        {loading ? "Cargando..." : "Consultar"}
      </button>

      {data && (
        <p className="mt-4 text-center text-gray-700 font-medium">
          Tu Balance Actual: ${data.balance.toFixed(2)}
        </p>
      )}
    </form>
  );
}
