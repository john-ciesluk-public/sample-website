<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Facades\Client;

class ClientConfigServiceProvider extends ServiceProvider
{
	public function register()
	{
		Client::publish('productImageRoot', config('assets.images.products.rootUrl'));
		Client::publish('vfgApiUrl', config('vfg.base_uri'));
		Client::publish('debug', env('APP_DEBUG'));
	}
}