
<script type="text/javascript">
    (function(){
        "use strict";
        var canvasHeight = $(window).height();
        var navHeight = $('.navbar.navbar-default').height();
        //'nav' this should be replaced with class name which your navigation has in original
        var footerHeight = $('.panel-footer').height();
        var container = $('.container').height();
        var pageHeading = $('.page-heading').height();
        var addHeight = canvasHeight - (navHeight + footerHeight + container);
        $(document).ready(function (){
            $('.contentHeight').css('min-height', addHeight)
        });
    })();
</script>
