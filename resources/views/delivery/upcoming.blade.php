@extends('layouts.master')

@section('title', 'Upcoming Pickup Request')

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
                 <div class="col">
             <h5>You can view,update, or cancel a pickup request</h5>
             <br>
            </div>
            </div>
    <table id="bundleTable" class="table table-hover" style="width: 100%">
        <thead>
        <tr>
            <th scope="col">Donation Name</th>
            <th scope="col">Donor Name</th>
            <th scope="col">Date of Creation</th>
            <th scope="col">Pickup Date & Time</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @if(!$deliveries->isEmpty())
            @foreach($deliveries as $delivery)
            @if ($delivery->donation->status->name != 'Delivered') 
        <tr>   
            <td>{{$delivery->donation->title}}</td>
            <td>{{$delivery->donation->user->name}}</td>
            <td>{{$delivery->donation->created_at}}</td>
            <td>{{$delivery->pickupDate}}</td>
            <td>{{$delivery->donation->status->name}}</td>
            <td><a class="btn btn-info" href="{{url('donation/'.$delivery->donation->id )}}">Details</a>
            |<button class="btn btn-primary" data-toggle="modal" data-target="#editDelivery" data-whatever="{{$delivery}}" data-url="{{route('delivery.update', $delivery)}}">Modify Pickup</button>
            |<button class="btn btn-danger" data-toggle="modal" data-target="#deleteDelivery" data-whatever="{{route('delivery.destroy', $delivery)}}">Cancel Pickup</button>
            </td>
        </tr>
            @endif   
             @endforeach
            @else
            <tr>
                <td>No Donation found</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
<form method="POST" id="updateForm" >
    @method('PUT')
    @csrf
<div id="editDelivery" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Pickup Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="note" class="col-lg-4 control-label">Pickup Date & Time:</label>
                    <div class="col-lg-10">
                    <input type="Datetime-local" class="form-control" id="pickupDate" name="pickupDate" value="{{old('pickupDate')}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="note" class="col-lg-2 control-label">Note:</label>
                    <div class="col-lg-10">
                    <textarea id="note" name="note" class="form-control" placeholder="Note Body" rows="7" cols="40">{{old('note')}}</textarea>
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

{{-- <form method="POST" action="{{route('donation.destroy', $donation)}}" > --}}
    <form method="POST" id="deleteForm">
    @method('DELETE')
    @csrf
    <div id="deleteDelivery" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <p>Do you really want to cancel this pickup request? This process cannot be undone.</p>
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

        $('#editDelivery').on('show.bs.modal', function (event) {
        var edit = $(event.relatedTarget); // Button that triggered the modal
        var item = edit.data('whatever'); // Extract info from data-* attributes
        var url = edit.data('url');
        var modal = $(this);
        modal.find('.modal-body input#pickupDate').val(item.pickupDate.toString());
        modal.find('.modal-body textarea#note').val(item.note);
        modal.find('.modal-body input#donation_id').val(item.donation_id);

        
        $('#updateForm').attr('action', url);
        
    });

    $('#deleteDelivery').on('show.bs.modal', function (event) {
        var edit = $(event.relatedTarget); // Button that triggered the modal
        var url = edit.data('whatever'); // Extract info from data-* attributes
        var modal = $(this);
        
        $('#deleteForm').attr('action', url);
        //modal.find('.modal-body input#donation_id').val(item.id);
    });
    $(document).ready(function() {
        $('#bundleTable').DataTable();
    });
    </script>
@endsection