<!DOCTYPE html>

<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

    <title></title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="description" content="Admindek Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
      <meta name="keywords" content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
      <meta name="author" content="colorlib" />
      <!-- Favicon icon -->
      <link rel="icon" href="https://colorlib.com/polygon/admindek/files/assets/images/favicon.ico" type="image/x-icon">
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
  <!-- Pre-loader start -->
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
  <!-- Pre-loader end -->
    <section class="login-block">
        <!-- Container-fluid starts -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    
					<form  class="md-float-material form-material"  id="forgot_id" method="POST" action="{{ route('password.email') }}">

                        <input type="hidden" name="_token" value="<?php echo csrf_token();?>">

                        <div class="text-center">

						{{config('app.name', 'Laravel')}}

                        </div>

                        <div class="auth-box card">

                            <div class="card-block">

                                <div class="row m-b-20">

                                    <div class="col-md-12">

                                        <h3 class="text-center txt-primary">Recover your password</h3>

                                    </div>

                                    <div class="login-message text-danger">

											<div class="card-body">
												@if (session('status'))
													<div class="alert alert-success" role="alert">
														{{ session('status') }}
													</div>
												@endif

												
											</div>

                                            <span class="text-danger" id="usernameerror"><?php echo $errors->forgot_password->first('username'); ?></span><br/>

                                        </div>

                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="username" id="user_id" class="form-control">
                                        <span class="form-bar"></span>
                                        <label class="float-label">Your Email Address</label>
                                        <span class="error" id="user_error">{{$errors->forgot_password->first('username')}}</span>
                                </div>
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                       <input type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20" value="forgot Password">
                                    </div>

                                </div>

                                <p class="f-w-600 text-right">Back to <a href="<?php echo URL::to('/'); ?>/login">Login.</a></p>

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

<!-- Required Jquery -->

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
$('#forgot_id').submit(function (e) {
    var uname = $('#user_id').val();
    var check_email = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var cnt = 0;
    $('#user_error').html("");
    if (uname == '') {
        $('#user_error').html(" Please enter email address.");
        cnt = 1;
    }
    if (uname != '') {
        if (uname.match(check_email)) {
            cnt = 0;
        } else {
            $('#user_error').html(" Please enter valid email address.");
            cnt = 1;
        }
    }
    if (cnt == 1) {
        return false;
    } else {
        return true;
    }
});
        </script>
</html>