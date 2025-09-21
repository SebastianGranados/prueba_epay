<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
  /**
   * Intercepta las solicitudes entrantes y agrega los encabezados CORS necesarios.
   */
  public function handle($request, Closure $next)
  {
    $allowedOrigins = [
      'http://localhost:3000',
      'http://localhost:5173',
      env('CORS_ORIGIN', 'http://localhost:3000')
    ];

    $origin = $request->header('Origin');
    $allowOrigin = in_array($origin, $allowedOrigins) ? $origin : $allowedOrigins[0];

    $headers = [
      'Access-Control-Allow-Origin' => $allowOrigin,
      'Access-Control-Allow-Methods' => 'GET, POST, PUT, PATCH, DELETE, OPTIONS',
      'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With, Accept, Origin',
      'Access-Control-Allow-Credentials' => 'true',
      'Access-Control-Max-Age' => '86400',
    ];

    if ($request->isMethod('OPTIONS')) {
      return response('', 204, $headers);
    }

    $response = $next($request);

    foreach ($headers as $key => $value) {
      $response->header($key, $value);
    }

    return $response;
  }
}
