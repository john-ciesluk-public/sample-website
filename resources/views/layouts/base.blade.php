<html lang="en">
    <head>
        <?php
            header('Access-Control-Allow-Origin: https://metradealer.com');
            header('Access-Control-Allow-Credentials: true');
        ?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="index,follow">
        <meta name="_token" content="{{ csrf_token() }}">
        <title>
            @section('title')
                @yield('page-title') | iBeam, Vehicle Safety Systems
            @show
        </title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="{{ url('/js/bootstrap.js') }}"></script>

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
        <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

        <script type="text/javascript" src="{{ url('/js/Metra.js') }}"></script>
        <script type="text/javascript" src="{{ url('/js/vfg/Metra_VFG.js') }}"></script>

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,700i,800" rel="stylesheet">
        <link href="{{ url('/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ url('/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ url('/css/style.css') }}" rel="stylesheet">
        <link href="{{ url('/css/responsive.css') }}" rel="stylesheet">
        <!-- <link href="{{ url('/css/vfg.css') }}" rel="stylesheet"> -->
        <link rel="shortcut icon" href="{{{ asset('/images/favicon.png') }}}">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script>
        //Global Set base url
        var base_url = '{{ URL::to('/') }}';
        </script>
        <script src="{{ url('/js/ibeam.js') }}"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-38774182-10"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-38774182-10');
    </script>

    </head>
    <body id="@yield('body-id', '')" class="@yield('body-class', '')">
        <div class="container-fluid full-width page-wrap">
        	<a id="button"></a>
            <header>
                <div class="top-bar">
                    <div class="container">
                        <span class="dealer-callout">Are you a Dealer? <a href="http://metraonline.com/for-dealers" target="_blank">Click Here</a></span>
                    </div>
                </div>
                <nav class="navbar navbar-default">
                    <div class="container">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ url('/images/logos/ibeam-top-logo.png') }}" alt="Metra Website" /></a>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                <li><a href="{{ url('/products') }}">Products</a></li>
                                <li><a href="{{ url('/resources/videos') }}">Product Videos</a></li>
                                <li><a href="{{ url('/products?new=1') }}">New Products</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dealer Resources <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown-item"><a href="{{ url('/resources/catalogs') }}">Catalogs</a></li>
                                        <!-- <li role="separator" class="divider"></li> -->
                                        <li class="dropdown-item"><a href="{{ url('/about') }}">About Us</a></li>
                                        <li class="dropdown-item"><a href="https://metraonline.us2.list-manage.com/subscribe?u=4a084f91113228aac19b931c2&id=051342ea12" target="blank">Email Newsletter Signup</a></li>
                                        @if (\App\WebsiteBlogPosts::where('website_id',config('sitespecific.siteId'))->first())
                                            <li role="separator" class="divider"></li>
                                            <li><a href="{{ url('/news') }}">News</a></li>
                                        @endif
                                    </ul>
                                </li>
                                <li><a href="{{ url('/contact') }}">Contact Us</a></li>
                            </ul>
                            <form action="/products" method="get" class="navbar-form navbar-right" role="search">
                                <div class="form-group product-search-box">
                                    <input type="text" name="search" class="form-control live-search" id="search_products" placeholder="Search">
                                </div>
                                <button type="submit" class="btn btn-default search-btn btn-red">Search</button>
                            </form>
                        </div>
                    </div>
                </nav>
            </header>

            @yield('content')

            <footer class="site-footer">
                <div class="container">
                    <div class="row">
                        <div class="footer-info">
                            <div class="col-xs-12 col-sm-12 col-md-6 footer-left">
                                <a href="{{ url('/') }}">
                                    <img src="{{ url('/images/logos/ibeam-footer-logo.png') }}" alt="iBeam - Metra Electronics" class="img-responsive">
                                </a>
                                <div class="phone-container">
                                    <div class="phone-wrap">
                                        <img src="{{ url('/images/icons/icon-phone.png') }}" alt="Technical Support" class="img-responsive">
                                        <span class="phone-thin">Tech Support</span>
                                        <span class="phone-thick">386-257-1187</span>
                                    </div>
                                </div>
                                <div class="phone-container">
                                    <div class="phone-wrap">
                                        <img src="{{ url('/images/icons/icon-phone.png') }}" alt="Sales Support" class="img-responsive">
                                        <span class="phone-thin">Sales Support</span>
                                        <span class="phone-thick">386-257-2956</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 footer-right">
                                <a href="http://metraonline.com/" target="_blank">
                                    <img src="https://axxessinterfaces.com/images/logos/metra-footer-logo.png" alt="Metra Electronics" class="img-responsive">
                                </a>
                                <div class="social-links">
                                    <a href="https://www.facebook.com/MetraElectronics/" target="_blank"><i class="fa fa-facebook-official fa-3" aria-hidden="true"></i></a>
                                    <a href="https://www.instagram.com/metraelectronics/" target="blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                    <a href="https://www.youtube.com/playlist?list=PLmfXCeD8SlOp94eduwcRTI-K-aWUx6RoQ" target="_blank"><i class="fa fa-youtube-play fa-3" aria-hidden="true"></i></a>
                                    <a href="https://twitter.com/MetraElectronic" target="_blank"><i class="fa fa-twitter fa-3" aria-hidden="true"></i></a>
                                </div>
                                <div class="social-hash">
                                    <p>#iBEAMsafety</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="footer-nav">
                            <div class="col-xs-12 col-md-6">
                                <ul>
                                    <!-- ADAS -->
                                    <li class="top-item">
                                        <a href="{{ url('/products') }}">Product Categories</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/products?category=I-ACCAVOID') }}">ADAS Solutions</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/products?category=I-CAMERA') }}">Cameras</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/products?category=I-MCAMINT') }}">Multi Camera</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/products?category=I-MIRROR') }}">Mirrors + Monitors + Dashcams</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/products?category=I-VSKITS') }}">Vehicle Specific Kits</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/products?category=I-COMMERCL') }}">Commercial Heavy Duty</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/products?category=I-VIDEOACC') }}">Accessories</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <ul>
                                    <!-- Dealer Support -->
                                    <li class="top-item">
                                        <a>Dealer Support</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/contact') }}">Contact Us</a>
                                    </li>
                                    <li>
                                        <a href="http://metraonline.com/for-dealers" target="blank">Become A Dealer</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/resources/catalogs') }}">Catalogs</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/installation') }}">Installation Tips</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/faq') }}">FAQs</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/shipping') }}">Shipping Policy &amp; Terms</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/warranty') }}">Warranty Info</a>
                                    </li>
                                    <li>
                                        <a href="http://eepurl.com/daa5Hv" target="blank">Email Newsletter Signup</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="footer-bottom">
                        <p>&copy;{{ date("Y") }} iBEAM Vehicle Safety &nbsp;&nbsp; All Rights Reserved &nbsp;&nbsp; <a href="{{ url('/privacy') }}">Privacy Policy</a> | <a href="{{ url('/accessibility') }}">Accessibility Statement</a></p>
                    </div>
                    <div class="clearfix"></div>
                    <hr />
                    <div class="family-brands">
                        <a class="brand" href="https://metradealer.com/login" target="blank"><img src="/images/logos/metra.png" alt="Metra Electronics"></a>
                        <a class="brand" href="http://www.ballistic-online.com/" target="blank"><img src="/images/logos/ballistic.png" alt="Ballistic Sound Dampening"></a>
                        <a class="brand" href="http://raptor-online.com/" target="blank"><img class="brand" src="/images/logos/raptor.png" alt="Raptor - Metra Electronics"></a>
                        <a class="brand" href="http://www.tspeconline.com/" target="blank"><img src="/images/logos/tspec.png" alt="Tspec - Metra Electronics"></a>
                        <a class="brand" href="http://axxessinterfaces.com/" target="blank"><img src="/images/logos/axxess.png" alt="Axxess Interfaces"></a>
                        <a class="brand" href="http://theinstallbay.com/" target="blank"><img src="/images/logos/installbay.png" alt="Install Bay"></a>
                        <a class="brand" href="http://www.shurikenonline.com/" target="blank"><img src="/images/logos/shuriken.png" alt="shuriken"></a>
                        <a class="brand" href="http://heiseled.com/" target="blank"><img src="/images/logos/heise.png" alt="Heise LED Lighting"></a>
                        <a class="brand" href="https://metrapowersports.com/" target="blank"><img src="/images/logos/mps.png" alt="Metra PowerSports"></a>
                        <a class="brand" href="http://www.metramarine.com/" target="blank"><img src="/images/logos/metramarine.png" alt="Metra Marine"></a>
                        <a class="brand" href="http://www.ammotenna.com/" target="blank"><img src="/images/logos/ammontenna.png" alt="Automotive Antenna Replacement Masts"></a>
                    </div>
                </div>

                <!-- Userway -->
                <script data-account="aKLml74i2S" src="https://accessibilityserver.org/widget.js"></script>
            </footer>
        </div>
        <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="embed-responsive embed-responsive-16by9">
                             <iframe class="embed-responsive-item" id="video-modal-iframe" src=""></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
