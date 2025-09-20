<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

use App\Services\WalletService;
use Exception;

class WalletController extends Controller
{
  protected $walletService;

  public function __construct(WalletService $walletService)
  {
    $this->walletService = $walletService;
  }

  /**
   * Obtener el balance de la billetera
   */
  public function balance(Request $request): JsonResponse
  {
    $validator = Validator::make($request->query(), [
      'document' => 'required|string|min:6|max:20',
      'phone' => 'required|string|max:20'
    ], [
      'document.required' => 'El documento es obligatorio',
      'document.min' => 'El documento debe tener al menos 6 caracteres',
      'phone.required' => 'El teléfono es obligatorio',
      'phone.max' => 'El teléfono no puede tener más de 20 caracteres'
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
      $balance = $this->walletService->getWalletBalance(
        $request->query('document'),
        $request->query('phone')
      );

      return $this->apiResponse(
        200,
        ['balance' => $balance],
        'Balance obtenido exitosamente'
      );
    } catch (Exception $e) {
      return $this->apiResponse(
        400,
        null,
        'Error al obtener el balance',
        $e->getMessage(),
        true
      );
    }
  }

  /**
   * Recargar la billetera
   */
  public function recharge(Request $request): JsonResponse
  {
    $validator = Validator::make($request->all(), [
      'document' => 'required|string|min:6|max:20',
      'phone'    => 'required|string|max:20',
      'value'    => 'required|numeric|min:1'
    ], [
      'document.required' => 'El documento es obligatorio',
      'document.min' => 'El documento debe tener al menos 6 caracteres',
      'phone.required' => 'El teléfono es obligatorio',
      'phone.max' => 'El teléfono no puede tener más de 20 caracteres',
      'value.required' => 'El monto es obligatorio',
      'value.min' => 'El monto debe ser al menos 1'
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
      $wallet = $this->walletService->rechargeWallet($request->all());

      return $this->apiResponse(
        200,
        $wallet,
        'Recarga realizada exitosamente'
      );
    } catch (Exception $e) {
      return $this->apiResponse(
        400,
        null,
        'Error al realizar la recarga',
        $e->getMessage(),
        true
      );
    }
  }
}
