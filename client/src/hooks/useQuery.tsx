import { useCallback, useEffect, useRef, useState } from "react";
import { toast } from "react-toastify";

import api from "../axios/config";

import type { AxiosError } from "axios";
import type { ApiResponse } from "../axios/types/request.types";

type Params = Record<string, unknown>;

type FieldErrors = Record<string, string[]>;

interface UseQueryOptions<P extends Params> {
  params?: P;
  immediate?: boolean;
  notifyError?: boolean;
}

export function useQuery<T, P extends Params = Params>(
  url: string,
  options?: UseQueryOptions<P>
) {
  const [loading, setLoading] = useState(false);
  const [data, setData] = useState<T | null>(null);

  const defaultImmediate = options?.immediate ?? true;
  const initialParams = useRef<P | undefined>(options?.params);

  const refetch = useCallback(
    async (overrides?: P) => {
      setLoading(true);

      try {
        const response = await api.get<ApiResponse<T>>(url, {
          params: (overrides ?? initialParams.current) as P | undefined,
        });

        if (response.data.status === "success") {
          setData(response.data.data);
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
    },
    [url]
  );

  useEffect(() => {
    if (defaultImmediate) {
      void refetch();
    }
  }, [url, defaultImmediate, refetch]);

  return { loading, data, refetch };
}
