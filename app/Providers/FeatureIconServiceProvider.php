<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\FeatureIconManager;
use App\Facades\FeatureIcons;

class FeatureIconServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->singleton('featureIcons', function($app) {
			return new FeatureIconManager([
				'root' => config('assets.images.icons.rootUrl')
			]);
		});
	}

	public function boot()
	{
		FeatureIcons::property('icon-backup-camera.png', 'retains_backup_camera');
		FeatureIcons::property('icon-direct-connection.png', 'direct_connect');
		FeatureIcons::property('icon-usb-updatable.png', 'usb_updatable');
		FeatureIcons::property('icon-micro-usb-updatable.png', 'micro_b_usb_updatable');
		FeatureIcons::property('icon-hdmi-hd-input.png', 'hdmi_hidef_input');
		FeatureIcons::property('icon-made-in-usa.png', 'made_in_usa');
		FeatureIcons::property('icon-built-in-swc.png', 'built_in_swc');
	}
}