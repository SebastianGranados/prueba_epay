<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Transaction extends Model
{
  use HasUuids;
  public $timestamps = false;
  protected $fillable = [
    'wallet_id', 
    'type', 
    'amount',
    'session_id',
    'created_at',
  ];
  
  protected $casts = ['created_at' => 'datetime'];

  public function wallet()
  {
    return $this->belongsTo(Wallet::class);
  }

  public function paymentSession()
  {
    return $this->belongsTo(PaymentSession::class, 'session_id');
  }
}
