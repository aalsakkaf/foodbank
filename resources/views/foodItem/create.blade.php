@extends('layouts.master')

@section('title', 'Create Food Item')

@section('content')

    {{-- <div class="container col-md-8 col-md-offset-2">
        <div class="well well bs-component">
        <form class="form-horizontal" method="post" action="{{route('donation.store')}}">
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
                        <legend>Step 2: Enter food details</legend>
                        <div class="form-group">
                            <label for="title" class="col-lg-2 control-label">Name</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <label for="category" class="col-lg-2 control-label">Category</label>
                            <div class="col-lg-10">
                                <select type="text" class="form-control" id="details" name="category">
                                    @isset($categories)
                                    @foreach($categories as $category)
                                    <option value="{{$category->name}}">{{$category->name}}</option>
                                    @endforeach
                                    @endisset
                                </select>
                            </div>
                            <label for="quantityType" class="col-lg-2 control-label">Quantity Type</label>
                            <div class="col-lg-10">
                                <select type="text" class="form-control" id="details" name="quantityType">
                                    <option class="form-control" value="KG">KG</option>
                                    <option class="form-control" value="G">G</option>
                                    <option class="form-control" value="Piece/s">Piece/s</option>
                                </select>
                            </div>
                            <label for="availableDate" class="col-lg-2 control-label">Qunatity</label>
                            <div class="col-lg-10">
                                <input type="number" class="form-control" id="availableDate" name="quantity">
                            </div>
                            <label for="file" class="col-lg-2 control-label">Image</label>
                            <div class="col-lg-10">
                                <input type="file" class="form-control" id="file" name="file">
                            </div>
                        <input type="hidden" class="form-control" id="donationId" name="donationId" value="{{$id}}">
                    </div>
                        
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="reset" class="btn btn-default">Cancel</button
                                >
                                <button type="submit" class="btn btn-primary" >Submit</button>
                            </div>
                        </div>
                    </fieldset>
            </form>
        </div>
    </div> --}}
    <div class="container">    
        <br />
        <legend>Step 2: Enter food item details</legend>
        <br />
      <div class="table-responsive">
                   <form id="dynamic_form" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="token"name="_token" value="{!! csrf_token() !!}">
                    <span id="result"></span>
                    <table class="table table-bordered table-striped" id="user_table">
                  <thead>
                   <tr>
                       <th width="26%">Name</th>
                       <th width="16%">Category</th>
                       <th width="16%">Qunatity Type</th>
                       <th width="6%">Qunatity</th>
                       <th width="26%">Image</th>
                       <th width="6%">Action</th>
                   </tr>
                  </thead>
                  <tbody>
                   
   
                  </tbody>
                  <tfoot>
                   <tr>
                                   <td colspan="5" align="right">&nbsp;</td>
                                   <td>
                     <input type="submit" name="save" id="save" class="btn btn-primary" value="Save" />
                    </td>
                   </tr>
                  </tfoot>
              </table>
                   </form>
      </div>
     </div>
<script>

$(document).ready(function(){

        var count = 1;

        dynamic_field(count);

        function dynamic_field(number)
        {
        
            html = `<tr><td><input type="text" class="form-control" id="name" name="name[]" required></td>
                        <td><select type="number" class="form-control" id="details" name="categoryId[]">
                        @isset($categories)
                        @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                        @endisset
                        </select></td>
                        <td><select type="text" class="form-control" id="details" name="quantityType[]">
                        <option class="form-control" value="KG">KG</option>
                        <option class="form-control" value="Piece/s">Piece/s</option>
                        </select></td>
                        <td><input type="number" class="form-control" id="quantity" name="quantity[]" required></td>
                        <td><input id="file" type="file" class="form-control name="file[]"></td>
                        <input type="hidden" class="form-control" id="donationId" name="donationId[]" value="{{$id}}">`;
            
            if(number > 1)
            {
                html += '<td><button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td></tr>';
                $('tbody').append(html);
            }
            else
            {   
                html += '<td><button type="button" name="add" id="add" class="btn btn-success">Add</button></td></tr>';
                $('tbody').html(html);
            }
        }

        $(document).on('click', '#add', function(){
        count++;
        dynamic_field(count);
        });

        $(document).on('click', '.remove', function(){
        count--;
        $(this).closest("tr").remove();
        });

        

        $('#dynamic_form').on('submit', function(event){
            event.preventDefault();
            var form = document.getElementById("dynamic_form");
            //var form = $('#ynamic_form')[0];
            var data = new FormData(form);
    
            // $.each($("input[type=file]"), function(i, obj) {
            //     $.each(obj.files, function(j, file){
            //         data.append('files['+j+']', file);
            //     });
            // });

            $.each($('input[type=file]'), function(i, value) 
            {
                 data.append('files['+i+']', value.files[0]);
            });
            // for ( var value of data.values()) {
            //     console.log(value); 
            //     }

            $.ajaxSetup({
                 headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                         }
            });
            $.ajax({
                url:"{{ url('foodItem') }}",
                type:'POST',
                data: data ,
                //data: formData,
                dataType:'json',
                contentType: false, 
                processData: false,
                cache: false,
                beforeSend:function(){
                    $('#save').attr('disabled','disabled');
                },
                success:function(data)
                {
                    if(data.error)
                    {
                        var error_html = '';
                        for(var count = 0; count < data.error.length; count++)
                        {
                            error_html += '<p>'+data.error[count]+'</p>';
                        }
                        $('#result').html('<div class="alert alert-danger">'+error_html+'</div>');
                    }
                    else
                    {
                        dynamic_field(1);
                        $('#result').html('<div class="alert alert-success">'+data.success+'</div>');
                    }
                    $('#save').attr('disabled', false);
                }
            })
        });
        

});
    </script>
@endsection