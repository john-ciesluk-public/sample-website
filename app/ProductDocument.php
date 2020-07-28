<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDocument extends Model
{
    protected $fillable = [
        'product_id',
        'path',
    ];

    /**
     *
     * Gets documents for a product
     *
     */
    public function getProductDocuments($product)
    {
        return ProductDocument::where('product_id',$product->id)
            ->join('product_document_type','product_document_type.id','=','product_documents.document_type_id')
            ->get();
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function url()
    {
        $root = config('assets.documents.rootUrl');
        return $root . '/' . $this->path;
    }

    public function toApiData()
    {
        return (object) [
            'path' => $this->path,
        ];
    }
}
