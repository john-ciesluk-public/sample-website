<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductVideos extends Model
{
    public $timestamps = false;

    /**
     *
     * Gets videos for a product
     *
     */
    public function getProductVideos($product)
    {
        return ProductVideos::where('products_id',$product->id)->get();
    }
}
