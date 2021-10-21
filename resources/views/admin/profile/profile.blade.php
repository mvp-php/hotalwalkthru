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
                                    <h5>Profile</h5>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class=" breadcrumb breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo URL::to('/');?>/dashboard"><i class="feather icon-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">Profile</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] end -->

                <div class="pcoded-inner-content">
                  <div class="main-body">
                    
					@if(Session::has('error') )                          
					   <div class="alert alert-danger"> 
						   <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>{{ Session::get('error') }}    
					   </div>                            
					@endif
                    <div class="page-wrapper">
                      <!-- Page body start -->
                      <div class="page-body">
                        <div class="row">
                          <div class="col-sm-12">
                          
                            <div class="card">
                              <div class="card-header">
                                <h5>Edit Profile</h5>
                                <span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>
                              </div>

                              <div class="card-block">
                                <form id="main_id" method="post" action="<?php echo URL::to('/');?>/updateProfile" novalidate enctype="multipart/form-data">
                                    <input type='hidden' name='_token' value='<?php echo csrf_token();?>'>
                                    <input type="hidden" name="id" value="<?php echo $profileEdit->id;?>">
                                    <input type="hidden" name="old_img" value="<?php echo $profileEdit->profileImg;?>">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">First Name <span style="color:red">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="first_name" id="name_id" placeholder="Enter first name" value="<?php echo $profileEdit->first_name;?>">
                                            <span class="error" id='first_error'>{{$errors->login->first('first_name')}}</span>
                                        </div>
                                    </div>
                                
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Last Name <span style="color:red">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="last_name" id="last_name_id" placeholder="Enter last name" value="<?php echo $profileEdit->last_name;?>">
                                            <span class="error" id='last_error'>{{$errors->login->first('last_name')}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Email Address <span style="color:red">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="email" id="email_id" placeholder="Enter email address" value="<?php echo $profileEdit->email;?>">
                                            <span class="error" id='email_error'>{{$errors->login->first('email')}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Mobile No <span style="color:red">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="mobile" id="mobile_id" placeholder="Enter mobile" value="<?php echo $profileEdit->mobile;?>">
                                            <span class="error" id='mobile_error'>{{$errors->login->first('mobile')}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Profile Pic</label>
                                        <div class="col-sm-10">
                                            
                                                <input type="file" class="form-control" name="file_img">
                                                <span class="error" id='img_error'></span>
                                            </div>
                                        
                                    </div>
                                   <div class="form-group row">
                                     <label class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-10">
                                           <?php if(isset($profileEdit->profileImg) &&$profileEdit->profileImg !='' ){ 
                                            ?>
                                        <img src="<?php echo URL::to('/');?>/public/upload/<?php echo $profileEdit->profileImg;?>" width="200">
                                        <?php }else{?>
                                        <img src="<?php echo URL::to('/');?>/public/upload/avatar.png" width="200">
                                        <?php } ?>
                                    </div>
                                   </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Address</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="address" id="address_id" placeholder="Enter Address"><?php echo $profileEdit->address;?></textarea>
                                           
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
    $('#main_id').submit(function(e){
        var fname = $('#name_id').val();
        var lname = $('#last_name_id').val();
        var emailid = $('#email_id').val();
        var mobile = $('#mobile_id').val();
         var check_email = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
         var numbers = /^[0-9]+$/;
         
        var cnt =0;
        $('#first_error').html(" ");
        $('#last_error').html(" ");
        $('#email_error').html(" ");
        $('#mobile_error').html(" ");
        
        if(fname.trim() ==''){
            $('#first_error').html("Please enter first name.");
            cnt =1;
        }
        if(fname !=''){
            if (!/^[a-zA-Z\s]*$/g.test(fname)) {
                    $('#first_error').html("Only Character.");
                    cnt =1;
            }
        }
       
         if(lname.trim() ==''){
            $('#last_error').html("Please enter last name.");
            cnt =1;
        }
        if(lname !=''){
            if (!/^[a-zA-Z\s]*$/g.test(lname)) {
                    $('#last_error').html("Only Character.");
                    cnt =1;
            }
        }
        
        if (emailid == '') {
            $('#email_error').html("Please enter email address");
            cnt = 1;
        }
        
        if (emailid != '') {
            var token = "{{ csrf_token() }}";
            if (emailid.match(check_email)) {
                $.ajax({
                    async: false,
                    global: false,
                    url: "<?php echo URL::to('/'); ?>/check_mail",
                    type: "POST",
                    data: {email: emailid,id:<?php echo $profileEdit->id;?> ,_token: token},
                    success: function (response) {
                        if (response == 1) {

                        } else {
                            $('#email_error').html("Email address already exist.");
                            cnt = 1;
                        }
                    }
                });
            } else {
                $('#email_error').html("Please enter valid email address");
                cnt = 1;
            }
        }
        if (mobile == '') {
            $('#mobile_error').html("Please enter mobile number");
            cnt = 1;
        }
        if(mobile !=''){
            if(mobile.match(numbers)){		
                if(mobile.length < 10 || mobile.length >10){
                        $("#mobile_error").html("Please only 10 digit allowed");
                                cnt =1;
                }else{
                }
            }else{
            $('#mobile_error').html("Only number allowed");
            cnt =1;
            }
        
        }
     
        if(cnt ==1){
             return false;
        }else{
            return true;
        }
        
    })
    
    </script>