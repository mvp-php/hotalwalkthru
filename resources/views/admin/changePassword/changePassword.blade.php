@include('include/header')
@include('include/sidebar')

<!-- [ navigation menu ] end -->
<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="feather icon-clipboard bg-c-blue"></i>
                    <div class="d-inline">
                        <h5>Change Password</h5>
                        <span></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="<?php echo URL::to('/'); ?>/dashboard"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Change Password</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="pcoded-inner-content">
        <div class="main-body">

            <div class="page-wrapper">
                <!-- Page body start -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="card">
                                <div class="card-header">
                                    <h5>Change Password</h5>
                                    <span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>
                                </div>
                              
                               
                                @if(Session::has('error') )                          
                                <div class="alert alert-danger"> 
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>{{ Session::get('error') }}    
                                </div>                            
                                @endif
                                <div class="card-block">
                                    <form id="main_id" method="post" action="<?php echo URL::to('/'); ?>/updatePassword" novalidate enctype="multipart/form-data">
                                        <input type='hidden' name='_token' value='<?php echo csrf_token(); ?>'>


                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Old Password <span style="color:red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" name="old_password" id="name_id" placeholder="Enter Old Password" >
                                                <span class="error" id='first_error'>{{$errors->login->first('old_password')}}</span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">New Password <span style="color:red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" name="new_password" id="last_name_id" placeholder="Enter new password" value="">
                                                <span class="error" id='last_error'>{{$errors->login->first('new_password')}}</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Confirm Password <span style="color:red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" name="confirm_password" id="email_id" placeholder="Enter confirm password" value="">
                                                <span class="error" id='email_error'>{{$errors->login->first('confirm_password')}}</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2"></label>
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-primary m-b-0">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Page body end -->
            </div>
        </div>
    </div>
</div>
<!-- Main-body end -->
<div id="styleSelector">

</div>
</div>
</div>

@include('include/footer')
<script>
    $('#main_id').submit(function (e) {
        var oldpassword = $('#name_id').val();
        var newpassword = $('#last_name_id').val();
        var confirmpass = $('#email_id').val();


        var cnt = 0;
        $('#first_error').html(" ");
        $('#last_error').html(" ");
        $('#email_error').html(" ");
        $('#mobile_error').html(" ");

        if (oldpassword.trim() == '') {
            $('#first_error').html("Please enter old password.");
            cnt = 1;
        }

        if (oldpassword != '') {
            
                $.ajax({
                    async: false,
                    global: false,
                    url: "<?php echo URL::to('/'); ?>/checkoldpassword",
                    type: "POST",
                    data: {old_password: oldpassword, id:<?php echo $password_changed->id; ?>, _token: "<?php echo csrf_token(); ?>"},
                    success: function (response) {
                        if (response == 1) {
                        } else {
                            $('#first_error').html("Old password does not match.");
                            cnt = 1;
                        }
                    }
                });
            
        }

        if (newpassword.trim() == '') {
            $('#last_error').html("Please enter new password.");
            cnt = 1;
        }
        if (newpassword != '') {
            if (newpassword.length < 6) {
                $('#last_error').html("Password atleast six character allowed.");
                cnt = 1;
            }
        }
        if (confirmpass.trim() == '') {
            $('#email_error').html("Please enter confirm password");
            cnt = 1;
        }
        if (newpassword != confirmpass) {
            $('#email_error').html("Password and confirm password does not match.");
            cnt = 1;
        }


        if (cnt == 1) {
            return false;
        } else {
            return true;
        }

    })

</script>