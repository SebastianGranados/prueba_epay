import { useMutation } from "../../../hooks/useMutation";
import type { PaymentConfirmForm, PaymentConfirmResponse } from "../types";

export function usePaymentConfirm() {
  return useMutation<PaymentConfirmResponse, PaymentConfirmForm>("/payment/confirm");
}
