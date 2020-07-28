<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Netcarver\Textile\Parser;

class TextileServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->singleton('textile', function($app) {
			return new Parser;
		});
	}
}