export type PaymentForm = {
  document: string;
  phone: string;
  value: string;
};

export type PaymentConfirmForm = {
  session_id: string;
  otp: string;
};

export type PaymentRequestResponse = {
  session_id: string;
};

export type PaymentConfirmResponse = {
  transaction_id: string;
};