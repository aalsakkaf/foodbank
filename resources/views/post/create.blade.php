@extends('layouts.master')

@section('title', 'Create a Post')

@section('content')
    <div class="container col-md-8 col-md-offset-2">
        <div class="well well bs-component">
        <form class="form-horizontal" method="post" action="{{route('post.store')}}">
                @foreach ($errors->all() as $error)
                    <p class="alert alert-danger">{{ $error }}</p>
                @endforeach
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                 @endif
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <fieldset>
                        <div class="card">
                            <div class="card-body">
                        <legend>Appreciation Post</legend>
                        <div class="form-group">
                            <label for="title" class="col-lg-2 control-label">Title:</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="name" name="title">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title" class="col-lg-2 control-label">Content:</label>
                            <div class="col-lg-10">
                            <textarea name="content" class="form-control" id="article-ckeditor" placeholder="Content Body" rows="15" cols="80"></textarea>
                            </div>
                        </div>
                            
                        
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="reset" class="btn btn-default">Cancel</button
                                >
                                <button type="submit" class="btn btn-primary" >Next</button>
                            </div>
                        </div>
                            </div>
                        </div>
                    </fieldset>
            </form>
        </div>
    </div>

    <script src="{{asset('js/laravel-ckeditor/ckeditor.js')}}"></script>
<script>
    CKEDITOR.replace( 'article-ckeditor' );
</script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="/js/ripples.min.js"></script>
    <script src="/js/material.min.js"></script>
<script>
    $(document).ready(function() {

        $.material.init();
    });
</script>
@endsection