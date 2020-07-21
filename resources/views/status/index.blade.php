@extends('layouts.master')

@section('title', 'All Status')

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
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @if(!$all->isEmpty())
            @foreach($all as $status)
        <tr>
            <th scope="row">{{$status->id}}</th>
            <td>{{$status->name}}</td>
            <td><a class="btn btn-primary" href="{{url('/status/edit/' .$status->id )}}">Edit</a> | <a class="btn btn-danger" href="{{url('/status/delete/' .$status->id )}}">Delete</a> </td>
        </tr>
             @endforeach
            @else
            <tr>
                <td>No status found</td>
            </tr>
            @endif

        </tbody>
    </table>
</div>
    <div class="row">
        <div class="col-12">
        <a href="{{url('dashboard')}}" class="btn btn-secondary">Cancel</a><a href="{{url('status/create')}}" class="btn btn-success float-right">Create New Status</a>
        </div>
      </div>
</div>
@endsection