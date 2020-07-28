<div class="col-xs-12 related-products-wrap">
  @if (count($relatedProducts) > 0)
    <div class="row">
      <h3>You Might Also Be Interested In</h3>
      <div class="carousel slide multi-item-carousel" id="multiCarousel-related">
        <div class="carousel-inner">
          @foreach ($relatedProducts as $index => $item)
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
        <a class="left carousel-control" href="#multiCarousel-related" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
        <a class="right carousel-control" href="#multiCarousel-related" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
      </div>
    </div>
  @endif
</div>
