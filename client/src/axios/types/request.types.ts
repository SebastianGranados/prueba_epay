export type ApiError = {
  status: 'error';
  message: string;
  error?: Record<string, string[] | string> | string;
};

export type ApiSuccess<T> = {
  status: 'success';
  message: string;
  data: T;
};

export type ApiResponse<T> = ApiSuccess<T> | ApiError;

export type ValidationErrorResponse = {
  code: string;
  details: Record<string, string[]>;
  message?: string;
};
