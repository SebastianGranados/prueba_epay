<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
  /**
   * Metodo para estandarizar las respuestas de la API
   */
  protected function apiResponse($statusCode = 200, $data = null, $message = '', $details = null, $isError = false): JsonResponse
  {
    if ($isError && !$this->isValidHttpCode($statusCode)) {
      $statusCode = 400;
    }

    $response = [
      'status' => $isError ? 'error' : 'success',
      'message' => $message,
      'data' => $isError ? null : $data,
      'error' => $isError ? [
        'code' => 'ERROR_' . $statusCode,
        'details' => $details
      ] : null
    ];

    return response()->json($response, $statusCode);
  }

  /**
   * Valida si un código es un código HTTP válido
   */
  private function isValidHttpCode($code): bool
  {
    return is_int($code) && $code >= 100 && $code <= 599;
  }
}
