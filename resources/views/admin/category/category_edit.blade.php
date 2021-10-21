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
                        <h5>Edit Category</h5>
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
                        <li class="breadcrumb-item"><a href="<?php echo URL::to('/'); ?>/category">Category List</a>
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
                                    <h5>Edit Category</h5>

                                </div>

                                <div class="card-block">
                                    <form id="main_id" method="post" action="<?php echo URL::to('/'); ?>/category-update" novalidate enctype="multipart/form-data">
                                        <input type="hidden" name='id' value="<?php echo $category_data->id; ?>">
                                        <input type='hidden' name='_token' value='<?php echo csrf_token(); ?>'>


                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Category Name<span style="color:red">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="category_name" id="category_id" placeholder="Enter Category Name" value="<?php echo $category_data->category_name ; ?>">
                                                <span class="error" id='category_error'>{{$errors->Category->first('category_name')}}</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2"></label>
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-primary m-b-0">Submit</button>
												<a href="category" class="btn btn-inverse m-b-0">Cancel</a>
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
        var category_id = $('#category_id').val();
        var cnt = 0;
        $('#category_error').html("");

        if (category_id.trim() == '') {
            $('#category_error').html("Category Name field is required.");
            cnt = 1;
        }
        if (cnt == 1) {
            return false;
        } else {
            return true;
        }

    })

</script>