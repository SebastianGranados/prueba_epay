import React, { useState } from "react";

import { useCreateCustomer } from "../hooks/useCreateCustomer";

import Input from "../../../components/input/Input";

import type { CustomerForm } from "../types";

export default function CustomerFormComponent() {
  const { submit, loading } = useCreateCustomer();

  const [form, setForm] = useState<CustomerForm>({
    document: "",
    name: "",
    email: "",
    phone: "",
  });

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setForm((prev) => ({ ...prev, [name]: value }));
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    submit(form);
  };

  return (
    <div className="flex justify-center py-56">
      <form
        onSubmit={handleSubmit}
        className="w-full max-w-lg bg-white shadow-md rounded-md p-8 space-y-6 border border-gray-200"
      >
        <h2 className="text-3xl font-bold text-gray-800 text-center">
          Registrar Cliente
        </h2>

        <div className="space-y-4">
          <div>
            <Input
              label="Documento"
              type="text"
              name="document"
              value={form.document}
              onChange={handleChange}
              required
            />
          </div>

          <div>
            <Input
              label="Nombre"
              type="text"
              name="name"
              value={form.name}
              onChange={handleChange}
              required
            />
          </div>

          <div>
            <Input
              label="Email"
              type="email"
              name="email"
              value={form.email}
              onChange={handleChange}
              required
            />
          </div>

          <div>
            <Input
              label="Teléfono"
              type="tel"
              name="phone"
              value={form.phone}
              onChange={handleChange}
            />
          </div>
        </div>

        <button
          type="submit"
          disabled={loading}
          className="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition disabled:opacity-50 disabled:cursor-not-allowed"
        >
          {loading ? "Cargando..." : "Registrar"}
        </button>
      </form>
    </div>
  );
}