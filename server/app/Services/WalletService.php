<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Wallet;
use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WalletService
{
  /**
   * Obtener el balance de la billetera de un cliente por su documento y teléfono
   */
  public function getWalletBalance(string $document, string $phone): float
  {
    $customer = Customer::where('document', $document)
      ->where('phone', $phone)
      ->first();

    if (!$customer) {
      throw new NotFoundHttpException('El cliente no existe con este documento o teléfono');
    }

    $wallet = $customer->wallet;

    if (!$wallet || !isset($wallet->balance)) {
      throw new NotFoundHttpException('La billetera no fue encontrada para el cliente');
    }

    return $wallet->balance;
  }

  /**
   * Recargar la billetera de un cliente
   */
  public function rechargeWallet(array $data): Wallet
  {
    $customer = Customer::where('document', $data['document'])
      ->where('phone', $data['phone'])
      ->first();

    if (!$customer) {
      throw new NotFoundHttpException('El cliente no existe con este documento y teléfono');
    }

    $wallet = $customer->wallet;

    if (!$wallet) {
      throw new NotFoundHttpException('La billetera no fue encontrada para el cliente');
    }

    $wallet->balance += $data['value'];
    $wallet->save();

    return $wallet;
  }
}
