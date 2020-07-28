<div class="col-xs-12 col-md-4">
    <aside class="left-sidebar">

        @if (isset($categories))
            <!-- VFG -->
            <div class="visible-lg visible-md">
                @include('layouts.sidebar-vfg')
            </div>
            <div class="visible-xs visible-sm">
                @include('layouts.responsive-sidebar-vfg')
            </div>
        @endif

        <!-- Filters -->
        @include('layouts.filters')
		
        <!-- Quick Links -->
        <div class="visible-lg visible-md">
            @include('layouts.quick-links')
        </div>
        <div class="visible-xs visible-sm">
            @include('layouts.responsive-quick-links')
        </div>

        <!-- Sidebar Images -->
        <div class="visible-lg visible-md">
            @include('layouts.sidebar-images')
        </div>

    </aside>
</div>
