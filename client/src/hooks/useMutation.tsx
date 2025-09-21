import { useState } from "react";
import { toast } from "react-toastify";

import api from "../axios/config";

import type { AxiosError } from "axios";
import type { Params } from "react-router-dom";
import type { ApiResponse } from "../axios/types/request.types";


type FieldErrors = Record<string, string[]>;

interface UseMutationReturn<T, P> {
  loading: boolean;
  success: string | null;
  data: T | null;
  submit: (payload: P) => Promise<void>;
}

export function useMutation<T, P extends Params = Params>(url: string): UseMutationReturn<T, P> {
  const [loading, setLoading] = useState(false);
  const [success, setSuccess] = useState<string | null>(null);
  const [data, setData] = useState<T | null>(null);

  const submit = async (payload: P) => {
    setLoading(true);
    setSuccess(null);
    setData(null);

    try {
      const response = await api.post<ApiResponse<T>>(url, payload);

      if (response.data.status === "success") {
        setData(response.data.data);
        setSuccess(response.data.message || "Operación exitosa");
        toast.success(response.data.message || "Operación exitosa");
      }
    } catch (e) {
      const axiosErr = e as AxiosError<ApiResponse<unknown>>;
      const apiErr = axiosErr.response?.data;

      if (apiErr && apiErr.status === "error") {
        const err =
          typeof apiErr.error === "string"
            ? { general: [apiErr.error] }
            : (apiErr.error as FieldErrors);

        if (err && err.details) {
          toast.error(err.details || "Ocurrió un error");
        }

        if (
          err &&
          err.details &&
          Object.values(err.details).some(
            (arr) => Array.isArray(arr) && arr.length > 0
          )
        ) {
          Object.values(err.details).forEach((messages) => {
            if (Array.isArray(messages)) {
              messages.forEach((msg) => toast.error(msg));
            }
          });
        }
      } else {
        toast.error("Ocurrió un error inesperado.");
      }
    } finally {
      setLoading(false);
    }
  };

  return { submit, loading, success, data };
}
