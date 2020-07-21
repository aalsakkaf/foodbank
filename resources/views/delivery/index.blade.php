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
    <table id="bundleTable" class="table table-hover" style="width: 100%">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Donor</th>
            <th scope="col">Date of Creation</th>
            <th scope="col">Availability</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @if(!$donations->isEmpty())
            @foreach($donations as $donation)
        <tr>
            <th scope="row">{{$donation->id}}</th>
            <td>{{$donation->title}}</td>
            <td>{{$donation->user->name}}</td>
            <td>{{$donation->created_at}}</td>
            <td>{{$donation->availableDate}}</td>
            <td><a class="btn btn-info" href="{{url('donation/'.$donation->id )}}">Details</a>@empty($donation->delivery)
                
            |<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDelivery" data-id="{{$donation->id}}">Pick Up</button>@endempty @isset($donation->delivery)|
                
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteDelivery" data-id="{{$donation}}">Cancel</button> @endisset</td>
        </tr>
             @endforeach
            @else
            <tr>
                <td>No Donation found</td>
            </tr>
            @endif

        </tbody>
    </table>
</div>
<form method="POST" action="{{route('delivery.store')}}" >
    @csrf
<div id="addDelivery" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="note" class="col-lg-4 control-label">Pickup Date & Time:</label>
                    <div class="col-lg-10">
                        <input type="Datetime-local" class="form-control" id="pickupDate" name="pickupDate">
                    </div>
                </div>
                <div class="form-group">
                    <label for="note" class="col-lg-2 control-label">Note:</label>
                    <div class="col-lg-10">
                    <textarea name="note" class="form-control" placeholder="Note Body" rows="7" cols="40"></textarea>
                    </div>
                </div>
                    <input type="hidden" class="form-control" id="donation_id" name="donation_id" >
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Save</button>
            </div>
        </div>
    </div>
</div>
</form>

    <script>
        $('#addDelivery').on('show.bs.modal', function (event) {
        var edit = $(event.relatedTarget); // Button that triggered the modal
        var item = edit.data('id'); // Extract info from data-* attributes
        var modal = $(this);
        
        modal.find('.modal-body input#donation_id').val(item);
    });
    $(document).ready(function() {
        $('#bundleTable').DataTable();
    });
    </script>
@endsection