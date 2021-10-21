@include('include/header')
@include('include/sidebar');
<link rel="stylesheet" type="text/css" href="<?php echo URL::to('/'); ?>/public/assets/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo URL::to('/'); ?>/public/assets/pages/data-table/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo URL::to('/'); ?>/public/assets/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo URL('/');?>/public/assets/css/sweetalert.min.css">
<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="feather icon-inbox bg-c-blue"></i>
                    <div class="d-inline">
                        <h5>Category List</h5>

                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="<?php echo URL::to('/'); ?>/dashboard"><i class="feather icon-home"></i></a>
                        </li>

                        <li class="breadcrumb-item"><a href="#!">Category List</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- [ breadcrumb ] end -->
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-body start -->
                <div class="page-body">
                    <!-- DOM/Jquery table start -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Category List</h5>
                            <a href="<?php echo URL::to('/'); ?>/category-add" class="btn btn-primary" style="float:right"><i class="fa fa-plus"></i>Add New Category</a>
                        </div>
                        <div class="card-block">

                            <div class="table-responsive dt-responsive">
                                <table id="personnelTable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Category Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- DOM/Jquery table end -->
                    <!-- Column Rendering table start -->
                </div>
            </div>
        </div>
    </div>
    @include('include/footer');
    <script src="<?php echo URL::to('/'); ?>/public/assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo URL::to('/'); ?>/public/assets/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js" ></script>
    <script src="<?php echo URL::to('/'); ?>/public/assets/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo URL::to('/'); ?>/public/assets/pages/data-table/js/data-table-custom.js" ></script>
<!--    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>-->
    <script src="<?php echo URL('/');?>/public/assets/js/sweetalert.min.js"></script>
    <script>
        $(document).ready(function (e) {
            $('#personnelTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ URL::to("/category_ajax") }}',
                },
                columns: [
                    {data: 'No', name: 'No'},
                    {data: 'category_name', name: 'category_name'},
                    {data: 'Action', name: 'Action', orderable: false, searchable: false}
                ]
            })
        })

        function deleteswal(id) {
            swal({
                title: 'Are you sure?',
			  text: "delete the detail permanently!",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Yes'
            },function (isConfirm) {
				if (!isConfirm) return;
                                window.location.href="<?php echo URL::to('/');?>/category-delete?id=" + id;
			})
        }
    </script>
