
import { useQuery } from "../../../hooks/useQuery";

import type { WalletBalanceQuery } from "../types";

export function useWalletBalance(params: WalletBalanceQuery) {
  return useQuery<{ balance: number }, WalletBalanceQuery>(
    "/wallet/balance",
    { params, immediate: false }
  );
}