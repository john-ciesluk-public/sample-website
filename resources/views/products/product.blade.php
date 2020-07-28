@extends('layouts.base')

{{-- @section('page-title', $product->part_number) --}}

@section('body-id', 'product')

@section('body-class', 'product-page')

@section('content')
@include('layouts.alt-nav')
<div id="content" class="container">
    <div class="row">
        @include('layouts.left-sidebar')
            <div class="col-xs-12 col-md-8 page-content">
                <div class="col-xs-12 product-wrap">
                    <div class="row">
                        <div class="col-xs-12 product-header">
                            <a href="{{ url()->previous() }}" class="pull-left">
                                &lt; Back
                            </a>
                            <span class="pull-right product-header-title">{{ $product->product }}</span>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:10px;">
                        <!-- Product Image -->
                        <div class="col-xs-12 hidden-sm hidden-md hidden-lg" style="margin-bottom:10px">
                            <h1 class="product-name">{{ $product->product }}</h1>
                            <h2 class="product-title">{{ $product->name }}</h2>
                            <p>{!! textile($product->short_description) !!}</p>
                            @include('products/product-image')
                        </div>
                        <!-- Product Tabs -->
                        <div class="col-xs-12 col-sm-6">
                            <div class="hidden-xs">
                                <h1 class="product-name">{{ $product->product }}</h1>
                                <h2 class="product-title">{{ $product->name }}</h2>
                                <p>{!! textile($product->short_description) !!}</p>
                                @if ($msrp)
                                    <p style="color:red"><strong>MSRP: ${{ $msrp->msrp }} USD</strong></p>
                                @endif
                            </div>
                            <div class="product-tabs">
                                <!-- Tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#product-features" aria-controls="product-features" role="tab" data-toggle="tab">Product<br />Features</a></li>
                                    <li role="presentation"><a href="#docs-instructions" aria-controls="docs-instructions" role="tab" data-toggle="tab">Tech Docs<br />&amp; Instructions</a></li>
                                    <li role="presentation"><a href="#vehicle-specific" aria-controls="vehicle-specific" role="tab" data-toggle="tab">Vehicle<br />Applications</a></li>
                                </ul>
                                <!-- Tab Panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="product-features">
                                        <div>{!! textile($product->description) !!}</div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="docs-instructions">
                                        @if (count($documents))
                                            <ul>
                                                @foreach ($documents as $document)
                                                    <li><a href="https://metra-static.s3.amazonaws.com/documents/{{ $document->path }}" target="_blank">{{ $document->type }}</a></li>
                                                @endforeach
                                            </ul>
                                        @else
                                            None at this time
                                        @endif
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="vehicle-specific">
                                        @if ($product->applications)
                                            {!! textile($product->applications) !!}
                                        @else
                                            Not available
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Product Image -->
                        <div class="hidden-xs col-sm-6">
                            @include('products/product-image')
                        </div>
                    </div>
                    <!-- Required Products 
                    @include('products/required-products')
                    Related Products
                    @include('products/related-products') -->
                </div>
            </div>
            <div class="col-xs-12 product-wrap">
                    <!-- Required Products -->
                    @include('products/required-products')
                    <!-- Related Products -->
                    @include('products/related-products')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
