<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Http\Traits\ApiResponseTrait;

class Controller extends BaseController
{
  use ApiResponseTrait;
}
