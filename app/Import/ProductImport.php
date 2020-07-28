<?php

namespace App\Import;

use App\Exceptions\PropertyNotFoundException;
use App\Import\Import;
use App\Product;
use App\Brand;
use App\Category;
use App\ProductImage;
use App\ProductDocument;

class ProductImport extends Import
{
	private $update;
	private $create;

	public function __construct($options)
	{
        parent::__construct($options);
        
		$this->update = $options['update'] ?? array();

		if (is_string($this->update)) {
			$this->update = [$this->update];
		}

		$this->create = $options['create'] ?? false;
		$this->verbose = $options['verbose'] ?? false;
	}

	public function all($products)
	{
		$i = 0;
		foreach ($products as $product)
		{
			if (++$i % 1000 == 0)
				$this->info($i . ' done');

			$this->one($product);
		}
	}

	public function one($data)
	{
		$product = Product::wherePartNumber($data->partNumber)->first();

		if ($product) {
			$this->verbose && $this->info('Updating existing product ' . $data->partNumber);
			$new = false;
		} else if ($this->create) {
			$this->verbose && $this->info('Creating new product ' . $data->partNumber);
			$product = new Product();
			$product->part_number = $data->partNumber;
			$new = true;
		} else {
			$this->verbose && $this->warn('Skipping product ' . $data->partNumber);
			return;
		}

		if (($new || $this->updates('title')) && property_exists($data, 'title'))
			$product->title = $data->title;

		if (($new || $this->updates('description')) && property_exists($data, 'description'))
			$product->description = $data->description;

		if (($new || $this->updates('shortDescription')) && property_exists($data, 'shortDescription'))
			$product->short_description = $data->shortDescription;

		if (($new || $this->updates('applications')) && property_exists($data, 'applications'))
			$product->applications = $data->applications;

		if (($new || $this->updates('brand')) && property_exists($data, 'brand')) {
			$brand = Brand::whereCode($data->brand)->first();

			if ($brand)
				$product->brand()->associate($brand);
		}

		if (($new || $this->updates('sortOrder')) && property_exists($data, 'sortOrder')) {
			$product->sort_order = $data->sortOrder;
		}

		$product->save();

		if (($new || $this->updates('categories')) && property_exists($data, 'categories')) {
			$product->syncCategories($data->categories);
		}

		if (($new || $this->updates('images')) && property_exists($data, 'images')) {
			$product->syncImages($data->images);
		}

		if (($new || $this->updates('documents')) && property_exists($data, 'documents')) {
			$product->syncDocuments($data->documents);
		}

		if (($new || $this->updates('properties')) && property_exists($data, 'properties')) {
			foreach ($data->properties as $code => $value) {
				try {
					$product->setProperty($code, $value);	
				} catch (PropertyNotFoundException $e) {
					$this->verbose && $this->warn("Property {$e->propertyName} not found");
				}
			}
		}

		if (($new || $this->updates('requiredProducts')) && property_exists($data, 'requiredProducts')) {
			$partNumbers = array_pluck($data->requiredProducts, 'partNumber');
			$requiredProducts = Product::whereIn('part_number',	$partNumbers)->get();

			$product->requiredProducts()->sync($requiredProducts->pluck('id')->toArray());
		}

		if (($new || $this->updates('relatedProducts')) && property_exists($data, 'relatedProducts')) {
			$partNumbers = array_pluck($data->relatedProducts, 'partNumber');
			$relatedProducts = Product::whereIn('part_number', $partNumbers)->get();

			$product->relatedProducts()->sync($relatedProducts->pluck('id')->toArray());
		}

		return Product::find($product->id);
	}

    private function updates($name)
    {
    	return in_array($name, $this->update, true)
    		|| in_array('all', $this->update, true);
    }
}
