<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CatalogRequest extends Facade
{
	protected static function getFacadeAccessor() { return 'App\Http\Requests\CatalogRequest'; }
}