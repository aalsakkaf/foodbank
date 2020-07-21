@extends('layouts.master')

@section('content')
<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <div>{{ $message }}</div>
    </div>
@endif
<div class="row">
    <div class="col-lg-12 ">
        <div class="pull-left">
            <h4>Role Management</h4>
        </div>
    </div>
</div>
<br>

<div class="row">
<table class="table table-bordered">
  <tr>
     <th>No</th>
     <th>Name</th>
     <th width="280px">Action</th>
  </tr>
    @foreach ($roles as $key => $role)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $role->name }}</td>
        <td>
            <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>
            @can('role-edit')
                <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
            @endcan
            @can('role-delete')
                {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
            @endcan
        </td>
    </tr>
    @endforeach
</table>
</div>

{!! $roles->render() !!}
<div class="row">
    <div class="col-12">
    <a href="{{url('dashboard')}}" class="btn btn-secondary">Cancel</a><a href="{{url('roles/create')}}" class="btn btn-success float-right">Create New Role</a>
    </div>
  </div>
</div>


@endsection