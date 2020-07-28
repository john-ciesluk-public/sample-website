<?php

namespace App\Http\Middleware;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Http\JsonResponse;

class DashboardAuth
{
	public function handle($request, $next, $claim)
	{
		$ips = config('dashboard.ip');
		if (!is_array($ips))
			$ips = [$ips];

		if (!in_array($request->ip(), $ips, true)) {
			return $this->failure();
		}

		try {
			$payload = JWTAuth::parseToken()->getPayload();

			if ($username = $payload->get('username')) {
				$identities = config('dashboard.identities');
				$identity = collect($identities)->first(function($identity) use ($username) {
					return $identity['username'] === $username;
				});

				if ($identity) {
					$claims = $identity['claims'];

					if (isset($claims[$claim]) && $claims[$claim] === true) {
						return $next($request);
					}
				}
			}

			return $this->failure('You are not authorized to perform that action');
		} catch (JWTException $e) {
			return $this->failure('Error parsing token');
		} catch (TokenInvalidException $e) {
			return $this->failure('Invalid token');
		}
	}

	private function failure($message = 'Authentication failed')
	{
		return new JsonResponse([
			'status' => 'failure',
			'message' => $message,
		], 403);
	}
}