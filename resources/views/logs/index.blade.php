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
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col-12 mb-3">
                    </div>
                    <div class="col-12">
                        {{-- <caption>
                            <span> <button class="btn btn-green btn-sm">&nbsp;</button> : Create</span>
                            <span> <button class="btn btn-blue btn-sm">&nbsp;</button> : Edit</span>
                            <span> <button class="btn btn-red btn-sm">&nbsp;</button> : Delete</span>

                        </caption> --}}
                        <table id="example" class="table display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th class="text-center" scope="col">Activity</th>
                                    <th class="text-center" scope="col">By</th>
                                    <th class="text-center" scope="col">Date</th>
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
            $('#example').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                fixedHeader: true,
                scrollX: true,
                scrollY: '50vh',
                paging: false,
                ajax: `{{ url('logs') }}`,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false,
                        className: 'text-center fw-bold'
                    },
                    {
                        data: 'description',
                        name: 'description',
                    },
                    {
                        className: 'text-center',
                        data: 'causer_id',
                        name: 'causer_id',
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        className: 'text-center'
                    }

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
