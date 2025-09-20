<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Wallet extends Model
{
  use HasUuids;
  protected $fillable = [
    'customer_id',
    'balance'
  ];

  public function customer()
  {
    return $this->belongsTo(Customer::class);
  }

  public function transactions()
  {
    return $this->hasMany(Transaction::class);
  }
}
