<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
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

    if ($validator->fails()) {
      return $this->apiResponse(
        422,
        null,
        'Validation failed',
        $validator->errors(),
        true
      );
    }

    try {
      $customer = $this->customerService->createCustomer($request->all());

      return $this->apiResponse(
        201,
        $customer,
        'Customer created successfully'
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
}
