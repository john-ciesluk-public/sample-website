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
                <input type="hidden" name="back" id="back" value="{{ $back }}">
                <h1 class="page-title">{{ $displayName }}</h1>
                <ul class="product-list">
                    @each ('products.list-item', $products, 'product','products.empty')
            	</ul> 
                <div id="pagination">
                    {!! $products->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
