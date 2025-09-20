<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Wallet;
use Exception;

class WalletService
{
  /**
   * Obtener el balance de la billetera de un cliente por su documento y teléfono
   */
  public function getWalletBalance(string $document, string $phone): float
  {
    try {
      $customer = Customer::where('document', $document)
        ->where('phone', $phone)
        ->first();

      if (!$customer) {
        throw new Exception('El cliente no existe con este documento y teléfono');
      }

      $wallet = $customer->wallet;

      if (!$wallet) {
        throw new Exception('La billetera no fue encontrada para el cliente');
      }

      return $wallet->balance;
    } catch (Exception $e) {
      throw new Exception('Error al obtener el balance de la billetera: ' . $e->getMessage());
    }
  }

  /**
   * Recargar la billetera de un cliente
   */
  public function rechargeWallet(array $data): Wallet
  {
    try {
      $this->validateRechargeData($data);

      $customer = Customer::where('document', $data['document'])
        ->where('phone', $data['phone'])
        ->first();

      if (!$customer) {
        throw new Exception('El cliente no existe con este documento y teléfono');
      }

      $wallet = $customer->wallet;

      if (!$wallet) {
        throw new Exception('La billetera no fue encontrada para el cliente');
      }

      $wallet->balance += $data['value'];
      $wallet->save();

      return $wallet;
    } catch (Exception $e) {
      throw new Exception('Error al recargar la billetera: ' . $e->getMessage());
    }
  }

  private function validateRechargeData(array $data): void
  {
    $required = ['document', 'phone', 'value'];

    foreach ($required as $field) {
      if (empty($data[$field])) {
        throw new Exception("El campo {$field} es obligatorio");
      }
    }

    if (!is_numeric($data['value']) || $data['value'] <= 0) {
      throw new Exception('El valor de recarga debe ser un número positivo');
    }
  }
}
