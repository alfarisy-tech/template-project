<div class="text-center">
    <button class="btn btn-primary btn-sm fw-bold modalEditButton" type="button" data-bs-toggle="modal"
        data-bs-target="#edit{{ $data->id }}">Manage</button>
</div>

<form class="update" method="POST" enctype="multipart/form-data" action="{{ url('roles/' . $data->id) }}">
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
                        <div class="col-12 mb-3">
                            @foreach ($permissions as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $permission->name }}"
                                        id="{{ $permission->name }}" name="permissions[]"
                                        {{ $data->permissions->contains('name', $permission->name) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $permission->name }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ url('roles/' . $data->id . '/delete') }}"
                        class="delete btn-red btn text-light">Delete</a>
                    <button class="btn btn-warning closeModalUpdate" type="button"
                        data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary updateButton" type="submit">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
