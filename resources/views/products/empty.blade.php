@extends('layouts.base')

@section('page-title', 'Products')
@section('body-id', 'products')
@section('body-class', 'products-category')

@section('content')
    @include('layouts.alt-nav')
    <div id="content" class="container">
        <div class="row">
            @include('layouts.left-sidebar')
            <div class="col-xs-12 col-md-8 page-content">
                <h1 class="page-title">Products</h1>
                There are no products to display.
            </div>
        </div>
    </div>
@endsection
