<?php

namespace App\Enums;

enum PaymentStatus: string
{
  case STATUS_PENDING = 'PENDING';
  case STATUS_CONFIRMED = 'CONFIRMED';
  case STATUS_EXPIRED = 'EXPIRED';
}
