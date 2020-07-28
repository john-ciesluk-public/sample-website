<?php

namespace App;

class ClientConfig
{
	private $variables = array();

	public function publish($key, $value = null)
	{
		if (is_array($key)) {
			foreach ($key as $k => $v) {
				$this->publish($k, $v);
			}
		} else {
			$this->variables[$key] = $value;
		}

		return $this;
	}

	public function provide($storeName = '__LARAVEL_CONFIG__')
	{
		$storeNameJson = json_encode($storeName);
		return "<script>window[$storeNameJson] = " . json_encode((object) $this->variables) . '</script>';
	}
}