<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\PaymentSession;

use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

use Exception;
use Carbon\Carbon;

class PaymentService
{
  /**
   * Solicitar un pago, generar OTP y enviarlo por correo.
   */
  public function requestPayment(array $data): PaymentSession
  {
    $this->validateRequestData($data);

    $customer = Customer::where('document', $data['document'])
      ->where('phone', $data['phone'])
      ->first();

    if (!$customer) {
      throw new Exception('El cliente no fue encontrado');
    }

    if ($customer->wallet->balance < $data['value']) {
      throw new Exception('Saldo insuficiente para realizar el pago');
    }

    $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

    $paymentSession = PaymentSession::create([
      'customer_id' => $customer->id,
      'amount' => $data['value'],
      'otp' => $otp,
      'expires_at' => Carbon::now()->addMinutes(5),
    ]);

    Mail::send('otp', ['otp' => $otp, 'customerEmail' => $customer->email], function($message) use ($customer) {
        $message->to($customer->email, $customer->name)
                ->subject('Your One-Time Password (OTP)');
    });

    return $paymentSession;
  }

  /**
   * Validar datos de la solicitud de pago
   */
  private function validateRequestData(array $data): void
  {
    $required = ['document', 'value'];
    foreach ($required as $field) {
      if (empty($data[$field])) {
        throw new ValidationException("El campo {$field} es obligatorio");
      }
    }

    if (!is_numeric($data['value']) || $data['value'] <= 0) {
      throw new ValidationException('El valor debe ser un número positivo');
    }
  }

  /**
   * Confirmar un pago, validar OTP y procesar la transacción.
   */
  public function confirmPayment(array $data): \App\Models\Transaction
  {
    $paymentSession = PaymentSession::find($data['session_id']);


    if (!$paymentSession) {
      throw new Exception('La sesión de pago no fue encontrada', 404);
    }

    if ($paymentSession->otp !== $data['otp']) {
      throw new Exception('El código OTP no es válido', 401);
    }

    if ($paymentSession->status !== 'PENDING') {
      throw new Exception('La sesión de pago ya ha sido procesada o ha expirado', 409);
    }

 
    if (Carbon::now()->isAfter($paymentSession->expires_at)) {
      $paymentSession->status = 'EXPIRED';
      $paymentSession->save();
      throw new Exception('El código OTP ha expirado', 410);
    }


    $customer = $paymentSession->customer;
    $wallet = $customer->wallet;

    if ($wallet->balance < $paymentSession->amount) {
      throw new Exception('Saldo insuficiente para completar el pago', 400);
    }

    $paymentSession->status = 'CONFIRMED';
    $paymentSession->save();

    $wallet->balance -= $paymentSession->amount;
    $wallet->save();

    $transaction = \App\Models\Transaction::create([
      'wallet_id' => $wallet->id,
      'amount' => $paymentSession->amount,
      'type' => 'PAYMENT',
    ]);

    return $transaction;
  }
}
