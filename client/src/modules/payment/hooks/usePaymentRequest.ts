import { useMutation } from "../../../hooks/useMutation";
import type { PaymentForm, PaymentRequestResponse } from "../types";

export function usePaymentRequest() {
  return useMutation<PaymentRequestResponse, PaymentForm>("/payment/request");
}
