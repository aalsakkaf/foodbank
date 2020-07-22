@extends('layouts.master')

@section('title', 'Pickup Request')

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
             <div class="row">
                    <div class="col-lg-6 col-6">
                      <!-- small box -->
                      <div class="small-box bg-info">
                        <div class="inner">
                        
                        <h3>{{$bundleCollected}}</h3>
            
                          <p>Number of Collected Items</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-truck-loading"></i>
                        </div>
                      </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-6 col-6">
                      <!-- small box -->
                      <div class="small-box bg-success">
                        <div class="inner">
                          <h3>{{$bundleUncollected}}</h3>
            
                          <p>Number of Uncollected Items</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-asterisk"></i>
                        </div>
                      </div>
                    </div>
             </div>
         <div class="Tablewrapper" >    
        <h5>A list of All Food Bundles</h5>
    <table id="bundleTable" class="table table-hover" style="width: 100%">
        <thead>
        <tr>
            <th scope="col">Pickup Date & Time</th>
            <th scope="col">Note</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @if(!$bundles->isEmpty())
            @foreach($bundles as $bundle)
        <tr>
            <td>{{$bundle->pickupDate}}</td>
            <td>{{$bundle->note}}</td>
            @if ($bundle->isCollected == 0)
                <td>Not Collected</td>
                <td><a class="btn btn-primary" href="{{url('bundle/'.$bundle->id.'/collected' )}}">Collected</a> <a class="btn btn-danger" data-toggle="modal" href="#deleteModal" data-whatever="{{route('bundle.destroy', $bundle)}}">Delete</a>
                @else <td>Collected</td><td>
                @endif
            <a class="btn btn-info" href="{{url('bundle/'.$bundle->id )}}">Details</a></td>
        </tr>
             @endforeach
            @else
            <tr>
                <td>No Bundle found</td>
            </tr>
            @endif

        </tbody>
    </table>
</div>
    <div class="row">
        <div class="col-12">
        <a href="{{route('bundle.create')}}" class="btn btn-success float-right">Create Food Bundle</a>
        </div>
      </div>
</div>

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
                <p>Do you really want to delete this food bundle? This process cannot be undone.</p>
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
    $(".modal").on("hidden.bs.modal", function(){ //to clear all variables displayed when closed and reopen
        $(".modal-body1").html("");
        //$(".modal-body").html(""); wrong

    });

    
    $('#deleteModal').on('show.bs.modal', function (event) {
        var edit = $(event.relatedTarget); // Button that triggered the modal
        var url = edit.data('whatever'); // Extract info from data-* attributes
        $('#deleteForm').attr('action', url);
        var modal = $(this);
    });
    $(document).ready(function() {
        $('#bundleTable').DataTable();
    });
        
</script>
@endsection