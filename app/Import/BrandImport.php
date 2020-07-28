<?php

namespace App\Import;

use App\Import\Import;
use App\Brand;

class BrandImport extends Import
{
    private $create;

    public function __construct($options)
    {
        parent::__construct($options);

        $this->create = $options['create'] ?? false;
        $this->verbose = $options['verbose'] ?? false;
    }

	public function all($brands)
	{
        $i = 0;
        foreach ($brands as $data) {
            if (++$i % 1000 == 0)
                $this->info($i . ' done');

            $this->importBrand($data);
        }
	}

    private function importBrand($data)
    {
        $brand = Brand::whereCode($data->code)->first();

        if ($brand) {
            $this->verbose && $this->info('Updating brand ' . $data->code);
        } else if ($this->create) {
            $this->verbose && $this->info('Creating new brand ' . $data->code);
            $brand = new Brand();
        } else {
            $this->verbose && $this->warn('Skipping brand ' . $data->code);
            return;
        }

        $brand->code = $data->code;
        $brand->name = $data->name;

        $brand->save();

        return $brand;
    }
}