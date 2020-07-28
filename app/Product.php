<?php

namespace App;

use App\Category;
use App\Exceptions\PropertyNotFoundException;
use App\ProductImage;
use App\ProductDocument;
use App\RequiredProducts;
use App\RelatedProducts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'short_description',
    ];

    // Mapping of searchable field names to relative weights
    public static $searchFields = [
        'product'       => 10,
        'name'             => 2,
        'description'       => 1,
        'short_description' => 1,
        'applications'      => 1,
    ];

    public function getProduct($product, $siteId)
    {
        return Product::select('*','products.id as id')->where('product',$product)
            ->where('products.deleted',0)->where('products.enabled',1)
            ->join('website_products','website_products.products_id','=','products.id')->where('website_id',$siteId)
            ->leftjoin('product_images',function($q) {
                $q->on('product_images.product_id','=','products.id')->where('product_images.is_primary','=',1);
            })
            ->firstOrFail();
    }

    /**
     *
     * Gets a list of products for an ajax query
     *
     */
    public function getProductsForAjax($siteId)
    {
        return Product::select('product')
            ->where('products.deleted',0)->where('products.enabled',1)
            ->join('website_products','website_products.products_id','=','products.id')->where('website_id',$siteId)->get();
    }

    public function getProductsByCategory($siteId,$category)
    {
        return Product::select('*','products.name as name','product_images.path as image','product_documents.path as document')
                ->where('products.deleted',0)->where('products.enabled',1)
                ->join('website_products','website_products.products_id','=','products.id')
                ->join('website_categories','website_categories.id','=','website_products.website_categories_id')
                ->leftjoin('product_images',function($q) {
                    $q->on('product_images.product_id','=','products.id')->where('product_images.is_primary','=',1);
                })
                ->leftjoin('product_documents',function($q) {
                    $q->on('product_documents.product_id','=','products.id')->where('product_documents.document_type_id','=',1);
                })
                ->where('website_categories.website_id',$siteId)
                ->where('website_categories.id',$category)
                ->orderBy('website_products.sort_order','ASC')
                ->paginate(20);
    }

    /**
     *
     * Gets the base product query
     *
     */
    public function getProducts($siteId,$category = false, $filters = false, $new = false, $search = false, $vfg = false)
    {

        $results = Product::select(DB::raw('DISTINCT(products.product)'), 'products.short_description', 'products.name', 'products.new','product_images.path as image','product_documents.path as document')
            ->where('products.deleted',0)->where('products.enabled',1)
            //->orderBy('website_products.sort_order','ASC')
            //->orderBy(DB::raw("IFNULL('website_products.sort_order', 9999999)", 'ASC'))
            ->join('website_products','website_products.products_id','=','products.id')->where('website_products.website_id',$siteId)
            ->leftjoin('product_images',function($q) {
                $q->on('product_images.product_id','=','products.id')->where('product_images.is_primary','=',1);
            })
            ->leftjoin('product_documents',function($q) {
                $q->on('product_documents.product_id','=','products.id')->where('product_documents.document_type_id','=',1);
            });

        if ($category) {
            $results->where('website_products.website_categories_id',$category->id);
            
            if ($category && $filters) {
                
                if (count(explode(",",$filters)) > 1) {
                    $currentFilters = explode(",",$filters);
                    $filters = Filter::whereIn('filter',$currentFilters)->get();

                    foreach ($filters as $filter) {
                        $filterIds[] = $filter->id;
                    }
                    $results->join('product_filters','product_filters.products_id','=','products.id')->whereIn('filters_id',$filterIds);
                } else {
                    $filters = Filter::where('filter',$filters)->firstOrFail();
                    $filter = $filters->id;
                    $results->join('product_filters','product_filters.products_id','=','products.id')->where('filters_id',$filter);
                }
            }

        }
        
        if ($new) {
            $results->where('new',1);
        }
        
        if ($search) {
            $filterMatch = $this->filterMatch($search,$siteId);

            $matchProduct = $this->matchExactProduct($search,$siteId);

            if (empty($matchProduct)) {
                //Filter out plurals from regular searches ('s','es')
                $last = trim(substr($search, -1));
                $lastTwo = trim(substr($search, -1,2));
                if ($last == 's') {
                    $search = substr($search,0,-1);
                } else if ($lastTwo == 'es') {
                    $search = substr($search,0,-2);
                }  

                //Filter out dashes from regular searches ('-')
//                $search = str_replace('-',' ',$search);
            }


            $results->where(function ($query) use ($search) {
                $query->where('products.product','like','%'.$search.'%')
                    ->orWhere('products.name','like','%'.$search.'%')
                    ->orWhere('products.description','like','%'.$search.'%')
                    ->orWhere('products.applications','like','%'.$search.'%');
            });

            if (empty($filterMatch)) {

                $results->orderBy('products.product')
                    ->orderBy('products.name');
            }

            if (!empty($filterMatch)) {
                $results->join('product_filters','product_filters.products_id','=','products.id')
                    ->join('filters','filters.id','=','product_filters.filters_id')
                    ->orWhere('filters.name','like','%'.$search.'%')
                    ->orderBy('filters.name');

                $results
                    ->orderBy('products.product')
                    ->orderBy('products.name');
            }

            $results
                ->orderBy('products.short_description')
                ->orderBy('products.description')
                ->orderBy('products.applications');

            $results->where(function ($query) use ($search) {
                $query->where('products.product','like','%'.$search.'%')
                ->orWhere('products.name','like','%'.$search.'%')
                ->orWhere('products.description','like','%'.$search.'%');
            });
        }

        if ($vfg) {
            $results->whereIn('product',$vfg);
        }

        return $results;
    }

    /**
     *
     * Get related products of a particular product
     * @param $product
     * @return (object)
     *
     */
    public function getRelatedProducts($product)
    {
        return RelatedProducts::select('products.product','products.name','product_images.path')
            ->join('products','products.id','=','related_products.related_id')
            ->leftjoin('product_images',function($q) {
                $q->on('product_images.product_id','=','products.id')->where('product_images.is_primary','=',1);
            })
            ->where('related_products.products_id',$product->id)
            ->get();
    }

    /**
     *
     * Get required products of a particular product
     * @param $product
     * @return (object) 
     *
     */
    public function getRequiredProducts($product)
    {
        return RequiredProducts::select('products.product','products.name','product_images.path')
            ->join('products','products.id','=','required_products.required_id')
            ->leftjoin('product_images',function($q) {
                $q->on('product_images.product_id','=','products.id')->where('product_images.is_primary','=',1);
            })
            ->where('required_products.products_id',$product->id)
            ->get();
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function scopeWhereCategory($query, $category)
    {
        return $query
            ->join('product_categories', 'product_categories.products_id', '=', 'products.id')
            ->where('product_categories.categories_id', $category->id)
            ->select('products.*');
    }

    public function scopeOrderByCategory($query)
    {
        return $query
            ->leftJoin('product_categories', 'product_categories.products_id', '=', 'products.id')
            ->leftJoin('categories', 'product_categories.categories_id', '=', 'categories.id')
            ->select('products.*')
            ->orderBy('categories.category');
    }

    public function getPrimaryImageAttribute()
    {
        return $this->images->first(function($image) {
            return $image->is_primary;
        });
    }

    public function imageUrl($options)
    {
        if (is_null($this->primaryImage)) {
            return "/images/product-placeholder.png";
        } else {
            return $this->primaryImage->url($options);
        }
    }

    public function images()
    {
        return $this->hasMany('App\ProductImage');
    }

    public function documents()
    {
        return $this->hasMany('App\ProductDocument');
    }

    public function test($product)
    {
        return $product;
    }

    public function getPrimaryDocumentAttribute()
    {
        // TODO: choose the primary document correctly
        return $this->documents->first();
    }

    public function requiredProducts()
    {
        return $this->belongsToMany('App\Product', 'required_products', 'products_id', 'required_id');
    }

    public function relatedProducts()
    {
        return $this->belongsToMany('App\Product', 'related_products', 'products_id', 'related_id');
    }

    public function scopeWhereSearch($query, $resultPartNumbers)
    {
        return $query->whereIn('part_number', $resultPartNumbers);
    }

    public function scopeOrderByRelevance($query, $resultPartNumbers)
    {
        if (count($resultPartNumbers)) {
            $list = collect($resultPartNumbers)
                ->map('json_encode')
                ->implode(', ');

            return $query->orderByRaw("FIELD(part_number, $list)");
        }
    }

    public function toApiData()
    {
        $this->_ensureKeyedProperties();

        $propertyData = array();

        foreach ($this->getRelationValue('properties') as $attr) {
            $propertyData[$attr->code] = $attr->value;
        }

        return (object) [
            'partNumber' => $this->part_number,
            'title' => $this->title,
            'description' => $this->description,
            'shortDescription' => $this->short_description,
            'applications' => $this->applications,
            'properties' => (object) $propertyData,
            'images' => $this->images->map(function($image) { return $image->toApiData(); }),
            'documents' => $this->documents->map(function($doc) { return $doc->toApiData(); }),
            'brand' => $this->brand ? $this->brand->code : null,
            'categories' => $this->categories ?
                $this->categories->map(function($category) { return ['category' => $category->code]; })
                : [],

            'relatedProducts' => $this->relatedProducts->map(function($product) {
                return ['partNumber' => $product->part_number];
            }),

            'requiredProducts' => $this->requiredProducts->map(function($product) {
                return ['partNumber' => $product->part_number];
            }),

            'sortOrder' => $this->sort_order,
        ];
    }

    public function getIsNewAttribute()
    {
        return (boolean) $this->property('new');
    }

    public function syncImages($images)
    {
        $images = objectify($images);

        foreach ($images as $data) {
            $image = ProductImage::firstOrNew([
                'product_id' => $this->id,
                'path' => $data->path,
            ]);

            $image->is_primary = $data->isPrimary ?? false;

            $image->save();
        }

        $paths = array_pluck($images, 'path');
        $existing = ProductImage::where('product_id', $this->id)->get();
        foreach ($existing as $e) {
            if (!in_array($e->path, $paths)) {
                $e->delete();
            }
        }
    }

    public function syncDocuments($documents)
    {
        $documents = objectify($documents);

        $paths = array_pluck($documents, 'path');

        foreach ($paths as $path) {
            ProductDocument::firstOrNew([
                'product_id' => $this->id,
                'path' => $path,
            ])->save();
        }

        $existing = ProductDocument::where('product_id', $this->id)->get();
        foreach ($existing as $e) {
            if (!in_array($e->path, $paths)) {
                $e->delete();
            }
        }
    }

    public function syncCategories($categoryData)
    {
        $categoryData = objectify($categoryData);

        $codes = array_pluck($categoryData, 'category');
        $categories = Category::whereIn('category', $codes)->get();
        $this->categories()->sync(array_pluck($categories, 'id'));
    }

    public function scopeWithDetail($query)
    {
        return $query->with([
            'images',
            'documents',
            'requiredProducts',
            'relatedProducts',
        ]);
    }

    private function filterMatch($search,$siteId) {
        return Product::select(DB::raw('DISTINCT(products.product)'), 'products.name', 'products.new')
            ->where('products.deleted',0)->where('products.enabled',1)
            ->join('website_products','website_products.products_id','=','products.id')->where('website_products.website_id',$siteId)
            ->join('product_filters','product_filters.products_id','=','products.id')
            ->join('filters','filters.id','=','product_filters.filters_id')
            ->where('filters.name','like','%'.$search.'%')
            ->get();
    }

    private function matchExactProduct($search,$siteId) {
        return Product::select('products.product')
            ->where('products.deleted',0)->where('products.enabled',1)
            ->join('website_products','website_products.products_id','=','products.id')->where('website_products.website_id',$siteId)
            ->where('products.product',$search)
            ->first();
    }

}
