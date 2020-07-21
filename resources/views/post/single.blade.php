@extends('layouts.master')

@section('title', 'Show a Post')

@section('content')
<div class="container">
    <form method="POST" id="form">
        @method('DELETE')
        @csrf
    <div  class="modal fade" id="deletePost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                </div>
                <div class="modal-body">
                    <p>Do you really want to delete this donation? This process cannot be undone.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
       
    <div class="container col-md-11">
        @foreach ($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p>
            @endforeach
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
             @endif
        <div class="row">
            <h4>Title: {{$post->title}}</h4>
        </div>
        <div class="row">      
            <p><strong>Date of Creation:</strong> {{$post->created_at}}</p>
        </div>
            <p><strong>Content:</strong></p><p> {!!$post->content!!}</p>
         
            <td><a class="btn btn-primary" href="{{url('post/'.$post->id .'/edit'  )}}">Edit</a> | <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deletePost" data-whatever="{{route('post.destroy',  $post)}}">Delete</button></td>
        </div>


 <script>
        $(document).ready(function(){
        $(".modal").on("hidden.bs.modal", function(){ //to clear all variables displayed when closed and reopen
        $(".modal-body1").html("");
        //$(".modal-body").html(""); wrong

    });

    $('#deletePost').on('show.bs.modal', function (event) {
        var deleteButton = $(event.relatedTarget); // Button that triggered the modal
        var url = deleteButton.data('whatever'); // Extract info from data-* attributes
        //var modal = $(this);
        $('#form').attr('action', url);
    });
});

    </script>            
@endsection