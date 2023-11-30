<div class="text-center">
    <button class="btn btn-primary btn-sm fw-bold modalEditButton" type="button" data-bs-toggle="modal"
        data-bs-target="#edit{{ $data->id }}">Manage</button>
</div>

<form class="update" method="POST" enctype="multipart/form-data" action="{{ url('users/' . $data->id) }}">
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
                        <div class="col-6 mb-3">
                            <label for="">Name</label>
                            <input type="text" class="form-control" value="{{ $data->name }}" name="name">
                        </div>
                        <div class="col-6 mb-3">
                            <label for="">Email</label>
                            <input type="email" class="form-control" value="{{ $data->email }}" name="email">
                        </div>
                        <div class="col-12 mb-3">
                            @foreach ($roles as $role)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $role->name }}"
                                        id="{{ $role->name }}" name="roles[]"
                                        {{ $data->roles->contains('name', $role->name) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $role->name }}">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ url('users/' . $data->id . '/delete') }}"
                        class="delete btn-red btn text-light">Delete</a>
                    <a href="{{ url('users/' . $data->id . '/reset-password') }}"
                        class="reset-password btn-secondary btn text-light">Reset
                        Password</a>

                    <button class="btn btn-warning closeModalUpdate" type="button"
                        data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary updateButton" type="submit">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
