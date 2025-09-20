<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

use App\Services\CustomerService;
use Exception;

class CustomerController extends Controller
{

  protected $customerService;

  public function __construct(CustomerService $customerService)
  {
    $this->customerService = $customerService;
  }

  /**
   * Registrar un nuevo cliente
   */
  public function register(Request $request): JsonResponse
  {
    $validator = Validator::make($request->all(), [
      'document' => 'required|string|min:6|max:20',
      'name' => 'required|string|min:2|max:100',
      'email' => 'required|email|max:100',
      'phone' => 'nullable|string|max:20'
    ], [
      'document.required' => 'El documento es obligatorio',
      'document.min' => 'El documento debe tener al menos 6 caracteres',
      'name.required' => 'El nombre es obligatorio',
      'name.min' => 'El nombre debe tener al menos 2 caracteres',
      'email.required' => 'El email es obligatorio',
      'email.email' => 'El email debe tener un formato válido',
      'phone.max' => 'El teléfono no puede tener más de 20 caracteres'
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

      $customer = $this->customerService->createCustomer($request->all());

      return $this->apiResponse(
        201,
        $customer,
        'Cliente creado exitosamente'
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
