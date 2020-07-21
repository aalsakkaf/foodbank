@extends('layouts.master')

@section('title', 'Collect Request')

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
    <h5>Please choose of Items to create your bundle</h5>
            <form action="{{route('bundle.update', $bundle->id)}}" method="POST">
                @method('PUT')
                @csrf
                <div class="form-group row">
                    <label for="pickupDate" class="col-sm-2 col-form-label">Pickup Date</label>
                    <div class="col-sm-10">
                    <input type="datetime-local" class="form-control" name="pickupDate" value="{{$date}}">
                    @foreach ($selectedItems as $item)
                    <input type="hidden" class="form-control" name="selectedItems[]" value="{{$item}}">
                    @endforeach

                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="pickupDate" class="col-sm-2 col-form-label">Note:</label>
                    <div class="col-sm-10">
                    <textarea name="note" class="form-control" placeholder="Note Body" rows="5" cols="40">{{$bundle->note}}</textarea>
                    </div>
                  </div>
    <table id="table" class="table table-hover table-sm" style="table-layout: fixed; border-collapse: collapse;
    border-spacing: 0;">
        <thead>
        <tr>
            <th scope="col" style="text-align:center">Image</th>
            <th scope="col">Item Name</th>
            <th scope="col">Category</th>
            <th scope="col"></th>

        </tr>
        </thead>
        <tbody>
        @isset($foodItems)
        @foreach($foodItems as $foodItem)
        @if($foodItem->donation->status->name == "Delivered")   
        <tr>
            <td ><img style="display:block; width:50%; height:auto; margin: 0 auto;" src="{{asset('storage/'.$foodItem->photoURL)}}"></td>
            <td >{{$foodItem->name}}</td>
            <td >{{$foodItem->foodCategory->name}}</td>
            <td><input type="checkbox" name="foodItems[]" value="{{$foodItem->id}}" @if(in_array
                ($foodItem->id, $selectedItems))
                checked @endif></td>
        </tr>
        @endif
             @endforeach
        @endisset

        </tbody>
        <tfoot>
            
        </tfoot>
    </table>
    <div class="form-group row">
    <div class="col-sm-12">
        <button type="submit" id="submit" class="btn btn-primary float-right">Submit</button>
    </div>
    </div>
</form>
</div>


    <script>
       var length = document.getElementById("table").rows.length;
       if (length < 2)
       {
        //console.log(length);
        html = '<tr><td colspan="3" align = "center"><strong>No Food Items found, please try again later</strong></td></tr>';
        $('tbody').append(html);
        $('#submit').attr('disabled','disabled');
       }

    </script>
@endsection