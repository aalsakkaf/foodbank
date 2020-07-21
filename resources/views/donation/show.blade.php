@extends('layouts.master')

@section('title', 'Show Donation')

@section('content')
  <div  class="modal fade" id="deleteDonation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <div class="modal-body">
                @isset($donation)
                <form method="POST" action="{{route('donation.destroy',  $donation)}}" >
                    @method('DELETE')
                    @csrf
                    <input type="hidden" class="form-control" id="id" name="id" >
                <p>Do you really want to delete this donation? This process cannot be undone.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
        @endisset
        </div>
    </div>
</div>
    @foreach ($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p>
    @endforeach
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
             @endif
    <div class="container">

        <!-- Portfolio Item Heading -->
        <h3 class="my-4" style="text-align: center">{{$donation->title}}
        </h3>
        <!-- Portfolio Item Row -->
        <div class="row">
      
          <div class="col-md-6 mt-5">
            <div class="card">
              <div class="card-header">
                Donation Details
              </div>
              <div class="card-body">
            <ul>
              <li>Donor: {{$donation->user->name}}</li>
              <li>Date of Creation: {{$donation->created_at}}</li>
              <li>Availability Date & Time: {{$donation->availableDate}}</li>
              <li>Status: {{$donation->status->name}}</li>
              <li>Address: {{$donation->location->address}}</li>
            </ul>
            <p>Note: {{$donation->details}}</p>
            @hasanyrole('Admin|Donor')
            <a class="btn btn-primary" href="{{route('donation.edit' ,$donation->id )}}">Edit</a> <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteDonation" data-whatever="{{$donation}}">Delete</button>
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#addItem" data-whatever="{{''}}">Add more Items</button>
            @endhasanyrole
            </div>
          </div>
        </div> 
          
          <div class="col-md-6 mt-5">
              <div class="card">
                      <div class="card-header">
                        Donation Location
                      </div>
                      <div class="card-body">
                        <div id="map" class="z-depth-1-half " style="width: 100%">
                        </div>
                      </div>
                    </div>  
                </div>  
      </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                List of Items
              </div>
              <div class="card-body">
                <table id="itemTable"class="table table-hover table-sm" style="table-layout: fixed; border-collapse: collapse;
        border-spacing: 0;">
            <thead>
            <tr>
                <th scope="col" style="text-align:center">Image</th>
                <th scope="col">Item Name</th>
                <th scope="col">Food Category</th>
                <th scope="col">Quantity Type</th>
                <th scope="col">Quantity</th>
                <th scope="col">Submission Date</th>
                @hasanyrole('Admin|Donor')<th scope="col"></th>@endhasanyrole
            </tr>
            </thead>
            <tbody>
              @if(!$donation->foodItems->isEmpty())
              @foreach($donation->foodItems as $foodItem )
            <tr>
                <td ><img style="display:block; width:50%; height:auto; margin: 0 auto;" src="{{asset('storage/'.$foodItem->photoURL)}}"></td>
                <td >{{$foodItem->name}}</td>
                <td >{{$foodItem->foodCategory->name}}</td>
                <td >{{$foodItem->quantityType}}</td>
                <td >{{$foodItem->quantity}}</td>
                <td >{{$foodItem->created_at}}</td>
                @hasanyrole('Admin|Donor')
                <td>
                  <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editItem" data-whatever="{{$foodItem}}">Edit</button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-whatever="{{$foodItem}}">Remove</button>
                </div>
                </td>
                @endhasanyrole
             </tr>
              @endforeach
              @else
              <tr>
                <td>No Food Items found</td>
             </tr>
             @endif
              </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
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
                <option class="form-control" value="{{$category->id}}">{{ $category->name }}</option> 
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
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{old('quantity')}}">
              </div>
              <div class="form-group">
                <label for="name">Image:</label>
              <input type="file" class="form-control" id="file" name="files">
              </div>
              <input type="hidden" class="form-control" id="donationId" name="donationId" value="{{$donation->id}}">
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
                @isset($foodItem)
                <form method="POST" action="{{route('foodItem.update', $foodItem)}}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name',$foodItem->name)}}">
              </div>
              <div class="form-group">
                <label for="name">Category:</label>
                <select type="number" class="form-control" id="category"  name="categoryId">
                        @isset($categories)
                        @foreach($categories as $category)
                        <option class="form-control" value="{{old('categoryId',$category->id) }}">{{ $category->name }}</option> 
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
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{old('quantity',$foodItem->quantity)}}">
              </div>
              <div class="form-group">
                <label for="name">Image:</label>
              <input type="file" class="form-control" id="file" name="files">
              </div>
              <input type="hidden" class="form-control" id="donationId" name="donationId" value="{{$donation->id}}">
              <input type="hidden" class="form-control" id="id" name="id" value="{{old('id',$foodItem->id)}}">

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
        @endisset
          </div>
        </div>
      </div>


     <div  class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                </div>
                <div class="modal-body">
                    @isset($foodItem)
                    <form method="POST" action="{{route('foodItem.destroy',  $foodItem)}}" >
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
            @endisset
            </div>
        </div>
    </div>
    
    
  

   

<script>
$(document).ready(function(){
    var map = L.map('map').setView([1.4599, 110.4883], 12);
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1Ijoia2FhazIzMiIsImEiOiJja2I2aWR2NmIxZmFvMnZwN3p4YW1oeDB1In0.mB59_cpC-awJUFDXMRYC8A'
}).addTo(map);
L.marker([ {{$donation->location->latitude}}, {{$donation->location->longitude}}], {autopan: true}).addTo(map);
map.setView([{{$donation->location->latitude}}, {{$donation->location->longitude}}], 14);

$('#editItem').on('show.bs.modal', function (event) {
        var edit = $(event.relatedTarget); // Button that triggered the modal
        var item = edit.data('whatever'); // Extract info from data-* attributes
        var modal = $(this);
        modal.find('.modal-title').val(' (' + item.name + ')');
        modal.find('.modal-body input#name').val(item.name);
        modal.find('.modal-body input#quantity').val(item.quantity);
        modal.find('.modal-body input#donationId').val({{$donation->id}});
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
        
        modal.find('.modal-body input#donationId').val({{$donation->id}});
    });
    $('#deleteModal').on('show.bs.modal', function (event) {
        var edit = $(event.relatedTarget); // Button that triggered the modal
        var item = edit.data('whatever'); // Extract info from data-* attributes
        var modal = $(this);
        
        modal.find('.modal-body input#id').val(item.id);
    });

    $('#deleteDonation').on('show.bs.modal', function (event) {
      //console.log(event.relatedTarget);
        var edit = $(event.relatedTarget); // Button that triggered the modal
        var item = edit.data('whatever'); // Extract info from data-* attributes
        //console.log($event.relatedTarget);
        var modal = $(this);
        
        modal.find('.modal-body input#id').val(item.id);
    });

    $('#itemTable').DataTable();
});

</script>
@endsection