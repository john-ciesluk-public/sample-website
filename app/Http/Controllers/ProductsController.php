<?php

namespace App\Http\Controllers;

use App\CaliforniaPropCodes;
use App\CaliforniaPropCodeParts;
use App\Category;
use App\Common;
use App\Filter;
use App\Http\Requests\ProductRequest;
use App\MsrpParts;
use App\Pagination;
use App\Product;
use App\ProductDocument;
use App\ProductImage;
use App\ProductVideos;
use App\RelatedProducts;
use App\RequiredProducts;
use App\WebsiteCategories;
use App\WebsiteProducts;
use Cviebrock\LaravelElasticsearch\Facade as Elasticsearch;
use Illuminate\Http\Request;
use Response;
use Netcarver\Textile\Parser;
use App\Vfg;

class ProductsController extends Controller
{
    public function __construct(Request $request) {
        $this->siteId = config('sitespecific.siteId');
        //$this->middleware('jsonErrors')->only('liveSearch');
    }

    /**
     * Show all products with filters
     *
     * @param Request $request
     *
     * @return \Illuminate\View\View
     *
     */
    public function index(ProductRequest $request, Vfg $vfg, Product $p, Filter $f, WebsiteCategories $wc)
    { 
        $category = $filterCodes = $new = $search = $currentFilters = $vfgResults = false;
        $displayName = 'Products';
        $back = \URL::to("/") . "/products";

        $vfgOptions = $request->getVfgOptions();

        if ($request->has('category')) {
            $categoryName = $request->input('category');
            $back = \URL::to("/") . "/products?category=".$categoryName;
            $category = $wc->getCategoryByName($categoryName);

            $displayName = $category->name;
            if ($request->has('filters') && $category) {
                $filterCodes = $request->input('filters');
                $back = \URL::to("/") . "/products?category=".$categoryName."&filters=".$filterCodes;
                $count = count(explode(",",$filterCodes));

                if ($count > 1) {
                    $currentFilters = explode(",",$filterCodes);
                } else {
                    $currentFilters = [$filterCodes];
                }
            }

        }

        if ($request->has('new')) {
            $new = true;
            $displayName = 'New Products';
            $back = \URL::to("/") . "/products?new=1";
        }

        if ($request->has('search')) {
            $search = $request->input('search');
            $displayName = 'Search results for "'.$search.'"';
            $back = \URL::to("/") . "/products?search=".$search;
        }

        if ($vfgOptions) {
            $curlResult = $vfg->getProducts($vfgOptions);

            $vfgResults = array_pluck($curlResult->products, "id");

            $displayName = 'Results for ' . $curlResult->subcat;
        }

        $results = $p->getProducts($this->siteId,$category,$filterCodes,$new,$search,$vfgResults);

        $filters = $f->getFilters('all');

        $categories = $wc->getCategories($this->siteId);

        $products = $results->paginate(20);
        $products->appends(request()->except('page'));

        $view = view('products/index',[
            'products' => $products,
            'categories' => $categories,
            'category' => $category,
            'filters' => $filters,
            'currentFilters' => $currentFilters,
            'displayName' => $displayName,
            'back' => $back
            
        ]);

        return $view;
    }
    
    
    /**
     * Show a single product
     *
     * @param string $partNumber
     *
     * @return \Illuminate\View\View
     *
     */
    public function product($part, 
        Request $request, 
        Parser $parser, 
        Product $p,
        ProductImage $i,
        ProductVideos $v,
        ProductDocument $d)
    {
        $product = $p->getProduct($part, $this->siteId);
        $images = $i->getProductImages($product);
        $videos = $v->getProductVideos($product);
        $documents = $d->getProductDocuments($product);        
        $related = $p->getRelatedProducts($product);
        $required = $p->getRequiredProducts($product);
        $propCode = $this->prop($product->product);
        $msrp = MsrpParts::where('part_number',$product->product)->first();

        return view('products/product', [
            'images' => $images,
            'product' => $product,
            'documents' => $documents,
            'videos' => $videos,
            'description' => $parser->parse($product->description),
            'applications' => $parser->parse($product->applications),
            'relatedProducts' => $related->sortBy('product'),
            'requiredProducts' => $required->sortBy('product'),
            'propCode' => $propCode,
            'msrp' => $msrp
        ]);
    }

    /**
    * Get all the products for an ajax request
    *
    * @return array $products
    *
    */
    public function getProducts(Product $p)
    {
        $products = $p->getProductsForAjax($this->siteId);

        foreach ($products as $product) {
            $availableTags[] = $product->product;
        }

        return Response::json($availableTags);

    }

