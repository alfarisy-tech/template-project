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
                                    <th class="text-center" scope="col">Guard</th>
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

    @foreach ($permissions as $data)
        <form method="POST" enctype="multipart/form-data" action="{{ url('permissions/' . $data->id) }}">
            @csrf
            @method('PUT')
            <!-- Modal -->
            <div class="modal fade" id="edit{{ $data->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="new">Tambah</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row form-group">
                                <div class="col-12 mb-3">
                                    <label for="name">Name</label>
                                    <input id="name" type="text" class="form-control" value="{{ $data->name }}"
                                        name="name">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="guard">Guard</label>
                                    <input id="guard" type="text" class="form-control" readonly value="web"
                                        name="guard">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer"><button class="btn btn-secondary" type="button"
                                data-bs-dismiss="modal">Tutup</button><button class="btn btn-primary"
                                type="submit">Simpan</button></div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach


    <form id="simpan" method="POST" enctype="multipart/form-data" action="{{ url('permissions') }}">
        @csrf
        @method('POST')
        <!-- Modal -->
        <div class="modal fade" id="new" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="new">Tambah</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-12 mb-3">
                                <label for="name">Name</label>
                                <input id="name" type="text" class="form-control" value="" name="name">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="guard">Guard</label>
                                <input id="guard" type="text" class="form-control" readonly value="web"
                                    name="guard">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"><button class="btn btn-secondary" type="button"
                            data-bs-dismiss="modal">Tutup</button><button class="btn btn-primary"
                            type="submit">Simpan</button></div>
                </div>
            </div>
        </div>
    </form>


    @push('script')
        <script>
            $('#simpan').on('submit', function() {
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
                    success: function(data) {
                        $('#new').modal('hide');
                        $('#simpan')[0].reset();
                        $('#example').DataTable().ajax.reload();
                        alert('Data berhasil disimpan');
                    },
                    error: function(data) {
                        alert('Data gagal disimpan');
                    }
                });
            })

            $('#example').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                fixedHeader: true,
                scrollX: true,
                scrollY: '50vh',
                paging: false,
                ajax: `{{ url('permissions') }}`,
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
                        data: 'guard_name',
                        name: 'guard_name',
                    },
                    {
                        className: 'text-center',
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
                    <li><a href="{{ url('permissions') }}" class="dropdown-item" type="button">Permissions</a>
                    </li>
                    <li><a href="{{ url('roles') }}" class="dropdown-item" type="button">Roles</a></li>
                    <li><a href="{{ url('users') }}" class="dropdown-item" type="button">Users</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h3>Permissions</h3>
                        <hr>
                        <h6>Add Permissions</h6>
                        <form method="POST" enctype="multipart/form-data" action="{{ url('permissions') }}">
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ $permission->guard_name }}</td>
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
