@extends('layouts.master')

@section('title', 'Submit Documents')

@section('content')
    <form method="POST" enctype="multipart/form-data" id="updateForm">
        @method('PUT')
        @csrf
     <div id="editItem" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                </div>
                <div class="modal-body">
                    <div class='form-row'>
                        <div class='col-sm-12 form-group  required'>
                            <label class='col-form-label' id="label1" >Please upload</label> 
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="file" >
                                <input type="hidden" id="id" name="id">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div> 
</form>
    <div class="container">
        @foreach ($errors->all() as $error)
        <p class="alert alert-danger">{{ $error }}</p>
    @endforeach
    @if (session('success'))
        <div class="alert alert-success">
                {{ session('success') }}
         </div>
    @endif  
        <br>
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header bg-danger text-white" >Waiting for Approval</div>

                    <div class="card-body">
                        Your account is waiting for our administrator approval.<br> Please Review your documents you uploaded. You can still re-upload them
                    </div>
                </div>
            </div>
        </div>
        <br>
                <div class="card-deck mb-3 text-center">
                @if (!$documents->isEmpty())
                @foreach ($documents as $document)
                <div class="card mb-4 box-shadow">
                  <div class="card-header">
                    <h5 class="my-0 font-weight-normal">{{$document->name}}</h5>
                  </div>
                  <div class="card-body">
                    <ul class="list-unstyled mt-3 mb-4">
                    <li>Submission Date: {{$document->created_at}}</li>
                    </ul>
                <button type="button" class="btn btn-outline-primary"  data-toggle="modal" data-target="#editItem" data-whatever="{{$document}}" data-url="{{route('document.update', $document)}}">Edit</button>
                    <a href="{{url('document/'.$document->id.'/open')}}" class="btn btn-outline-primary">Download</a>
                  </div>
                </div>
              @endforeach
              @endif
            </div>

    </div>

            <script>
              $('#editItem').on('show.bs.modal', function (event) {
                var edit = $(event.relatedTarget); // Button that triggered the modal
                var item = edit.data('whatever'); // Extract info from data-* attributes
                var modal = $(this);
                modal.find('.modal-title').text(item.name);
                modal.find('.modal-body input#id').val(item.id);
                //var url = edit.data('url');
                var url = 'document/'+ item.id;
                $('#updateForm').attr('action', url); 
    });

              $(".modal").on("hidden.bs.modal", function(){ //to clear all variables displayed when closed and reopen
             $(".modal-body1").html("");
                //$(".modal-body").html(""); wrong
                });
            </script>
@endsection