
import { useMutation } from "../../../hooks/useMutation";

import type { Wallet, WalletRechargeForm } from "../types";

export function useRechargeWallet() {
  return useMutation<Wallet, WalletRechargeForm>("/wallet/recharge");
}