   <div class="text-center">
       <button class="btn btn-primary btn-sm fw-bold modalEditButton" type="button" data-bs-toggle="modal"
           data-bs-target="#edit{{ $data->id }}">Manage</button>
   </div>

   <div class="currentModal">
       <!-- Modal -->
       <div class="modal" data-bs-backdrop="static" id="edit{{ $data->id }}" tabindex="-1" role="dialog"
           data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered" role="document">
               <form class="update" method="POST" enctype="multipart/form-data"
                   action="{{ url('permissions/' . $data->id) }}">
                   @csrf
                   @method('PUT')
                   <div class="modal-content">
                       <div class="modal-header">
                           <h5 class="modal-title" id="new">Manage</h5>
                           <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                       </div>
                       <div class="modal-body text-dark">
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
                       <div class="modal-footer">
                           <a href="{{ url('permissions/' . $data->id . '/delete') }}"
                               class="delete  btn-red btn text-light">Delete</a>
                           <button class="btn  btn-warning closeModalUpdate" type="button"
                               data-bs-dismiss="modal">Close</button>
                           <button class="btn btn-primary updateButton" type="submit">Update</button>
                       </div>
                   </div>
               </form>
           </div>
       </div>
   </div>
