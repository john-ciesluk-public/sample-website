<?php

namespace App\Exceptions;

class PropertyNotFoundException extends \Exception {
	public $propertyName;

	public function __construct($propertyName) {
		parent::__construct("Property $propertyName does not exist");
		$this->propertyName = $propertyName;
	}
}