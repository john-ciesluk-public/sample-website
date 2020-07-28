<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Import\BrandImport;
use Symfony\Component\Console\Output\OutputInterface;

class ImportBrands extends Command
{
    protected $signature = 'import:brands {filename} {--create}';
    protected $description = 'Import brand data from a data source.';

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

        $import = new BrandImport([
            'output' => $this,
            'create' => $this->option('create'),
            'verbose' => $this->getOutput()->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE,
        ]);

        $import->all($data->brands);
    }
}