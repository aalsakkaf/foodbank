@extends('layouts.master')

@section('title', 'Collect Request')

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
    <h4>Food Bundle Information</h4>
    </div>
    @isset($bundles)
        @foreach($bundles as $bundle)
    <div class="row">
    <p><strong>Pickup Date & Time:</strong> {{$bundle->pickupDate}}</p> 
    </div>
    <div class="row">
    <p><strong>Note:</strong> {{$bundle->note}}</p>
    </div>
     
    <div class="row">
        <p><strong>List of Food Items</strong></strong></p>
        </div>
    <table id="table" class="table table-hover table-sm" style="table-layout: fixed; border-collapse: collapse;
    border-spacing: 0;">
        <thead>
        <tr>
            <th scope="col" style="text-align:center">Image</th>
            <th scope="col">Item Name</th>
            <th scope="col">Category</th>

        </tr>
        </thead>
        <tbody>
            @foreach ($bundle->foodItems as $foodItem)
                <tr>
                    <td ><img style="display:block; width:50%; height:auto; margin: 0 auto;" src="{{asset('storage/'.$foodItem->photoURL)}}"></td>
                    <td >{{$foodItem->name}}</td>
                    <td >{{$foodItem->foodCategory->name}}</td>
                </tr>
            @endforeach
        @endforeach
        @endisset

        </tbody>
        <tfoot>
            
        </tfoot>
    </table>
    
</div>

@endsection