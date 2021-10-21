<!DOCTYPE html>
<html lang="en" >
    <!-- begin::Head -->
    <head>
        <meta charset="utf-8" />
        <title>
            Hotel
        </title>
        <meta name="description" content="Latest updates and statistic charts">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">	
        <!--begin::Web font -->
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<style>
		 .m-login__signup{display:block !important;}
			.login-mail{box-shadow: 0 0 10px rgba(0, 0, 0, .1);
    padding: 10px 15px;
    text-align: center;}
	.login-mail .m-login__desc{    font-size: 19px;
    margin-bottom: 10px;
    color: #73af55 !important;
    font-weight: 500;}
		</style>
        <script>
            WebFont.load({
                google: {"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]},
                active: function () {
                    sessionStorage.fonts = true;
                }
            });
        </script>
        <!--end::Web font -->
        <!--begin::Base Styles -->
        <link href="<?php echo URL::asset(''); ?>/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL::asset(''); ?>/assets/theme/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
        <!--end::Base Styles -->
        <link rel="shortcut icon" href="<?php echo URL::asset('');?>assets/images/favicon.png" />
    </head>
    <!-- end::Head -->
    <!-- end::Body -->
    <body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--singin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url(<?php echo URL::asset(''); ?>/assets/app/media/img/bg/bg-3.jpg);">
                <div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
                    <div class="m-login__container">
                       
               
                        <div class="m-login__signup login-mail">
                            <div class="m-login__head">                                
                                <div class="success">
								   <img src="<?php echo URL::asset(''); ?>/assets/theme/default/base/success.gif"/>
								</div>
                                <div class="m-login__desc">                                   
                                   Your account has been successfully activated
                                </div>                   
							</div>
                                                 
                        </div>
                      
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: Page -->
        <!--begin::Base Scripts -->
        <script src="<?php echo URL::asset(''); ?>/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
        <script src="<?php echo URL::asset(''); ?>/assets/theme/default/base/scripts.bundle.js" type="text/javascript"></script>
        <!--end::Base Scripts -->
        <!--begin::Page Snippets -->
        <script src="<?php echo URL::asset(''); ?>/assets/snippets/pages/user/login.js" type="text/javascript"></script>
        <!--end::Page Snippets -->
    </body>
    <!-- end::Body -->
</html>