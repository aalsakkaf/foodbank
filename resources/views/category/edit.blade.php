@extends('layouts.master')

@section('title', 'Edit a Category')

@section('content')
<div class="container col-md-8 col-md-offset-2">
    <div class="well well bs-component">
    <form class="form-horizontal" method="post" action="{{ url('/category/edit') }}">
        @csrf
            @foreach ($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p>
            @endforeach
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
             @endif
                {{-- <input type="hidden" name="_token" value="{!! csrf_token() !!}"> --}}
                <fieldset>
                    <legend>Edit a Category</legend>
                    <div class="form-group">
                    <label for="name" class="col-lg-2 control-label">Name</label>
                        <div class="col-lg-10">
                        <input type="text" class="form-control" id="name" name="name" value="{{$category->name}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <input type="hidden" class="form-control" id="name" name="id" value="{{$category->id}}">
                            <button type="reset" class="btn btn-default">Cancel</button
                            >
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </fieldset>
        </form>
    </div>
</div>
@endsection