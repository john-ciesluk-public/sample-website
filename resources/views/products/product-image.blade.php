<div class="product-description">
    <div class="product">
        <a href="https://metra-images.s3.amazonaws.com/full/{{ $product->path }}" data-fancybox="gallery">
            <img class="img-responsive product-img" src="https://metra-images.s3.amazonaws.com/full/{{ $product->path }}" alt="{{ $product->product }}" />
        </a>
    </div>
    <!-- Product Thumbnails -->
    @if (count($images) > 1)
        <div class="row thumb-js">
            @foreach($images as $image)
                @if ($image->path != $product->path)
                    <div class="col-xs-6 col-sm-4 thumb">
                        <a data-fancybox="gallery" href="https://metra-images.s3.amazonaws.com/full/{{ $image->path }}"><img class="thumb img-thumbnail" src="https://metra-images.s3.amazonaws.com/medium/{{ $image->path }}" alt="{{ $image->product }}" /></a>
                    </div>
                @endif
            @endforeach
        </div>
    @endif

    <div class="row">
        <div class="col-sm-12">
            <hr />
            <h4>3D Images</h4>
        </div>
    </div>
    <div class="row" style="padding-bottom:10px;">
        <div class="col-sm-12">
            <iframe height="350px" src="http://theinstallbay.com/360test/orbitvu/test%20360%201test%20360%201.html"></iframe>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <iframe height="300px;" src="http://theinstallbay.com/360test/VolumesVideo_RAIDKeyshot FilesKits to Render.bip.404.html">
                allowfullscreen
                style="position: absolute; top: 0px; left: 0px; height: 100%; width: 1px; min-width: 100%; *width: 100%;"
                frameborder="0"
                scrolling="no">
            </iframe>
        </div>
    </div>
</div>
<div class="row">
    @if (count($videos) > 0)
        <br /><hr />
        <h4>Product Videos</h4>
        <br />
        @foreach ($videos as $video)
            <div class="youtube col-sm-12">
                <div class="thumbnail">
                    <div class="video">
                        <a class="video-modal-button" href="{{ $video->video }}" data-toggle="modal" data-target="#videoModal">
                            <div class="play-button"></div>
                            <img class="img-thumbnail video-modal" src="http://img.youtube.com/vi/{{ $video->video }}/mqdefault.jpg" />
                        </a>
                    </div>
                    <div class="caption">
                        <span>{{ $video->title }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@if ($propCode)
    <div class="row">
        <div class="col-sm-12">
            <img class="img img-responsive pull-left" src="https://metra-images.s3.amazonaws.com/full/{{ $propCode }}" />
        </div>
    </div>
@endif
