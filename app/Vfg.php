<?php

/**
 * Metra Vehicle Fit Guide Model
 *
 * @copyright Copyright (c) 2017, Metra Electronics Corp.
 */

namespace App;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class Vfg {
	protected $_guzzle = null;
	
	public function __construct(\Illuminate\Cache\Repository $cache)
	{
		$this->cache = $cache;
		
		// Create a new Guzzle instance
		$apiUrl = rtrim(config('vfg.base_uri'), '/') . '/';
		$this->_guzzle = new \GuzzleHttp\Client(['base_uri' => $apiUrl]);
	}

	/**
	 * Retrieves the list of compatible parts corresponding to the given
	 * VFG parameters from the cache if possible, or the VFG server otherwise.
	 * @param Array $parameters VFG parameters to search for
	 * @return Array List of compatible part numbers
	 */
	public function getProducts($parameters=[]) {
		$cacheKey = 'vfg:' . serialize($parameters);

		return $this->cache->remember($cacheKey, 1440, function() use ($parameters) {
			return $this->retrieveProducts($parameters);
		});
	}

	/**
	 * Sends a curl request to the vfg server, and formats the results to
	 * an array of product numbers for rendering on this site.
	 * @param Array $parameters VFG parameters to search for
	 * @return Array List of compatible part numbers returned from the server
	 */
	private function retrieveProducts($parameters) {
		
		$trimOptions = '';
		
		if (is_array($parameters['TrimOption'])) {		
			foreach($parameters['TrimOption'] as $to) {
				$trimOptions .= "&TrimOption[]=$to";
			}
		}
		$url = "parts/{$parameters['Year']}/{$parameters['Make']}/{$parameters['Model']}/${parameters['Submodel']}?returnType=JSON" . (!empty($trimOptions) ? "$trimOptions" : '');
		
		$response = $this->_guzzle->request('GET', $url);
		
		if ($response->getStatusCode() === 200) {
			return $this->_toArray(json_decode($response->getBody()));	
		} else {
			throw new GuzzleException($response->getResponsePhrase());
		}
	}
	
	/**
	 * Sends a curl request to the VFG server, to get a list of applicatoins for
	 * a given product id.
	 */
	public function getApplications($partNumber) {		
		$url = "applications/{$partNumber}";
		
		$response = $this->_guzzle->request('GET', $url); 
		
		if ($response->getStatusCode() === 200) {
			return $this->_toArray(json_decode($response->getBody()));
		} else {
			throw new GuzzleException($response->getResponsePhrase());
		}
	}
		
	
	/**
	 * Converts the array of objects returned from the VFG cURL to an array of product numbers
	 * @param Array $objects Array of objects
	 * @return Array Array of product numers
	 */
	private function _toArray($object) {
		/*if (is_array($object)) {
			return array_map(function($o) { return $o->id; }, $object);	
		} else {
			return [$object];
		}*/
		return $object;
	}
}
