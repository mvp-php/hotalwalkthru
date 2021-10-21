@include('include/header')
@include('include/sidebar')
<script src="<?php echo URL::to('/'); ?>/public/assets/js/ckeditor.js"></script>
<!-- [ navigation menu ] end -->
<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="feather icon-clipboard bg-c-blue"></i>
                    <div class="d-inline">
                        <h5>Edit Subscription</h5>
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
                        <li class="breadcrumb-item"><a href="<?php echo URL::to('/'); ?>/subscription">Subscription List</a>
                        </li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Edit</a>
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
                                    <h5>Edit Subscription</h5>

                                </div>
                                <div class="card-block">
                                    <form id="main_id" method="post" action="<?php echo URL::to('/'); ?>/subscriptionUpdate" novalidate enctype="multipart/form-data">
                                        <input type='hidden' name='_token' value='<?php echo csrf_token(); ?>'>
										<input type="hidden" name="id" value="<?php echo $subscription->id;?>">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Plan Name<span style="color:red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="plan_name" id="plan_id" placeholder="Enter plan name" value="<?php echo $subscription->plan_name;?>">
                                                <span class="error" id='name_error'>{{$errors->subscription->first('plan_name')}}</span>
                                            </div>
                                        </div>
										<div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Duration<span style="color:red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="duration" id="duration_id" placeholder="Enter duration" value="<?php echo $subscription->duration;?>">
                                                <span class="error" id='duration_error'>{{$errors->subscription->first('duration')}}</span>
                                            </div>
                                        </div>
										<div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Price<span style="color:red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="price" id="price_id" placeholder="Enter price" value="<?php echo $subscription->price;?>">
                                                <span class="error" id='price_error'>{{$errors->subscription->first('price')}}</span>
                                            </div>
                                        </div>
										<div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Description<span style="color:red">*</span></label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control editor1" name="description" id="description_id" placeholder="Enter description" value=""><?php echo $subscription->plan_description;?></textarea>
                                            
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2"></label>
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-primary m-b-0">Submit</button>
												<a href="subscription" class="btn btn-inverse m-b-0">Cancel</a>
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
CKEDITOR.replace('editor1');
</script>
<script>
    $('#main_id').submit(function (e) {
        var plan_id = $('#plan_id').val();
		 var duration_id = $('#duration_id').val();
		 var price_id = $('#price_id').val();
        var cnt = 0;
        $('#name_error').html(" ");
		$('#duration_error').html(" ");
		$('#price_error').html(" ");
        
        if (plan_id.trim() == '') {
            $('#name_error').html("Plan name is required.");
            cnt = 1;
        }
		if (duration_id.trim() == '') {
            $('#duration_error').html("Duration is required.");
            cnt = 1;
        }

		if (price_id.trim() == '') {
			$('#price_error').html("Price is required.");
			cnt = 1;
		}        
		if (cnt == 1) {
            return false;
        } else {
            return true;
        }

    })

</script>