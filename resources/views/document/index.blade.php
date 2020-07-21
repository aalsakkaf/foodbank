@extends('layouts.master')

@section('title', 'All Documents')

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
    <h4>A list of Blocked Users</h4>
    <div class="row col-lg-12" style="margin: 0 auto; width: 100%; display: table;">
    <table id="documentTable" class="table table-hover" style="width: 100%">
        <thead>
        <tr>
            <th >User Name</th>
            <th >User Type</th>
            <th >Documents</th>
            <th >Status</th>
            <th >Action</th>
        </tr>
        </thead>
        <tbody>
            @if(!$users->isEmpty() )
            @foreach($users as $user)
        <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->roles->first()->name}}</td>
            <td><table class="table-borderless">
            @foreach ($user->documents as $document )
            <tr><td>{{$document->name}}</td><td > <a href="{{url('document/'.$document->id.'/open')}}"><i class="fas fa-file-download"></i></a> </td></tr>   
            @endforeach
            </table></td>
            <td>{{$user->status}}</td> 
            <td><a class="btn btn-primary" href="{{url('users/'.$user->id .'/approve')}}">Approve</a></td>
        </tr> 
        @endforeach
        @else
        <tr>
            <td>No Document found</td>
        </tr>
        @endif
        </tbody>   
    </table>
</div>
<br>
</div>
   <script>
       $(document).ready(function() {
        $('#documentTable').DataTable();
    });
   </script>
@endsection