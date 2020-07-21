@extends('layouts.master')

@section('title', 'Error!')

@section('content')
<div class="container">
    <!-- Main content -->
    <br>
    <br>
      <div class="row">
          <div class="col d-flex justify-content-center ">
        <div class="error-content">
          <h3><i class="fas fa-exclamation-triangle text-danger"></i> Restricted Access!! </h3>
          <p>
            You are not authorized to access this page!! 
            <br><a href="{{url('/')}}">return to home page</a>
          </p>
        </div>
    </div>
  </div>
</div>
  @endsection