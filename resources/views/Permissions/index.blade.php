@extends('layouts.index')
@section('content')
    @push('css')
    @endpush
    <div class="container-xl px-4 mt-n10 ">
        <div class="row">
            <div class="col-lg-4 mb-5">
                <div class="card shadow">
                    <div class="card-header">
                        <span class="mb-0">Create {{ $title }}</span>
                    </div>
                    <form class="needs-validation save" method="POST" enctype="multipart/form-data"
                        action="{{ url('permissions') }}">
                        @csrf
                        @method('POST')
                        <div class="card-body">
                            <div class="row form-group">
                                <div class="col-12 mb-3">
                                    <label class="text-dark" for="name">Name</label>
                                    <input id="name" type="text" class="form-control" value="" name="name">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="text-dark" for="guard">Guard</label>
                                    <input id="guard" type="text" class="form-control" value="web" disabled
                                        name="guard_name">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-warning" type="reset" data-bs-dismiss="modal">Reset</button>
                            <button class="btn btn-primary saveButton" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        {{ $title }}
                    </div>
                    <div class="card-body">
                        <table id="example" class="table display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th class="text-center text-dark" scope="col">Name</th>
                                    <th class="text-center text-dark" scope="col">Guard</th>
                                    <th class="text-center text-dark" scope="col">Action</th>
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
            $(function() {

                //submit save
                $(document).find('.save').on('submit', function(event) {
                    let validator = $('form.save,form.update').jbvalidator({
                        errorMessage: true,
                        successClass: false,
                        language: "https://emretulek.github.io/jbvalidator/dist/lang/en.json"
                    });

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
                            // kosongkan form
                            form[0].reset();
                            // validator reset

                            if (data.success == true) {
                                toastr.success(data.message, 'Success', {
                                    timeOut: 3000,
                                    closeButton: true,
                                    progressBar: true,
                                })
                            } else {
                                toastr.warning(data.message, 'Warning', {
                                    timeOut: 3000,
                                    closeButton: true,
                                    progressBar: true,
                                })
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            let data = xhr.responseJSON;
                            if (data.errors) {
                                Object.keys(data.errors).forEach(function(key) {
                                    var fieldName = key;
                                    var errorMessage = data.errors[key];
                                    validator.errorTrigger($('[name=' + fieldName +
                                        ']'), errorMessage);
                                });
                                toastr.warning(data.message, 'Warning', {
                                    timeOut: 3000,
                                    closeButton: true,
                                    progressBar: true,
                                })
                            } else {
                                toastr.error(data.message, 'Error', {
                                    timeOut: 3000,
                                    closeButton: true,
                                    progressBar: true
                                });
                            }

                        },
                        complete: function() {
                            $('.saveButton').prop('disabled', false);
                            $('.saveButton').html('Save');
                        },
                    });
                })

                //submit update
                $(document).on('submit', '.update', function(event) {
                    let validator = $('form.save,form.update').jbvalidator({
                        errorMessage: true,
                        successClass: false,
                        language: "https://emretulek.github.io/jbvalidator/dist/lang/en.json"
                    });

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
                            if (data.success == true) {
                                toastr.success(data.message, 'Success', {
                                    timeOut: 3000,
                                    closeButton: true,
                                    progressBar: true,
                                })
                            } else {
                                toastr.warning(data.message, 'Warning', {
                                    timeOut: 3000,
                                    closeButton: true,
                                    progressBar: true,
                                })
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            let data = xhr.responseJSON;
                            if (data.errors) {
                                Object.keys(data.errors).forEach(function(key) {
                                    var fieldName = key;
                                    var errorMessage = data.errors[key];
                                    validator.errorTrigger(form.find('[name=' + fieldName +
                                        ']'), errorMessage);
                                });
                                toastr.warning(data.message, 'Warning', {
                                    timeOut: 3000,
                                    closeButton: true,
                                    progressBar: true,
                                })
                            } else {
                                toastr.error(data.message, 'Error', {
                                    timeOut: 3000,
                                    closeButton: true,
                                    progressBar: true
                                });
                            }
                        },
                        complete: function() {
                            $('.updateButton').prop('disabled', false);
                            $('.updateButton').html('Save');
                        },
                    });
                })

                //delete
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
                                    $('.delete').html(
                                        '<i class="fa fa-spin fa-spinner"></i>');
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
                        className: 'text-center text-dark fw-bold'
                    },
                    {
                        className: 'text-dark',
                        data: 'name',
                        name: 'name',
                    },
                    {
                        className: 'text-center',
                        data: 'guard_name',
                        name: 'guard_name',
                    },
                    {
                        className: '',
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        orderable: false,
                    },
                ],
                drawCallback: function(settings) {
                    // Kode yang akan dijalankan setelah DataTable selesai dikerjakan
                    $('#thisModal').html('');
                    $('.currentModal').each(function() {
                        let currentModal = $(this).html();
                        $(this).html('');
                        $('#thisModal').append(currentModal);
                    });
                },
            });
        </script>
    @endpush
@endsection
