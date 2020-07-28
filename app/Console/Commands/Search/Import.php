<?php

namespace App\Console\Commands\Search;

use Illuminate\Console\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Cviebrock\LaravelElasticsearch\Facade as Elasticsearch;
use App\Product;

class Import extends Command
{
    protected $signature = 'search:import';
    protected $description = 'Build Elasticsearch index';

    public function handle()
    {
        $batches = Product::all()->chunk(100);
        $doneCount = 0;

        foreach ($batches as $products) {
            $body = $products->reduce(function($carry, $product) {
                $carry[] = [
                    'index' => [
                        '_index' => 'products',
                        '_type' => 'product',
                        '_id' => $product->part_number,
                    ]
                ];

                $carry[] = collect(Product::$searchFields)->map(function($weight, $field) use ($product) {
                    return $product->$field;
                })->toArray();

                return $carry;
            }, array());

            Elasticsearch::bulk([ 'body' => $body ]);

            $doneCount += count($products);
            $this->info($doneCount . ' done');
        }
    }
}