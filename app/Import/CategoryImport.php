<?php

namespace App\Import;

use App\Import\Import;
use App\Category;

class CategoryImport extends Import
{
    private $create;

    public function __construct($options)
    {
        parent::__construct($options);

        $this->create = $options['create'] ?? false;
        $this->verbose = $options['verbose'] ?? false;
    }

	public function all($categories)
	{
        $i = 0;
        foreach ($categories as $data) {
            if (++$i % 1000 == 0)
                $this->info($i . ' done');

            $this->importCategory($data);
        }
	}

    private function importCategory($data)
    {
        $category = Category::whereCode($data->code)->first();

        if ($category) {
            $this->verbose && $this->info('Updating category ' . $data->code);
        } else if ($this->create) {
            $this->verbose && $this->info('Creating new category ' . $data->code);
            $category = new Category();
        } else {
            $this->verbose && $this->warn('Skipping category ' . $data->code);
            return;
        }

        $category->code = $data->code;
        $category->name = $data->name;

        $category->save();

        if (property_exists($data, 'children')) {
            foreach ($data->children as $childData) {
                $child = $this->importCategory($childData);
                $child->parent_id = $category->id;
                $child->save();
            }
        }

        return $category;
    }
}