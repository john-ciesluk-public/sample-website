<?php

namespace App\Http\Middleware;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;



class Cors
{
        public function handle($request, $next, ...$origins)
        {
                $response = $next($request);

        if (!$response->headers->has('Access-Control-Allow-Origin')) {
                $origin = $request->headers->get('Origin');
                Log::info("HTTP origin: $origin");

                if (in_array($origin, $origins, true)) {
                                $response->headers->set('Access-Control-Allow-Origin', $origin);
                }
        }

        return $response;
        }
}
