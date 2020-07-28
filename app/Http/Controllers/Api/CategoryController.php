<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        return Response::json([
            'status' => 'success',
            'categories' => Category::all()
        ]);
    }
}