    /**
     * Set the back url to the session
     *
     */
/*    public function setBackValue(Request $request)
    {
        $request->session()->put('back',$request->input('back'));
    }
*/
    /**
    * Get all products
    *
    * @return (json) array
    *
    */
    public function getProductsNoCategory(Request $request, Product $p, Pagination $pag)
    {
        $results = $p->getProducts($this->siteId);
        $back = \URL::to("/") . "/products";
        
        $products = $results->paginate(20);

        $paginate = $pag->makePagination($products,$request,$back);
        foreach ($products as $product) {
            $make = \View::make('products/list-item',['product' => $product]);
            $views[] = $make->render();
        }

        return Response::json(['views' => $views, 'paginate' => $paginate, 'filters' => '','back' => $back]);
    }

    /**
    * Get all the products by category for an ajax request
    *
    * @return (json) array
    *
    */
    public function getProductsByCategory(Request $request, Product $p, Filter $f, WebsiteCategories $wc, Pagination $pag)
    {
        if ($request->isMethod('post')) {

            $categoryName = $request->input('category');
            $category = $wc->getCategoryByName($categoryName);
            $displayName = $category->name;

            $products = $p->getProductsByCategory($this->siteId,$category->id);

            $back = \URL::to("/") . "/products?category=".$categoryName;

            $filter = $f->getFiltersByCategory($category->id);
            $filters = $f->makeFilters($filter);

            $paginate = $pag->makePagination($products,$request,$back);
            foreach ($products as $product) {
                $make = \View::make('products/list-item',['product' => $product]);
                $views[] = $make->render();
            }
            return Response::json(['views' => $views,'paginate' => $paginate,'filters' => $filters,'back' => $back,'displayName' => $displayName]);
        }

    }

    /**
    * Get all the products by filter for an ajax request
    *
    * @return (json) array
    *
    */
    public function getProductsByFilter(Request $request, Product $p, WebsiteCategories $wc, Pagination $pag)
    {
        if ($request->isMethod('post')) {
            $filterCodes = false;
            $categoryName = $request->input('category');

            $category = $wc->getCategoryByName($categoryName);
            $displayName = $category->name;

            $back = \URL::to("/") . "/products?category=".$categoryName;
            $results = $p->getProducts($this->siteId,$category);

            if ($request->has('filters')) {
                $filterCodes = $request->input('filters');
                //unique query
                $filters = Filter::select('id')->whereIn('filter',$filterCodes)->get();

                $results->join('product_filters','product_filters.products_id','=','products.id')
                    ->whereIn('product_filters.filters_id',$filters->toArray())
                    ->where('product_filters.website_id',$this->siteId);
  
                $urlFilters = '&filters='.implode(",",$filterCodes);
                $back = \URL::to("/") . "/products?category=".$categoryName . $urlFilters;
            }

            $products = $results->paginate(20);

            $paginate = $pag->makePagination($products,$request,$back);

            foreach ($products as $product) {
                $make = \View::make('products/list-item',['product' => $product]);
                $views[] = $make->render();
            }
            return Response::json(['views' => $views,'paginate' => $paginate,'back' => $back,'displayName' => $displayName]);
        }

    }

    /**
     * Gets the California prop65 image for a product
     */
    public function prop($part)
    {
        $url = $image = '';
        $prop = CaliforniaPropCodeParts::where('part_number',$part)->first();
        if ($prop) {
            $id = $prop['california_prop_code_id'];
            if ($id == 1) {
                $image = 'prop65-warning1.jpg';
            } else if ($id == 2) {
                $image = 'prop65-warning2.jpg';
            } else if ($id == 3) {
                $image = 'prop65-warning3.jpg';
            } else if ($id == 4) {
                $image = 'prop65-warning4.jpg';
            } else if ($id == 0) {
                $image = '';
            }
        }

        if ($image) {
            return $image;
        }

        return false;
    }
    
    /**
     * Provides searching endpoint.
     *
     * @param string    $search The search term
     * @return Array    Search results
     */
    public function liveSearch(Product $product, Request $request)
    {
        $search = $request->input('term');
        $result = $product
            ->getProducts($this->siteId, null, null, null, $search)
            ->whereEnabled(true);
        
        $products = $result
            ->paginate($request->input('maxRows'))
            ->appends($request->except('page'))
            ->items();
        
        return Response::json($products);
        
    }
    
    
}
