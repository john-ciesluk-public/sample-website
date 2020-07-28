<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
	public function login(Request $request)
	{	
		foreach (config('dashboard.identities') as $identity) {
			// This is not a properly configured identity!
			if (empty($identity['username']) || empty($identity['password'])) {
				continue;
			}

			if ($request->input('username') === $identity['username'] && $request->input('password') === $identity['password']) {
				$payload = JWTFactory::make(['username' => $identity['username']]);
				$token = JWTAuth::encode($payload);

				return Response::json([
					'status' => 'success',
					'token' => $token->get(),
				]);
			}
		}

		return Response::json([ 'status' => 'failure' ], 403);
	}

	public function logout(Request $request)
	{
		try {
			$token = JWTAuth::parseToken();
			$token->invalidate();

			return Response::json([
				'status' => 'success'
			]);
		} catch (JWTException $e) {
			return Response::json([
				'status' => 'failure'
			], 403);
		}
	}
}