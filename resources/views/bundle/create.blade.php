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
    <h5>Please choose Items to create your bundle</h5>
    <div class="row">
            <form action="{{route('bundle.store')}}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="pickupDate" class="col-sm-2 col-form-label">Pickup Date</label>
                    <div class="col-sm-10">
                      <input type="datetime-local" class="form-control" name="pickupDate">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="pickupDate" class="col-sm-2 col-form-label">Note:</label>
                    <div class="col-sm-10">
                        <textarea name="note" class="form-control" placeholder="Note Body" rows="5" cols="40"></textarea>
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
            <td><input type="checkbox" name="foodItems[]" value="{{$foodItem->id}}"></td>
        </tr>
        @endif
             @endforeach
        @endisset
        </tbody>
    </table>
    <div class="form-group row">
    <div class="col-sm-12">
        <button type="submit" id="submit" class="btn btn-primary float-right">Submit</button>
    </div>
    </div>
</form>
</div>
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