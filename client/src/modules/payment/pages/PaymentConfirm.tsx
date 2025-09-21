import React, { useState, useRef, useEffect } from "react";
import { useParams, useNavigate } from "react-router-dom";

import { usePaymentConfirm } from "../hooks/usePaymentConfirm";

export default function PaymentConfirm() {
  const { session_id } = useParams<{ session_id: string }>();
  const { submit, loading, data } = usePaymentConfirm();
  const navigate = useNavigate();

  const [otp, setOtp] = useState(Array(6).fill(""));
  const inputsRef = useRef<(HTMLInputElement | null)[]>([]);

  const handleChange = (value: string, index: number) => {
    if (/^[0-9]?$/.test(value)) {
      const newOtp = [...otp];
      newOtp[index] = value;
      setOtp(newOtp);

      if (value && index < 5) {
        inputsRef.current[index + 1]?.focus();
      }
    }
  };

  const handlePaste = (e: React.ClipboardEvent<HTMLInputElement>) => {
    const paste = e.clipboardData.getData("text").trim();
    if (/^\d{6}$/.test(paste)) {
      setOtp(paste.split(""));
      inputsRef.current[5]?.focus();
    }
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    const code = otp.join("");
    if (code.length < 6) return;
    void submit({ session_id: session_id!, otp: code });
  };

  useEffect(() => {
    if (data?.transaction_id) {
      const timer = setTimeout(() => {
        navigate("/payment");
      }, 2000);
      return () => clearTimeout(timer);
    }
  }, [data, navigate]);

  return (
    <div className="flex flex-col items-center justify-center min-h-screen p-6">
      <form
        onSubmit={handleSubmit}
        className="w-full max-w-md bg-white shadow-md rounded-md p-8 space-y-6 border border-gray-200"
      >
        <h2 className="text-3xl font-bold text-gray-800 text-center">
          Confirmar Pago
        </h2>
        <p className="text-center text-gray-600">
          Ingresa el código OTP enviado a tu correo electrónico
        </p>

        <div className="flex justify-between gap-2" onPaste={handlePaste}>
          {otp.map((digit, i) => (
            <input
              key={i}
              ref={(el) => {
                inputsRef.current[i] = el;
              }}
              type="text"
              inputMode="numeric"
              maxLength={1}
              value={digit}
              onChange={(e) => handleChange(e.target.value, i)}
              className="w-12 h-12 text-center text-lg border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            />
          ))}
        </div>

        <button
          type="submit"
          disabled={loading}
          className="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition disabled:opacity-50 disabled:cursor-not-allowed"
        >
          {loading ? "Validando..." : "Confirmar Pago"}
        </button>
      </form>
    </div>
  );
}
