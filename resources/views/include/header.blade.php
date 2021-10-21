<?php $test = Request::segment(1); ?>
<!DOCTYPE html>
<html lang="en">


    <!-- Mirrored from colorlib.com/polygon/admindek/default/sample-page.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 15 Jun 2019 05:40:54 GMT -->
    <!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
    <head>
        <title>{{ config('app.name', 'Laravel') }} | Admin Template</title>
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="Admindek Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
        <meta name="keywords" content="flat ui, admin Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
        <meta name="author" content="colorlib" />
        <!-- Favicon icon -->
        <link rel="icon" href="https://colorlib.com/polygon/admindek/files/assets/images/favicon.ico" type="image/x-icon">
        <!-- Google font-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet"><link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">
        <!-- Required Fremwork -->
        <link rel="stylesheet" type="text/css" href="<?php echo URL::to('/'); ?>/public/assets/bower_components/bootstrap/css/bootstrap.min.css">
        <!-- waves.css -->
        <link rel="stylesheet" href="<?php echo URL::to('/'); ?>/public/assets/pages/waves/css/waves.min.css" type="text/css" media="all">
        <!-- feather icon -->
        <link rel="stylesheet" type="text/css" href="<?php echo URL::to('/'); ?>/public/assets/icon/feather/css/feather.css">
		 <!--swiper -->
		<link rel="stylesheet" type="text/css" href="<?php echo URL::to('/');?>/public/assets/bower_components/swiper/css/swiper.min.css">
        <!-- Style.css -->
        <link rel="stylesheet" type="text/css" href="<?php echo URL::to('/'); ?>/public/assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo URL::to('/');?>/public/assets/css/custom.css">
        
        <!-- Font Awesome -->
       
        <link rel="stylesheet" type="text/css" href="<?php echo URL::to('/');?>/public/assets/icon/font-awesome/css/font-awesome.min.css">
           <link rel="stylesheet" type="text/css" href="<?php echo URL::to('/'); ?>/public/assets/pages/notification/notification.css">
           <link rel="stylesheet" type="text/css" href="<?php echo URL::to('/'); ?>/public/assets/bower_components/animate.css/css/animate.css">
           <link rel="stylesheet" type="text/css" href="<?php echo URL::to('/'); ?>/public/assets/icon/icofont/css/icofont.css">
    </head>

    <body>
        <!-- [ Pre-loader ] start -->
        <div class="loader-bg">
            <div class="loader-bar"></div>
        </div>
        <!-- [ Pre-loader ] end -->
        <div id="pcoded" class="pcoded">
            <div class="pcoded-overlay-box"></div>
            <div class="pcoded-container navbar-wrapper">
                <!-- [ Header ] start -->
                <nav class="navbar header-navbar pcoded-header">
                    <div class="navbar-wrapper">
                        <div class="navbar-logo">
                            <a href="<?php echo URL::to('/');?>/dashboard">
                               {{ config('app.name', 'Laravel') }}
							   </a>
                            <a class="mobile-menu" id="mobile-collapse" href="#!">
                                <i class="feather icon-menu icon-toggle-right"></i>
                            </a>
                            <a class="mobile-options waves-effect waves-light">
                                <i class="feather icon-more-horizontal"></i>
                            </a>
                        </div>
                        <div class="navbar-container container-fluid">
                            
                            <ul class="nav-right">

                                <li class="user-profile header-notification">

                                    <div class="dropdown-primary dropdown">
                                        <div class="dropdown-toggle" data-toggle="dropdown">
                                            <?php if(isset($Session->profileImg) && $Session->profileImg !=''){?>
                                            <img src="<?php echo URL::to('/');?>/public/upload/<?php echo $Session->profileImg;?>" class="img-radius" alt="User-Profile-Image">
                                            
                                            <?php } else { ?>
                                            <img src="<?php echo URL::to('/');?>/public/assets/images/avatar-4.jpg" class="img-radius" alt="User-Profile-Image">
                                            <?php } ?>
                                            <span><?php if((isset($Session->first_name) && $Session->first_name!='') ||(isset($Session->last_name) && $Session->last_name!='')){ echo $Session->first_name.' '.$Session->last_name;} ?></span>
                                            <i class="feather icon-chevron-down"></i>
                                        </div>
                                        <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                          
                                            <li>
                                                <a href="<?php echo URL::to('/');?>/profile">
                                                    <i class="feather icon-user"></i> Profile

                                                </a>
                                            </li>
                                            
                                            <li>
                                                <a href="<?php echo URL::to('/');?>/change_password">
                                                    <i class="feather icon-lock"></i> Change Password

                                                </a>
                                            </li>
                                            <li>
											
                                                <a href="<?php echo URL::to('/');?>/logout">
                                                    <i class="feather icon-log-out"></i> Logout

                                                </a>

                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- [ Header ] end -->

                <div class="pcoded-main-container">
                    <div class="pcoded-wrapper">
