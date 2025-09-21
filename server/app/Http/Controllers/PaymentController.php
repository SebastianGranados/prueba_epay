<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Exception;

class PaymentController extends Controller
{
  protected $paymentService;

  public function __construct(PaymentService $paymentService)
  {
    $this->paymentService = $paymentService;
  }

  /**
   * Solicitar un pago
   */
  public function requestPayment(Request $request): JsonResponse
  {
    $validator = Validator::make($request->all(), [
      'document' => 'required|string|min:6|max:20',
      'phone' => 'required|string|max:20',
      'value' => 'required|numeric|min:1'
    ], [
      'document.required' => 'El documento es obligatorio',
      'document.min' => 'El documento debe tener al menos 6 caracteres',
      'phone.required' => 'El teléfono es obligatorio',
      'phone.max' => 'El teléfono no puede tener más de 20 caracteres',
      'value.required' => 'El valor es obligatorio',
      'value.numeric' => 'El valor debe ser numérico',
      'value.min' => 'El valor debe ser al menos 1'
    ]);

    if ($validator->fails()) {
      return $this->apiResponse(
        422,
        null,
        'Validación fallida',
        $validator->errors(),
        true
      );
    }

    try {
      $paymentSession = $this->paymentService->requestPayment($request->all());

      return $this->apiResponse(
        200,
        ['session_id' => $paymentSession->id],
        'Codigo enviado exitosamente'
      );
    } catch (Exception $e) {
      return $this->apiResponse(
        $e->getCode(),
        null,
        $e->getMessage(),
        $e->getMessage(),
        true
      );
    }
  }

  /**
   * Confirmar un pago
   */
  public function confirmPayment(Request $request): JsonResponse
  {
    $validator = Validator::make($request->all(), [
      'session_id' => 'required|string|uuid',
      'otp' => 'required|string|digits:6'
    ], [
      'session_id.required' => 'El ID de sesión es obligatorio',
      'session_id.uuid' => 'El ID de sesión debe ser un UUID válido',
      'otp.required' => 'El código OTP es obligatorio',
      'otp.digits' => 'El código OTP debe tener 6 dígitos'
    ]);

    try {
      if ($validator->fails()) {
        return $this->apiResponse(
          422,
          null,
          'Validación fallida',
          $validator->errors(),
          true
        );
      }

      $transaction = $this->paymentService->confirmPayment($request->all());

      return $this->apiResponse(
        200,
        ['transaction_id' => $transaction->id],
        'Pago confirmado exitosamente'
      );
    } catch (Exception $e) {
      return $this->apiResponse(
        $e->getStatusCode() ?? 400,
        null,
        $e->getMessage(),
        $e->getMessage(),
        true
      );
    }
  }
}
