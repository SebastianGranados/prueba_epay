<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PaymentSession extends Model
{
  use HasUuids;

  protected $fillable = ['customer_id',
   'amount',
   'otp',
   'status',
   'expires_at',];

  protected $casts = [
    'expires_at' => 'datetime', 
  ];

  public function customer()
  {
    return $this->belongsTo(Customer::class);
  }
}
