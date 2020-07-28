@extends('layouts.base')

@section('page-title', 'News')

@section('meta-description')
    <meta name="description" content="iBeam news"/>
@stop

@section('body-id', 'catalogs')

@section('body-class', 'interior-page')

@section('content')
    @include('layouts.alt-nav')

    <div id="content" class="container">
        <div class="row">
            @include('layouts.left-sidebar')


            <div class="col-xs-12 col-md-8 page-content">
                <div class="col-xs-12">

                    <h1 class="page-title">News</h1>

                    <div class="row content-section blog-wrap">
                        @foreach ($blogs as $blog)
                            <h3><a href="{{ URL::to('/') . '/news/view/' . $blog->slug }}">{{ $blog->title }}</a></h3>
                            <h5>{{ date('M j, Y',strtotime($blog->release_date)) }}</h5>
                            <?php echo $blog->excerpt; ?>
                            <p><a href="{{ URL::to('/') . '/news/view/' . $blog->slug }}">read more...</a></p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
