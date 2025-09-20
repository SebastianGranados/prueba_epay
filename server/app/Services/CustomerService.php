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
      throw new Exception('Error creating customer: ' . $e->getMessage());
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
        throw new ValidationException("The {$field} field is required");
      }
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
      throw new ValidationException('Invalid email format');
    }

    if (!is_numeric($data['document']) || strlen($data['document']) < 6) {
      throw new ValidationException('Document must be numeric and at least 6 digits');
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