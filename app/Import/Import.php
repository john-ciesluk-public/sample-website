<?php

namespace App\Import;

class Import
{
	private $output;

	public function __construct($options)
	{
		if (array_key_exists('output', $options)) {
			$this->output = $options['output'];
		}
	}

	protected function info($text)
	{
		if ($this->output)
			$this->output->info($text);
	}

	protected function warn($text)
	{
		if ($this->output)
			$this->output->warn($text);
	}

	protected function error($text)
	{
		if ($this->output)
			$this->output->error($text);
		else
			throw new \Exception($text);
	}
}