@extends('layouts.index')
@section('content')
    @push('css')
        <style type="text/css" class="init">
            div.container {
                max-width: 1200px
            }
        </style>
    @endpush
    <div class="container-xl px-4 mt-n10 ">
        <div class="card">
            <div class="card-header">
                <a href="#" type="button" data-bs-toggle="modal" data-bs-target="#new"
                    class="btn btn-primary fw-bold text-md">+ New</a>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="new" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <form class="save" method="POST" enctype="multipart/form-data" action="{{ url('users') }}">
                        @csrf
                        @method('POST')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="new">Tambah</h5>
                                <button class="btn-close" type="button" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row form-group">
                                    <div class="col-6 mb-3">
                                        <label for="">Name</label>
                                        <input type="text" class="form-control" value="" name="name">
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="">Email</label>
                                        <input type="email" class="form-control" value="" name="email">
                                    </div>
                                    <div class="col-12 mb-3">
                                        @foreach ($roles as $role)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="{{ $role->name }}"
                                                    id="{{ $role->name }}" name="roles[]">
                                                <label class="form-check-label" for="{{ $role->name }}">
                                                    {{ $role->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-warning" type="button" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-primary saveButton" type="submit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-5">
                    <div class="col-12 mb-3">
                    </div>
                    <div class="col-12">
                        <table id="example" class="table display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th class="text-center" scope="col">Name</th>
                                    <th class="text-center" scope="col">Email</th>
                                    <th class="text-center" scope="col">Roles</th>
                                    <th class="text-center" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    @push('script')
        <script>
            $(document).find('.save').on('submit', function(event) {
                event.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var data = new FormData(this);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.saveButton').prop('disabled', true);
                        $('.saveButton').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    success: function(data) {
                        $('#example').DataTable().ajax.reload();
                        $('#new').modal('hide');
                        // kosongkan form
                        form[0].reset();
                        toastr.success(data.message, 'Success', {
                            timeOut: 3000,
                            closeButton: true,
                            progressBar: true,
                        })
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        let response = xhr.responseJSON;
                        toastr.error(response.message, 'Error', {
                            timeOut: 3000,
                            closeButton: true,
                            progressBar: true
                        });
                    },
                    complete: function() {
                        $('.saveButton').prop('disabled', false);
                        $('.saveButton').html('Save');
                    },
                });
            })


            $(document).on('submit', '.update', function(event) {
                event.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var data = new FormData(this);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('.updateButton').prop('disabled', true);
                        $('.updateButton').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    success: function(data) {
                        $('#example').DataTable().ajax.reload();
                        $('.closeModalUpdate').click();
                        // kosongkan form
                        form[0].reset();
                        toastr.success(data.message, 'Success', {
                            timeOut: 3000,
                            closeButton: true,
                            progressBar: true,
                        })
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        let response = xhr.responseJSON;
                        toastr.error(response.message, 'Error', {
                            timeOut: 3000,
                            closeButton: true,
                            progressBar: true
                        });
                    },
                    complete: function() {
                        $('.updateButton').prop('disabled', false);
                        $('.updateButton').html('Save');
                    },
                });
            })

            $(document).on('click', '.delete', function(event) {
                event.preventDefault();
                var url = $(this).attr('href');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0464f4',
                    cancelButtonColor: '#f8a404',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'GET',
                            dataType: 'json',
                            beforeSend: function() {
                                $('.delete').prop('disabled', true);
                                $('.delete').html('<i class="fa fa-spin fa-spinner"></i>');
                            },
                            success: function(data) {
                                $('#example').DataTable().ajax.reload();
                                $('.closeModalUpdate').click();
                                toastr.success(data.message, 'Success', {
                                    timeOut: 3000,
                                    closeButton: true,
                                    progressBar: true,
                                })
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                let response = xhr.responseJSON;
                                toastr.error(response.message, 'Error', {
                                    timeOut: 3000,
                                    closeButton: true,
                                    progressBar: true
                                });
                            },
                            complete: function() {
                                $('.delete').prop('disabled', false);
                                $('.delete').html('Delete');
                            },
                        });
                    }
                })
            })

            $(document).on('click', '.reset-password', function(event) {
                event.preventDefault();
                var url = $(this).attr('href');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0464f4',
                    cancelButtonColor: '#f8a404',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'GET',
                            dataType: 'json',
                            beforeSend: function() {
                                $('.reset-password').prop('disabled', true);
                                $('.reset-password').html('<i class="fa fa-spin fa-spinner"></i>');
                            },
                            success: function(data) {
                                $('#example').DataTable().ajax.reload();
                                $('.closeModalUpdate').click();
                                toastr.success(data.message, 'Success', {
                                    timeOut: 3000,
                                    closeButton: true,
                                    progressBar: true,
                                })
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                let response = xhr.responseJSON;
                                toastr.error(response.message, 'Error', {
                                    timeOut: 3000,
                                    closeButton: true,
                                    progressBar: true
                                });
                            },
                            complete: function() {
                                $('.reset-password').prop('disabled', false);
                                $('.reset-password').html('Reset Password');
                            },
                        });
                    }
                })
            })

            $('#example').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                fixedHeader: true,
                scrollX: true,
                scrollY: '50vh',
                paging: false,
                ajax: `{{ url('users') }}`,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false,
                        className: 'text-center fw-bold'
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        className: 'text-center',
                        data: 'email',
                        name: 'email',
                    },
                    {
                        className: 'text-center',
                        data: 'roles',
                        name: 'roles',
                    },
                    {
                        className: '',
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        orderable: false,
                    },
                ],
            });
        </script>
    @endpush
@endsection


{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu2"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Menu
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                    <li><a href="{{ url('permissions') }}" class="dropdown-item" type="button">Permissions</a></li>
                    <li><a href="{{ url('roles') }}" class="dropdown-item" type="button">Roles</a></li>
                    <li><a href="{{ url('users') }}" class="dropdown-item" type="button">Users</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h3>Roles</h3>
                        <hr>
                        <h6>Add Roles</h6>
                        <form method="POST" enctype="multipart/form-data" action="{{ url('roles') }}">
                            @csrf
                            @method('POST')
                            <div class="row form-group">
                                <div class="col-6 mb-3">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" value="" name="name">
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="">Guard</label>
                                    <input type="text" class="form-control" readonly value="web" name="guard">
                                </div>
                                <div class="col-12 mb-3">
                                    @foreach ($permissions as $permission)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                value="{{ $permission->name }}" id="{{ $permission->name }}"
                                                name="permissions[]">
                                            <label class="form-check-label" for="{{ $permission->name }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="col-3 mb-3">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr>

                    <div class="col-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Guard</th>
                                    <th scope="col">Permission</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td><a class="text-primary fw-bold"
                                                href="{{ url('roles/' . $role->id) }}">{{ $role->name }}</a>
                                        </td>
                                        <td>{{ $role->guard_name }}</td>
                                        <td>{{ implode(', ', $role->permissions->pluck('name')->toArray()) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>




</body>

</html> --}}
