<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Facades\JWTAuth;

class CreateToken extends Command
{
    protected $signature = 'token:create {username}';
    protected $description = 'Create a JWT for the given identity.';

    public function handle()
    {
        $username = $this->argument('username');

        $identities = config('dashboard.identities');
        $identity = collect($identities)->first(function($identity) use ($username) {
            return $identity['username'] === $username;
        });

        if ($identity) {
            $payload = JWTFactory::make(['username' => $identity['username']]);
            $token = JWTAuth::encode($payload);

            $this->info($token);
        }
    }
}