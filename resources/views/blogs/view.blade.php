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


            <div class="col-xs-12 col-md-8 page-content blog-wrap">
                <div class="col-xs-12">

                    <a href="{{ url('news') }}">Back to news</a>
                    <h1 class="page-title">{{ $blog->title }}</h1>
                    <h5>{{ date('M j, Y',strtotime($blog->release_date)) }}</h5>
                    <div class="row content-section">
                        <?php echo $blog->content ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
