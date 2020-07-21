<@extends('layouts.master')

@section('title', 'Upload Documents')

@section('content')
    <div class="container">
    @foreach ($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p>
            @endforeach
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
             @endif

             <div class="card card-block" >
                <div class="card-header" >
                    <div class="row" >
                        <h4 class="card-title">Documents Upload</h4>    
                    </div>                    
                </div>
             <div class="card-body">
                 <p>Please provide the follwoing documents to be approved by Admin</p>
                <form role="form" action="{{ route('document.store') }}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <div class='form-row'>
                        <div class='col-sm-12 form-group  required'>
                            <label class='col-form-label'>Identification Card: </label> 
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="id" required>
                                <label class="custom-file-label" for="customFile">Choose file</label>
                              </div>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='col-sm-12 form-group  required'>
                            <label class='col-form-label'>Reference Letter: </label> 
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="letter" required>
                                <label class="custom-file-label" for="customFile">Choose file</label>
                              </div>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='col-sm-12 form-group  required'>
                            <label class='col-form-label'>Other Supporting Documents: </label> 
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="other" >
                                <label class="custom-file-label" for="customFile">Choose file</label>
                              </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Upload Now</button>
                        </div>
                    </div>    
                </form>
            </div>
        </div>
</div>
   
@endsection