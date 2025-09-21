import type { Customer, CustomerForm } from '../types';
import { useMutation } from '../../../hooks/useMutation';

export function useCreateCustomer() {
  return useMutation<Customer, CustomerForm>('/customer/create');
}
