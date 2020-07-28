<div class="col-xs-12 required-parts-wrap">
  @if (count($requiredProducts) > 0)
    <div class="row">
      <h3>Required Installation Products</h3>
      <h4>{{ $product->product }} requires additional products for installation.<br>See Product Features for details.</h4>
      <div class="carousel slide multi-item-carousel" id="multiCarousel-required">
        <div class="carousel-inner">
          @foreach ($requiredProducts as $index => $item)
            <div class="{!! $index === 0 ? 'item active' : 'item' !!}">
              <div class="col-xs-4">
                <a href="{{ route('products.product', array_merge([$item->product], Request::all())) }}">
                  <img src="https://metra-images.s3.amazonaws.com/small/{{ $item->path }}" alt="{{ $item->product }}" class="img-responsive" />
                  <span class="product-sku">{{ $item->product }}</span>
                  <span class="product-title">{{ $item->name }}</span>
                </a>
              </div>
            </div>
          @endforeach
        </div>
        <a class="left carousel-control" href="#multiCarousel-required" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
        <a class="right carousel-control" href="#multiCarousel-required" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
      </div>
    </div>
  @endif
</div>
