export type Wallet = {
  id: string;
  customer_id: string;
  balance: number;
  created_at: string;
  updated_at: string;
};

export type WalletRechargeForm = {
  document: string;
  phone: string;
  value: string;
};

export type WalletBalanceQuery = {
  document: string;
  phone: string;
};