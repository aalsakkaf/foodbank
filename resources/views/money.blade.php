@extends('layouts.master')

@section('title', 'Money Donations')

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
        <br />
        <div class="row">
          @isset($moneyNumber)
            <div class="col-lg-6 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                  <h3>{{$moneyNumber}}</h3>
                    <p>Money Donation</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                  </div>
                </div>
              </div>
              @endisset
              @isset($points)
            <div class="col-lg-6 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                <h3>{{$points}}</h3>
    
                  <p>Reward Points</p>
                </div>
                <div class="icon">
                    <i class="fas fa-gift"></i>
                </div>
              </div>
            </div>
            @endisset 
     </div>
      <div class="Tablewrapper" style="margin: 0 auto; width: 100%;">                   
        <table id="moneyTable" class="table table-hover display" style="width: 100%;">
                  <thead>
                   <tr>
                       @role('Admin')
                       <th >Donor name</th>
                       @endrole
                       <th >Amount</th>
                       <th >Date</th>
                   </tr>
                  </thead>
                  @if(!$data->isEmpty())
                @foreach($data as $money)  
                  <tbody>
                <tr>
                @role('Admin')
                <td>{{$money->user->name}}</td>
                @endrole
                <td>{{$money->amount}}</td>
                <td>{{$money->created_at}}</td>
                </tr>
                </tbody>
                @endforeach
                  <tfoot>
                   <tr>
                                   <td colspan="1" allign="right">&nbsp;</td>
                                   @role('Admin')<td >&nbsp;</td>@endrole
                    <td>
                    <a style="width: 100%" class="btn btn-primary" href="{{url('money/create')}}" >Add More</a>
                    </td>
                   </tr>
                  </tfoot>
              </table>
              @else
                  <p>No Money Donation found</p>
              @endif
    </div>
</div>
      
<script>

$(document).ready(function(){
        $('#moneyTable').DataTable();
});
</script>
@endsection