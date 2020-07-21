@extends('layouts.master')

@section('title', 'Reward Points')

@section('content')
    <div class="container">  
        @foreach ($errors->all() as $error)
        <p class="alert alert-danger">{{ $error }}</p>
    @endforeach
    @if (session('status'))
        <div class="alert alert-success">
                {{ session('status') }}
         </div>
    @endif  
        <br />
      <div class="Tablewrapper" style="margin: 0 auto; width: 100%;">                   
          <table id="rewardTable" class="table table-hover" style="width: 100%">
                  <thead>
                   <tr>
                       <th width="21%">Name</th>
                       <th width="12%">Points</th>
                       <th width="10%">Description</th>
                       <th width="15%">Action</th>
                   </tr>
                  </thead>
                  <tbody>
                    @if(!$points->isEmpty())
                    @foreach($points as $point)
                <tr>
                <tr><td>{{$point->name}}</td>
                <td>{{$point->points}}</td>
                <td>{{$point->description}}</td>
                <td><button type="button" id="edit" class="btn btn-primary"  data-toggle="modal" data-target="#editItem" data-whatever="{{$point}}">Edit</button> | <a class="btn btn-danger" data-toggle="modal" href="#deleteModal" data-whatever="{{route('reward.destroy', $point)}}">Delete</a> </td>
                </tr>
                     @endforeach
                    @else
                    <tr>
                        <td>No Reward Points found</td>
                    </tr>
                    @endif
                  </tbody>
                  <tfoot>
                   <tr>
                                   <td colspan="3" allign="right">&nbsp;</td>
                    <td>
                    <button style="width: 100%" type="button" id="add" class="btn btn-primary" data-toggle="modal" data-target="#addItem" data-whatever="{{''}}">Add More</button>
                    </td>
                   </tr>
                  </tfoot>
              </table>
      </div>
    </div>
      <form method="POST"  action="{{route('reward.store' )}}" enctype="multipart/form-data">
      <div class="modal fade" id="addItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">ADD Reward Point </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">                
                @csrf
                <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name')}}">
              </div>
              <div class="form-group">
                <label for="name">Description:</label>
                <input type="text" class="form-control" id="description" name="description" value="{{ old('description')}}">
              </div>
              <div class="form-group">
                <label for="name">Points:</label>
                <input type="text" class="form-control" id="points" name="points" value="{{ old('points')}}">
              </div>
              
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </div>
        </div>
      </div>
      </div>
    </form>

    <form method="POST" enctype="multipart/form-data" id="updateForm">
        @method('PUT')
        @csrf
      <div class="modal fade" id="editItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">EDIT THIS REWARD POINTS</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name')}}">
              </div>
              <div class="form-group">
                <label for="name">Description:</label>
                <input type="text" class="form-control" id="description" name="description" value="{{ old("description")}}">
              </div>
              
              <div class="form-group">
                <label for="name">Points:</label>
                <input type="number" class="form-control" id="points" name="points" value="{{old("points")}}">
              </div>
             
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </div>
        </div>
      </div>
    </form>

    <form method="POST" id="deleteForm" >
        @method('DELETE')
        @csrf
     <div id="deleteModal" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                </div>
                <div class="modal-body">
                        <input type="hidden" class="form-control" id="id" name="id" >
                    <p>Do you really want to delete this reward points? This process cannot be undone.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div> 
</form>
   
      
<script>

$(document).ready(function(){
    $('#editItem').on('show.bs.modal', function (event) {
        var edit = $(event.relatedTarget); // Button that triggered the modal
        var item = edit.data('whatever'); // Extract info from data-* attributes
        var modal = $(this);
        modal.find('.modal-title').val(' (' + item.name + ')');
        modal.find('.modal-body input#name').val(item.name);
        modal.find('.modal-body input#description').val(item.description);
        modal.find('.modal-body input#points').val(item.points);
        var url = 'reward/'+ item.id;
        $('#updateForm').attr('action', url);

        
    });
    $(".modal").on("hidden.bs.modal", function(){ //to clear all variables displayed when closed and reopen
        $(".modal-body1").html("");
        //$(".modal-body").html(""); wrong

    });

    $('#addItem').on('show.bs.modal', function (event) {
        var edit = $(event.relatedTarget); // Button that triggered the modal
        var item = edit.data('whatever'); // Extract info from data-* attributes
        var modal = $(this);
        
        modal.find('.modal-body input#donationId').val({{Session::get('donationId')}});
    });
    $('#deleteModal').on('show.bs.modal', function (event) {
        var edit = $(event.relatedTarget); // Button that triggered the modal
        var url = edit.data('whatever'); // Extract info from data-* attributes
        //console.log(url);
        $('#deleteForm').attr('action', url);
        var modal = $(this);
        
        //modal.find('.modal-body input#id').val(item.id);
    });
        $('#rewardTable').DataTable();
});
    </script>
@endsection