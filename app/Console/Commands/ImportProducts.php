<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Import\ProductImport;
use Symfony\Component\Console\Output\OutputInterface;

class ImportProducts extends Command
{
	protected $signature = 'import:products {filename} {--update=*} {--create}';
    protected $description = 'Import product data from a data source.';

    public function handle()
    {
    	$filename = $this->argument('filename');

    	$contents = file_get_contents($filename);
    	if (!$contents) {
    		$this->error('Could not read file ' . $filename);
    	}

    	$data = json_decode($contents);
    	if (!$data) {
    		$this->error('Error parsing JSON from file ' . $filename);
    	}

		$import = new ProductImport([
            'output' => $this,
			'update' => $this->option('update'),
			'create' => $this->option('create'),
            'verbose' => $this->getOutput()->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE,
		]);

		$import->all($data->products);
    }
}
