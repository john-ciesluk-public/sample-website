<li class="product-item col-xs-12 col-sm-6 col-md-4">
    <div class="product-item-wrap">
        @if ($product->new)
            <img src="{{ url('/images/icons/icon-new-product.png') }}" alt="New Product" class="new-product-icon" />
        @endif
        <div class="product-item-img-wrap">
            <a class="view-product" href="{{ route('products.product', $product->product) }}">
                <img class="center-block img img-responsive product-list-image"
                     @if ($product->image)
                         src="https://metra-images.s3.amazonaws.com/medium/{{ $product->image }}"
                     @else
                         src="{{ url('/images/placeholder.png') }}"
                     @endif
                />
            </a>
        </div>
        <div class="product-item-description">
            <a href="{{ route('products.product', $product->product) }}">
                <span class="product-item-title">{{ $product->name }}</span>
                <span class="product-item-sku">{{ $product->product }}</span>
            </a>
            <p>{!! textile($product->short_description) !!}</p>
        </div>
        <div class="product-item-buttons">
            @if ($product->document)
                <a href="https://metra-static.s3.amazonaws.com/documents/{{ $product->document }}" target="_blank">
                    <button class="btn btn-default btn-grey" type="submit">Instructions</button>
                </a>
            @endif
            <a href="{{ route('products.product', $product->product) }}">
                <button class="btn btn-default btn-grey" type="submit">Details</button>
            </a>
        </div>
    </div>
</li>

