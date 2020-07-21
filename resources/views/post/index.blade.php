@extends('layouts.master')

@section('title', 'All Posts')

@section('content')
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

    <div class="container">
    @foreach ($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p>
            @endforeach
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
             @endif
    <div class="Tablewrapper" style="margin: 0 auto; width: 100%;">
    <table id="postTable" class="table table-hover" style="width: 100%">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">User</th>
            <th scope="col">Date of Creation</th>
            {{-- <th scope="col">Content</th> --}}
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @if(!$posts->isEmpty())
            @foreach($posts as $post)
        <tr>
            <th scope="row">{{$post->id}}</th>
            <td>{{$post->title}}</td>
            <td>{{$post->user->name}}</td>
            <td>{{$post->created_at}}</td>
            {{-- <td>{!!$post->content!!}</td> --}}
            <td><a class="btn btn-info" href="{{url('post/'.$post->id )}}">Details</a>|<a class="btn btn-primary" href="{{url('post/'.$post->id .'/edit'  )}}">Edit</a> | <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deletePost" data-whatever="{{route('post.destroy',  $post)}}">Delete</button> </td>
        </tr>
             @endforeach
            @else
            <tr>
                <td>No posts found</td>
            </tr>
            @endif

        </tbody>
    </table>
</div>
@role('Student')  
<div class="row">
    <div class="col-12">
    <a href="{{url('post/create')}}" class="btn btn-success float-right">Create New Post</a>
    </div>
  </div>
@endrole

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
$(document).ready(function() {
        $('#postTable').DataTable();
    });
    </script>
@endsection