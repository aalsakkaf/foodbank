@extends('layouts.master')

@section('title', 'User Management')

@section('content')
<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
      <div>{{ $message }}</div>
    </div>
    @endif

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h4>Users Management</h4>
        </div>
       
    </div>
</div>
<br>
<div class="Tablewrapper" style="margin: 0 auto; width: 100%;">
<table id="userTable" class="table table-hover" style="width: 100%">
 <tr>
   <th>No</th>
   <th>Name</th>
   <th>Email</th>
   <th>Roles</th>
   <th>Status</th>
   <th width="280px">Action</th>
 </tr>
 @foreach ($data as $key => $user)
  <tr>
    <td>{{ ++$i }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>
      @if(!empty($user->getRoleNames()))
        @foreach($user->getRoleNames() as $v)
           <label class="badge badge-success">{{ $v }}</label>
        @endforeach
      @endif
    </td>
  <td><label class="badge badge-secondary">{{$user->status}}</label></td>
    <td>
       <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
       <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
        {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </td>
  </tr>
 @endforeach
</table>
</div>

<div class="row">
  <div class="col-12">
  <a href="{{url('dashboard')}}" class="btn btn-secondary">Cancel</a><a href="{{ route('users.create') }}" class="btn btn-success float-right">Create New User</a>
  </div>
</div>
</div>


{!! $data->render() !!}
<script>
  $(document).ready(function() {
        $('#userTable').DataTable();
    });
</script>
@endsection