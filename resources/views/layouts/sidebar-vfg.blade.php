@if (in_array(app('request')->input('category'),['I-MIRROR','I-CAMERA','I-VIDEOACC','I-MCAMINT','I-VSKITS']))
<div class="sidebar-vfg">
    <h3>Vehicle Fit Guide</h3> 
    @include('layouts.vfg')
</div>
@else
<?php //@include('layouts.sidebar-ad'); ?>
@endif

