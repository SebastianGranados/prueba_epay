import { useState } from "react";

import WalletBalanceForm from "../components/WalletBalanceForm";
import WalletRechargeForm from "../components/WalletRechargeForm";

export default function WalletPage() {
  const [activeTab, setActiveTab] = useState<"balance" | "recharge">("balance");

  return (
    <div className="flex flex-col items-center justify-center min-h-screen p-6">
      <div className="flex space-x-4 mb-6">
        <button
          onClick={() => setActiveTab("balance")}
          className={`py-2 px-4 rounded-md font-semibold ${
            activeTab === "balance" ? "bg-indigo-600 text-white" : "bg-gray-200 text-gray-700"
          }`}
        >
          Consultar Balance
        </button>

        <button
          onClick={() => setActiveTab("recharge")}
          className={`py-2 px-4 rounded-md font-semibold ${
            activeTab === "recharge" ? "bg-indigo-600 text-white" : "bg-gray-200 text-gray-700"
          }`}
        >
          Recargar Wallet
        </button>
      </div>

      {activeTab === "balance" && <WalletBalanceForm />}
      {activeTab === "recharge" && <WalletRechargeForm />}
    </div>
  );
}
