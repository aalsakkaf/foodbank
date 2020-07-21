@extends('layouts.master')

@section('content')
<div class="container">
    @if ($message = Session::get('status'))
    <div class="alert alert-success">
        <div>{{ $message }}</div>
    </div>
@endif
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h4>Edit Your Profile Info</h4>
        </div>
    </div>
</div>

@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif

<form action="{{url('users/profile')}}" method="POST" enctype="multipart/form-data">
    @csrf
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {{-- {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control', 'value' => $user->name)) !!} --}}
        <input type="text" class="form-control" placeholder="Name" name="name" value="{{$user->name}}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            <input type="email" class="form-control" placeholder="Email" name="email" value="{{$user->email}}">

        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>IC Number:</strong>
            <input type="text" class="form-control" placeholder="IC Number" name="icNumber" value="{{$user->icNumber}}">

        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Phone:</strong>
        <input type="text" class="form-control" placeholder="Phone", value="{{$user->phone}}" name="phone">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Address:</strong>
            <input type="text" class="form-control" placeholder="Address", value="{{$user->address}}" name="address">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group" >
            <strong>Password:</strong>
            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Confirm Password:</strong>
            {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Avatar:</strong>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile" name="avatar" >
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
        </div>
    </div>
    
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
    <input type="hidden" class="custom-file-input" id="customFile" name="id" value="{{$user->id}}" >
        <button type="submit" class="btn btn-primary">Submit</button>
    <a class="btn btn-primary" href="{{url('/')}}"> Back </a>
    </div>
</div>
</form>
</div>
@endsection