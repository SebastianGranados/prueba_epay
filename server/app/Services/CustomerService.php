<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Wallet;
use Illuminate\Validation\ValidationException;
use Exception;

class CustomerService
{
  /**
   * Crear un nuevo cliente y su billetera inicial
   */
  public function createCustomer(array $data): Customer
  {
    try {
      $this->validateCustomerData($data);

      $existingCustomer = Customer::where('document', $data['document'])
        ->orWhere('email', $data['email'])
        ->first();

      if ($existingCustomer) {
        throw new Exception('El cliente ya existe con este documento o email');
      }

      $customer = Customer::create([
        'document' => $data['document'],
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'] ?? null,
      ]);

      $this->createInitialWallet($customer);

      return $customer->load('wallet');

    } catch (Exception $e) {
      throw new Exception('Error al crear el cliente: ' . $e->getMessage());
    }
  }

  /**
   * Validar datos del cliente
   */
  private function validateCustomerData(array $data): void
  {
    $required = ['document', 'name', 'email'];
    
    foreach ($required as $field) {
      if (empty($data[$field])) {
        throw new ValidationException("El campo {$field} es obligatorio");
      }
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
      throw new ValidationException('Formato de email inválido');
    }

    if (!is_numeric($data['document']) || strlen($data['document']) < 6) {
      throw new ValidationException('El documento debe ser numérico y tener al menos 6 dígitos');
    }
  }

  /**
   * Crear una billetera inicial para el cliente
   */
  private function createInitialWallet(Customer $customer): Wallet
  {
    return Wallet::create([
      'customer_id' => $customer->id,
      'balance' => 0,
    ]);
  }
}