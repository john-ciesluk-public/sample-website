<?php

namespace App;

class FeatureIconManager
{
	private $root;
	private $icons = array();

	public function __construct($options)
	{
		$this->root = $options['root'];
	}

	public function use($path, $predicate)
	{
		$this->icons[] = (object) [
			'path' => $this->root . '/' . $path,
			'predicate' => $predicate,
		];
	}

	public function property($path, $propertyCode)
	{
		$this->use($path, function($product) use ($propertyCode) {
			return $product->property($propertyCode);
		});
	}

	public function get($product)
	{
		$used = array_filter($this->icons, function($icon) use ($product) {
			$predicate = $icon->predicate;
			return $predicate($product);
		});

		return $used;
	}
}