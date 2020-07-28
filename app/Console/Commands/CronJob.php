<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CronJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CronJob:cronjob';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Powersports data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * This will import/update the brands, categories, products, product images, and product documents for Powersports
     *
     * @return mixed
     */
    public function handle()
    {
        //https://metra-internal.s3.amazonaws.com/productdata.json

        //Grab the given Brand
        $this->importBrands();

        //Import the categories of the brand; Import the subcategories of each category, with the parent category_id
        $this->importCategories();

        //Import the products of each subcategory.  Update images and documents associated with each part
        $this->importProducts();
    }

    /**
     * Import or update powersports brands
     * 
     */
    private function importBrands()
    {
    
        \DB::table('brands')->update(['name' => 'bob']);
        $this->info('Brand updated successfully');
    
    }

    /**
     * Import or update powersports categories
     *
     */
    private function importCategories()
    {

    }
    
    /**
     * Import or update powersports products, images, and documents
     *
     */
    private function importProducts()
    {

    }
}
