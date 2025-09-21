<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Wallet;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CustomerService
{
  /**
   * Crear un nuevo cliente y su billetera inicial
   */
  public function createCustomer(array $data): Customer
  {
    $this->validateExistingCustomerData($data);

    $customer = Customer::create([
    'document' => $data['document'],
    'name' => $data['name'],
    'email' => $data['email'],
    'phone' => $data['phone'] ?? null,
    ]);

    $this->createInitialWallet($customer);

    return $customer->load('wallet');
  }

  /**
   * Validar datos del cliente
   */
  private function validateExistingCustomerData(array $data): void
  {
    $existingCustomer = Customer::where('document', $data['document'])
      ->orWhere('email', $data['email'])
      ->orWhere('phone', $data['phone'])
      ->first();

    if ($existingCustomer) {
      throw new BadRequestHttpException('Un cliente ya existe con este documento, email o teléfono');
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