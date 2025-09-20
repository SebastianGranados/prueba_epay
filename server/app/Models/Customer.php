<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Customer extends Model
{
  use HasUuids;
  
  protected $fillable = [
    'document', 
    'name', 
    'email', 
    'phone',
  ];

  public function wallet()
  {
    return $this->hasOne(Wallet::class);
  }
  
  public function paymentSessions()
  {
    return $this->hasMany(PaymentSession::class);
  }
}
