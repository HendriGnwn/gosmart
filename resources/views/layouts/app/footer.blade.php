<div class="container-fluid container-fixed-lg footer">
    <div class="copyright sm-text-center">
        <p class="small no-margin pull-left sm-pull-reset"><span class="hint-text">Copyright &copy; 2017</span> <span class="font-montserrat">ATC</span>. <span class="hint-text">All rights reserved.</span> <span class="sm-block"><a class="m-l-10 m-r-10" href="javascript:;;" onclick="PopupCenter('http://private-smart.com','xtf','900','500');">Terms of use</a> | <a class="m-l-10"  href="javascript:;;" onclick="PopupCenter('http://private-smart.com','xtf','900','500');>Privacy Policy</a></span></p>
        <div class="clearfix">
        </div>
    </div>
</div>

@push('script')
<script>
function PopupCenter(url, title, w, h) {
    // Fixes dual-screen position                         Most browsers      Firefox
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

    var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
    var top = ((height / 2) - (h / 2)) + dualScreenTop;
    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

    // Puts focus on the newWindow
    if (window.focus) {
        newWindow.focus();
    }
}

</script>
@endpush