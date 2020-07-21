@extends('layouts.master')

@section('title', 'Edit Food Item')

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
        <br />
      <div class="table-responsive">                   
                    <table class="table table-bordered table-striped" id="user_table">
                  <thead>
                   <tr>
                       <th width="21%">Name</th>
                       <th width="12%">Category</th>
                       <th width="10%">Qunatity Type</th>
                       <th width="6%">Qunatity</th>
                       <th width="32%">Image</th>
                       <th width="15%">Action</th>
                   </tr>
                  </thead>
                  <tbody>
                    @if(!$items->isEmpty())
                    @foreach($items as $item)
                <tr>
                <tr><td>{{$item->name}}</td>
                <td>{{$item->foodCategory->name}}</td>
                <td>{{$item->quantityType}}</td>
                <td>{{$item->quantity}}</td>
                <td style="vertical-align:middle; text-align:center;"><img style="display:block; width:80%; height:auto; margin:0 auto;" src="{{asset('storage/'.$item->photoURL)}}"></td>
                <td><button type="button" id="edit" class="btn btn-primary"  data-toggle="modal" data-target="#editItem" data-whatever="{{$item}}">Edit</button> | <a class="btn btn-danger" data-toggle="modal" href="#deleteModal" data-whatever="{{$item}}">Delete</a> </td>

                </tr>
                     @endforeach
                    @else
                    <tr>
                        <td>No Food items found</td>
                    </tr>
                    @endif
   
                  </tbody>
                  <tfoot>
                   <tr>
                                   <td colspan="5" allign="right">&nbsp;</td>
                    <td>
                    <button style="width: 100%" type="button" id="add" class="btn btn-primary" data-toggle="modal" data-target="#addItem" data-whatever="{{''}}">Add More</button>
                    </td>
                   </tr>
                  </tfoot>
              </table>
                   
      </div>
      <div class="modal fade" id="addItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">ADD FOOD ITEM</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            
              <form method="POST"  action="{{route('foodItem.store' )}}" enctype="multipart/form-data">
                
                @csrf
                <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name')}}">
              </div>
              <div class="form-group">
                <label for="name">Category:</label>
                <select type="number" class="form-control" id="category"  name="categoryId">
                        @isset($categories)
                        @foreach($categories as $category)
                <option class="form-control" value="{{$category->id}}"}}>{{ $category->name }}</option> 
                        @endforeach
                        @endisset
                        </select>
              </div>
              <div class="form-group">
                <label >Qunatity Type:</label>
                <select type="text" class="form-control" id="qunatityType" name="quantityType">
                    <option class="form-control" value="KG" >KG</option>
                    <option class="form-control" value="Piece/s">Piece/s</option>
                    </select>
              </div>
              <div class="form-group">
                <label for="name">Qunatity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{old('quantity')}}">
              </div>
              <div class="form-group">
                <label for="name">Image:</label>
              <input type="file" class="form-control" id="file" name="files">
              </div>
              <input type="hidden" class="form-control" id="donationId" name="donationId" value="{{Session::get('donationId')}}">
              <input type="hidden" class="form-control" id="id" name="id" value="{{old('id')}}">

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
          </div>
        </div>
      </div>

      <div class="modal fade" id="editItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">EDIT THIS FOOD ITEM</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                
                <form method="POST" action="{{route('foodItem.update', $item)}}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name',$item->name)}}">
              </div>
              <div class="form-group">
                <label for="name">Category:</label>
                <select type="number" class="form-control" id="category"  name="categoryId">
                        @isset($categories)
                        @foreach($categories as $category)
                        <option class="form-control" value="{{old('categoryId',$category->id) }}"}}>{{ $category->name }}</option> 
                        @endforeach
                        @endisset
                        </select>
              </div>
              <div class="form-group">
                <label >Qunatity Type:</label>
                <select type="text" class="form-control" id="qunatityType" name="quantityType">
                    <option class="form-control" value="KG" >KG</option>
                    <option class="form-control" value="G" >G</option>
                    <option class="form-control" value="Piece/s">Piece/s</option>
                    </select>
              </div>
              <div class="form-group">
                <label for="name">Qunatity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{old('quantity',$item->quantity)}}">
              </div>
              <div class="form-group">
                <label for="name">Image:</label>
              <input type="file" class="form-control" id="file" name="files">
              </div>
              <input type="hidden" class="form-control" id="donationId" name="donationId" value="{{Session::get('donationId')}}">
              <input type="hidden" class="form-control" id="id" name="id" value="{{old('id',$item->id)}}">

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
          </div>
        </div>
      </div>

     </div>

     <div id="deleteModal" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('foodItem.destroy', $item)}}" >
                        @method('DELETE')
                        @csrf
                        <input type="hidden" class="form-control" id="id" name="id" >
                    <p>Do you really want to delete this item? This process cannot be undone.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
            </div>
        </div>
    </div>    
      
<script>

$(document).ready(function(){
    $('#editItem').on('show.bs.modal', function (event) {
        var edit = $(event.relatedTarget); // Button that triggered the modal
        var item = edit.data('whatever'); // Extract info from data-* attributes
        var modal = $(this);
        modal.find('.modal-title').val(' (' + item.name + ')');
        modal.find('.modal-body input#name').val(item.name);
        modal.find('.modal-body input#quantity').val(item.quantity);
        modal.find('.modal-body input#donationId').val({{Session::get('donationId')}});
        modal.find('.modal-body input#id').val(item.id);

        $('select#category option').each(function(){
        if ($(this).val() == item.category_id){
            $(this).attr("selected","selected");
                }
            });
            $('select#qunatityType option').each(function(){
        if ($(this).val() == item.quantityType){
            $(this).attr("selected","selected");
                }
            });
    });
    $(".modal").on("hidden.bs.modal", function(){ //to clear all variables displayed when closed and reopen
        $(".modal-body1").html("");
        //$(".modal-body").html(""); wrong

    });

    $('#addItem').on('show.bs.modal', function (event) {
        var edit = $(event.relatedTarget); // Button that triggered the modal
        var item = edit.data('whatever'); // Extract info from data-* attributes
        var modal = $(this);
        
        modal.find('.modal-body input#donationId').val({{Session::get('donationId')}});
    });
    $('#deleteModal').on('show.bs.modal', function (event) {
        var edit = $(event.relatedTarget); // Button that triggered the modal
        var item = edit.data('whatever'); // Extract info from data-* attributes
        var modal = $(this);
        
        modal.find('.modal-body input#id').val(item.id);
    });


});
    </script>
@endsection