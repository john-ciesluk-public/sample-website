<!-- Advanced Drive Assistance Systems Ad -->
@if (isset($categories))
	<div class="sidebar-ad">
	    <a href="{{ url('/products?category=I-ACCAVOID') }}">
	        <img src="/images/adas-ad.jpg" alt="iBeam Advanced Drive Assistance Systems">
	    </a>
	</div>
@endif

<!-- Tech Support Callout -->
@if (Request::path() == 'faq')
	<div class="tech-support-ad">
		<img src="{{ url('/images/ads/tech-support.jpg') }}" alt="Heise LED Tech Support">
	</div>

	<div class="clearfix"></div>
@endif

@if (Request::path() == 'installation')
	<div class="install-tips-ad">
		<img src="{{ url('/images/ads/install-tips.jpg') }}" alt="Heise LED Installation Tips">
	</div>

	<div class="clearfix"></div>
@endif