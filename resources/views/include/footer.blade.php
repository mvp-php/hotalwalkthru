</div>
</div>
</div>
</div>

<script  src="<?php echo URL::to('/'); ?>/public/assets/jquery.min.js"></script>
<script type="52ec783e3373f7c41dfb7500-text/javascript" src="<?php echo URL::to('/');?>/public/assets/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="52ec783e3373f7c41dfb7500-text/javascript" src="<?php echo URL::to('/');?>/public/assets/bower_components/popper.js/js/popper.min.js"></script>
<script type="52ec783e3373f7c41dfb7500-text/javascript" src="<?php echo URL::to('/');?>/public/assets/bower_components/bootstrap/js/bootstrap.min.js"></script>
<!-- waves js -->
<script src="<?php echo URL::to('/');?>/public/assets/pages/waves/js/waves.min.js" type="52ec783e3373f7c41dfb7500-text/javascript"></script>
<!-- jquery slimscroll js -->
<script type="52ec783e3373f7c41dfb7500-text/javascript" src="<?php echo URL::to('/');?>/public/assets/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<script src="<?php echo URL::to('/');?>/public/assets/js/pcoded.min.js" type="52ec783e3373f7c41dfb7500-text/javascript"></script>
<script src="<?php echo URL::to('/');?>/public/assets/js/vertical/vertical-layout.min.js" type="52ec783e3373f7c41dfb7500-text/javascript"></script>
<script src="<?php echo URL::to('/');?>/public/assets/js/bootstrap-growl.min.js"></script><!---Swiper--><script src="<?php echo URL::to('/');?>/public/assets/bower_components/swiper/js/swiper.min.js" type="52ec783e3373f7c41dfb7500-text/javascript"></script><script src="<?php echo URL::to('/');?>/public/assets/assets/js/pcoded.min.js" type="47406f74b86028ad422cdcfe-text/javascript"></script><script src="<?php echo URL::to('/');?>/public/assets/assets/js/vertical/vertical-layout.min.js" type="47406f74b86028ad422cdcfe-text/javascript"></script><script src="<?php echo URL::to('/');?>/public/assets/assets/js/jquery.mCustomScrollbar.concat.min.js" type="47406f74b86028ad422cdcfe-text/javascript"></script><script src="<?php echo URL::to('/');?>/public/assets/js/swiper-custom.js"></script>
<!-- Custom js -->
<script type="52ec783e3373f7c41dfb7500-text/javascript" src="<?php echo URL::to('/');?>/public/assets/js/script.min.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13" type="52ec783e3373f7c41dfb7500-text/javascript"></script>
<script type="52ec783e3373f7c41dfb7500-text/javascript">
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');
</script>
<script src="<?php echo URL::to('/'); ?>/public/assets/rocket-loader.min.js" data-cf-settings="52ec783e3373f7c41dfb7500-|49" defer=""></script>
 <script>
        function notify(message, type){
        $.growl({
            message: message
        },{
            type: type,
            allow_dismiss: false,
            label: 'Cancel',
            className: 'btn-xs btn-inverse',
            placement: {
                from: 'bottom',
                align: 'right'
            },
            delay: 2500,
            animate: {
                    enter: 'animated fadeInRight',
                    exit: 'animated fadeOutRight'
            },
            offset: {
                x: 30,
                y: 30
            }
        });
    };

   @if(Session::has('success'))   
        notify("{{ Session::get('success') }}", 'inverse');
     @endif
      @if(Session::has('error'))   
        notify("{{ Session::get('error') }}", 'inverse');
     @endif
        </script>

</body>


<!-- Mirrored from colorlib.com/polygon/admindek/default/sample-page.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 15 Jun 2019 05:40:54 GMT -->
</html>
