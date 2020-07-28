<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Intervention\Image\ImageManagerStatic as Image;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'path',
        'is_primary',
    ];

    /**
     *
     * Gets images for a product
     *
     */
    public function getProductImages($product)
    {
        return ProductImage::where('product_id',$product->id)
                  ->join('products','products.id','=','product_images.product_id')
                  ->orderBy('is_primary','DESC')
                  ->get();
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function url($options = null)
    {
        if (is_string($options)) {
            $size = $options;
        } else if (is_array($options) && isset($options['size'])) {
            $size = $options['size'];
        } else {
            $size = 'small';
        }

        $root = config('assets.images.products.rootUrl');
        return $root . '/' . $size . '/' . $this->path;
    }

    public function toApiData()
    {
        return (object) [
            'path' => $this->path,
            'isPrimary' => $this->is_primary,
        ];
    }
}
