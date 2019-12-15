@extends('layouts.base')

@section('custom-styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/enquiry"><i class="ni ni-ruler-pencil"></i></a></li>
    <li class="breadcrumb-item"><a href="/enquiry">Enquiry</a></li>
    <li class="breadcrumb-item active" aria-current="page">Manage Enquiry</li>
@endsection

@section('actions')
    <a href="/enquiry/create" class="btn btn-sm btn-neutral">New</a>
@endsection

@section('page-content')

    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <h3 class="mb-0">Enquiry</h3>
                    <p class="text-sm mb-0">
                        Manage your Enquires here.....
                    </p>
                </div>
                <div class="table-responsive py-4">
                    <table class="table table-flush" id="enquiry-list">
                        <thead class="thead-light">
                        <tr>
                            <th> # </th>
                            <th> Name </th>
                            <th> Address </th>
                            <th> Number </th>
                            <th> College </th>
                            <th> Year </th>
                            <th> Branch </th>
                            <th> Comments </th>
                            <th> View </th>
                            <th> Edit </th>
                            <th> Delete </th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th> # </th>
                            <th> Name </th>
                            <th> Address </th>
                            <th> Number </th>
                            <th> College </th>
                            <th> Year </th>
                            <th> Branch </th>
                            <th> Comments </th>
                            <th> View </th>
                            <th> Edit </th>
                            <th> Delete </th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{--MODAL SECTION--}}
    <!-- DELETE MODAL -->

    <div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">
        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Delete Enquiry</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form  id="delete_form" method="POST" action="/enquiry">
                    <div class="modal-body">

                        @method('DELETE')
                        @csrf
                        <div class="form-body">
                            <!-- START OF MODAL BODY -->
                            <div class="container">
                                <label>Are you sure you want to delete Enquiry ?</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default  ml-auto" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section ('custom-script')
    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>

    <script>
        let enquiryTable = $('#enquiry-list');

        enquiryTable.DataTable({
            processing: true,
            serverSide: true,
            ajax: '/enquiry/get-enquiry',
            columns: [
                {data: 'id'},
                {data: 'student_name'},
                {data: 'student_address'},
                {data: 'student_number'},
                {data: 'student_college'},
                {data: 'student_year'},
                {data: 'student_branch'},
                {data: 'comments'},
                {data : 'view'},
                {data: 'edit'},
                {data: 'delete'}
            ],
            language: {paginate: {previous: "<i class='fa fa-angle-left'>", next: "<i class='fa fa-angle-right'>"}}
        });

        enquiryTable.on('click', '.delete', function() {

            $id = $(this).attr("data-enquiryid");
            console.log($id);
            $('#delete_form').attr('action', '/enquiry/' + $id);
        });

        enquiryTable.on('click', '.edit', function () {
            $id = $(this).data("data-enquiryid");
            window.location.pathname = '/enquiry/' + $id + '/edit';
        });

    </script>

    @if(session()->has('type'))
        <script>
            $.notify({
                // options
                title: '<h4 style="color:white">{{ session('title') }}</h4>',
                message: '{{ session('message') }}',
            },{
                // settings
                type: '{{ session('type') }}',
                allow_dismiss: true,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: 20,
                spacing: 10,
                z_index: 1031,
                delay: 3000,
                timer: 1000,
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                }
            });
        </script>
    @endif
@endsection
