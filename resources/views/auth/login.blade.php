<html lang="en">
<head>
    <title>Hotel Walk Thru</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="description" content="Admindek Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
      <meta name="keywords" content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
      <meta name="author" content="colorlib" />
      <!-- Favicon icon -->
      <link rel="icon" href="https://colorlib.com/polygon/admindek/files/assets/images/favicon.ico" type="image/x-icon">
      <!-- Google font-->     
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet"><link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">
      <!-- Required Fremwork -->
      <link rel="stylesheet" type="text/css" href="<?php echo URL::to('/');?>/public/assets/bower_components/bootstrap/css/bootstrap.min.css">
      <!-- waves.css -->
      <link rel="stylesheet" href="<?php echo URL::to('/');?>/public/assets/pages/waves/css/waves.min.css" type="text/css" media="all"><!-- feather icon --> <link rel="stylesheet" type="text/css" href="<?php echo URL::to('/');?>/public/assets/icon/feather/css/feather.css">
      <!-- themify-icons line icon -->
      <link rel="stylesheet" type="text/css" href="<?php echo URL::to('/');?>/public/assets/icon/themify-icons/themify-icons.css">
      <!-- ico font -->
      <link rel="stylesheet" type="text/css" href="<?php echo URL::to('/');?>/public/assets/icon/icofont/css/icofont.css">
      <!-- Font Awesome -->
      <link rel="stylesheet" type="text/css" href="<?php echo URL::to('/');?>/public/assets/icon/font-awesome/css/font-awesome.min.css">
      <!-- Style.css -->
      <link rel="stylesheet" type="text/css" href="<?php echo URL::to('/');?>/public/assets/css/style.css"><link rel="stylesheet" type="text/css" href="<?php echo URL::to('/');?>/public/assets/css/pages.css">
      <link rel="stylesheet" type="text/css" href="<?php echo URL::to('/');?>/public/assets/css/custom.css">
</head>
  <body themebg-pattern="theme1">
  <div class="theme-loader">
      <div class="loader-track">
          <div class="preloader-wrapper">
              <div class="spinner-layer spinner-blue">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
              <div class="spinner-layer spinner-red">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
              <div class="spinner-layer spinner-yellow">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
              <div class="spinner-layer spinner-green">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
          </div>
      </div>
  </div>
   <section class="login-block">
        <!-- Container-fluid starts -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->

					<form method="POST" class="md-float-material form-material" id="login_id" action="{{ route('login') }}">
                        @csrf
                        <input type="hidden" name="_token" value="<?php echo csrf_token();?>">

                        <div class="text-center">

                           <div id="logo"><a href="<?php echo URL::to('/');?>">Hotel Walk Thru</a></div>

                        </div>

                        <div class="auth-box card">

                            <div class="card-block">

                                <div class="row m-b-20">

                                    <div class="col-md-12">

                                        <h3 class="text-center txt-primary">Sign In</h3>
                                    </div>
                                    <div class="col-md-12">
                                      @if(Session::has('success'))
                                           <div class="alert alert-success alert-dismissible fade show" role="alert">                        
                                               <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>{{ Session::get('success') }}
                                           </div> 
                                            @endif
                                            @if(Session::has('error') )
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">                       
                                               <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>{{ Session::get('error') }}
                                           </div> 
                                            @endif
                                      </div>
                                    <div class="login-message text-danger">
                                            <span class="text-danger" id="usernameerror"><?php echo $errors->forgot_password->first('username'); ?></span><br/>
                                        </div>
                                </div>
								<div class="form-group form-primary">

									<input type="text" name="email" class="form-control" id="user_id">


                                    <span class="form-bar"></span>
                                    <label class="float-label">Email address</label>
                                    <span class="error" id="user_error">{{$errors->login->first('user_name')}}</span>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="password" name="password" class="form-control" id="pass_id">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Password</label>
                                    <span class="error" id="pass_error">{{$errors->login->first('user_name')}}</span>
                                </div>
                                <div class="row m-t-25 text-left">
                                    <div class="col-12">
                                        <div class="forgot-phone text-right float-right">
                                            <a href="{{route('password.request')}}" class="text-right f-w-600"> Forgot Password?</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <input type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20" value="Login">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                        <!-- end of form -->
                    </div>
                    <!-- Authentication card end -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>

<script  src="<?php echo URL::to('/');?>/public/assets/jquery.min.js"></script>

<script type="5908d7e627427ede8b9e8b45-text/javascript" src="<?php echo URL::to('/');?>/public/assets/bower_components/jquery-ui/js/jquery-ui.min.js"></script>

<script type="5908d7e627427ede8b9e8b45-text/javascript" src="<?php echo URL::to('/');?>/public/assets/bower_components/popper.js/js/popper.min.js"></script>

<script type="5908d7e627427ede8b9e8b45-text/javascript" src="<?php echo URL::to('/');?>/public/assets/bower_components/bootstrap/js/bootstrap.min.js"></script>

<!-- waves js -->

<script src="<?php echo URL::to('/');?>/public/assets/pages/waves/js/waves.min.js" type="5908d7e627427ede8b9e8b45-text/javascript"></script>

<!-- jquery slimscroll js -->

<script type="5908d7e627427ede8b9e8b45-text/javascript" src="<?php echo URL::to('/');?>/public/assets/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>

<!-- modernizr js -->

<script type="5908d7e627427ede8b9e8b45-text/javascript" src="<?php echo URL::to('/');?>/public/assets/bower_components/modernizr/js/modernizr.js"></script>

<script type="5908d7e627427ede8b9e8b45-text/javascript" src="<?php echo URL::to('/');?>/public/assets/bower_components/modernizr/js/css-scrollbars.js"></script>

<script type="5908d7e627427ede8b9e8b45-text/javascript" src="<?php echo URL::to('/');?>/public/assets/js/common-pages.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13" type="5908d7e627427ede8b9e8b45-text/javascript"></script>
<script type="5908d7e627427ede8b9e8b45-text/javascript">

  window.dataLayer = window.dataLayer || [];

  function gtag(){dataLayer.push(arguments);}

  gtag('js', new Date());



  gtag('config', 'UA-23581568-13');

</script>

<script src="<?php echo URL::to('/');?>/public/assets/rocket-loader.min.js" data-cf-settings="5908d7e627427ede8b9e8b45-|49" defer=""></script></body>
  <script>
      $('#login_id').submit(function(e){
          var uname = $('#user_id').val();
          var pass = $('#pass_id').val();
          var check_email = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
          var cnt =0;
          $('#user_error').html("");
          $('#pass_error').html("");
          if(uname ==''){
              $('#user_error').html(" Please enter email address.");
              cnt =1;
          }
          if(uname !=''){
              if (uname.match(check_email)) {
                  cnt =0;
              }else{
                   $('#user_error').html(" Please enter valid email address.");
              cnt =1;
              }
          }
          if(pass == ''){
               $('#pass_error').html(" Please enter password.");
                cnt =1; 
          }
          if(cnt ==1){
              return false;
          }else{
              return true;
          }
      });
  </script>

</body>
</html>