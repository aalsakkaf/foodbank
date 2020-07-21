@extends('layouts.master')

@section('title', 'Past Pickup Request')

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
             <h5>Please Update the status of pickup request once delivered</h5>
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
        <tr>
            <td>{{$delivery->donation->title}}</td>
            <td>{{$delivery->donation->user->name}}</td>
            <td>{{$delivery->donation->created_at}}</td>
            <td>{{$delivery->pickupDate}}</td>
            <td>{{$delivery->donation->status->name}}</td>
            <td><a class="btn btn-info" href="{{url('donation/'.$delivery->donation->id )}}">Details</a>
            @if($delivery->donation->status->name != "Delivered")
            |<a class="btn btn-primary" href="{{url('donation/'. $delivery->donation->id .'/delivered')}}">Delivered</a>
            @endif    
        </td>
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
<script>
    $(document).ready(function() {
        $('#bundleTable').DataTable();
    });
</script>
@endsection