<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Product;
use App\Import\ProductImport;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('dashboardRole:products:create')->only(['store']);
        $this->middleware('dashboardRole:products:edit')->only(['update']);
    }

    public function index(Request $request)
    {
        $query = Product::withDetail();

        if ($request->has('from') && $request->has('to')) {
            $query->skip($request->input('from'));
            $query->take($request->input('to'));
        }

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('part_number', 'LIKE', "$search%");
        }

        $products = $query->get();

        return Response::json([
            'status' => 'success',
            'products' => $products->map(function($product) {
                return $product->toApiData();
            })
        ]);
    }

    public function show($partNumber)
    {
        $product = Product::wherePartNumber($partNumber)->firstOrFail();

        return Response::json([
            'status' => 'success',
            'product' => $product->toApiData(),
        ]);
    }

    public function store(Request $request)
    {
        $data = (object) $request->input('product');

        $import = new ProductImport([
            'create' => true,
        ]);

        $product = $import->one($data);

        return Response::json([
            'status' => 'success',
            'product' => $product->toApiData(),
        ]);
    }

    public function update($partNumber, Request $request)
    {
        $data = (object) $request->input('product');

        $import = new ProductImport([
            'update' => 'all',
            'create' => false,
        ]);

        $product = $import->one($data);

        return Response::json([
            'status' => 'success',
            'product' => $product->toApiData(),
        ]);
    }
}
