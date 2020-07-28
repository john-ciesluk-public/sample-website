<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Property;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('dashboardRole:properties:create')->only(['store']);
        $this->middleware('dashboardRole:properties:edit')->only(['update']);
    }

	public function index()
	{
		return Response::json([
			'status' => 'success',
			'properties' => Property::all()
		]);
	}

	public function show($id)
	{
		return Response::json([
			'status' => 'success',
			'property' => Property::findOrFail($id)
		]);
	}

	public function store(Request $request)
	{
		$params = $request->intersect([
			'code',
			'label',
			'type',
			'show_in_filters',
		]);

		$property = Property::create($params);
		$property->save();

		return Response::json([
			'status' => 'success',
			'property' => $property,
		]);
	}

	public function update($id, Request $request)
	{
		$params = $request->intersect([
			'code',
			'label',
			'type',
			'show_in_filters',
		]);

		$property = Property::findOrFail($id);
		$property->fill($params);
		$property->save();

		return Response::json([
			'status' => 'success',
			'property' => $property,
		]);
	}
}