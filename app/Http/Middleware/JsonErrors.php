<?php

namespace App\Http\Middleware;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class JsonErrors
{
	public function handle($request, $next)
	{
		$response = $next($request);

		if (isset($response->exception)) {
			Log::error($response->exception);

			$data = [
				'status' => 'failure',
			];

			if (env('APP_DEBUG')) {
				$data = array_merge($data, [
					'message' => $response->exception->getMessage(),
					'stackTrace' => $response->exception->getTraceAsString(),
				]);
			}

			return new JsonResponse($data, $response->status());
		} else {
			return $response;
		}
	}
}