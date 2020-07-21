@extends('layouts.master')

@section('title', 'Category')

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
            <th scope="col">Category</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @if(!$all->isEmpty())
            @foreach($all as $category)
        <tr>
            <th scope="row">{{$category->id}}</th>
            <td class='name'>{{$category->name}}</td>
            <td><a class="btn btn-primary" href="{{url('/category/edit/' .$category->id )}}">Edit</a> | <a class="btn btn-danger" href="{{url('/category/delete/' .$category->id )}}">Delete</a> </td>
        </tr>
             @endforeach
            @else
            <tr>
                <td>No Category found</td>
            </tr>
            @endif

        </tbody>
    </table>
</div>
    <div class="row">
        <div class="col-12">
        <a href="{{url('dashboard')}}" class="btn btn-secondary">Cancel</a><a href="{{url('category/create')}}" class="btn btn-success float-right">Create Food Category</a>
        </div>
      </div>
</div>
@endsection