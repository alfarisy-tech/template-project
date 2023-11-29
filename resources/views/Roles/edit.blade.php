<!DOCTYPE html>
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
                        <h6>Edit Roles</h6>
                        <form method="POST" enctype="multipart/form-data" action="{{ url('roles/' . $role->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row form-group">
                                <div class="col-6 mb-3">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" value="{{ $role->name }}"
                                        name="name">
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="">Guard</label>
                                    <input type="text" class="form-control" readonly value="{{ $role->guard_name }}"
                                        name="guard">
                                </div>
                                <div class="col-12 mb-3">
                                    @foreach ($permissions as $permission)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                value="{{ $permission->name }}" id="{{ $permission->name }}"
                                                name="permissions[]"
                                                {{ $role->permissions->contains('name', $permission->name) ? 'checked' : '' }}>
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

</html>
