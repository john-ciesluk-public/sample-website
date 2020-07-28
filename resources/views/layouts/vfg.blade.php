<div id="VFG" class="front-vfg">
    <form id="vfg_frm" name="frm_vfg" action="#" method="get">
       <!-- <input type="hidden" class="filter" name="filter[brand]" value="axxess" /> <!-- Put here to change to Axxess filter. app/modules/sites/views/scripts/metraonline/partials/_vfg.phtml -->
        <table>
        </table>
    </form>

    <div id="vfg_msg"></div>

    <div id="vfg_overlay">
        <span id="vfg_loading_msg"><img src="/images/vfg_ajax.gif" /><br />Loading...</span>
    </div>
</div>

<div id="vfg_results_for_testing"></div>
<script type="text/javascript">

$(function() {
    // Initialize the VFG
    vfg.load($("#vfg_frm"), {
        VFGServer: 'https://metradealer.com/vfg/lookup',
        SubmitURL: '/products',
        multiOptionModal: true,

        displayResults(params) {
            vfg.Session.save();
            window.location.assign(vfg.getProperty("SubmitURL") + vfg.buildQueryString(params));
        },

        clearResults() {
            const keptParams = pickBy(getQueryParameters(), (value, key) => !vfg.getStepNames().includes(key))
            location.href = getRouteUrl() + '?' + $.param(keptParams)
        },
    });
});

</script>

