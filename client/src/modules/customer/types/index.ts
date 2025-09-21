export type CustomerForm = {
  document: string;
  name: string;
  email: string;
  phone: string;
};

export type Customer = {
  id: string;
  document: string;
  name: string;
  email: string;
  phone: string | null;
  created_at: string;
};
