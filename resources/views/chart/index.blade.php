@extends('layouts.master')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container">
            <div class="row">
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-info">
                    <div class="inner">
                    
                    <h3>{{$donation}}</h3>
        
                      <p>Donations</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-success">
                    <div class="inner">
                      <h3>{{$foodItem}}</h3>
        
                      <p>Food Items</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-carrot"></i>
                    </div>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-warning">
                    <div class="inner">
                      <h3>{{$user}}</h3>
        
                      <p>Users</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-person-add"></i>
                    </div>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-danger">
                    <div class="inner">
                      <h3>{{$category}}</h3>
        
                      <p>Food Categories</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-pie-graph"></i>
                    </div>
                  </div>
                </div>
                <!-- ./col -->
              </div>
              <div class="row">
            <div class="col-md-6">
                
                <div class="card card-danger " style="max-width: 30rem;">
                    <div class="card-header">
                      <h3 class="card-title">Food Categories By Number of Food Items</h3>
                    </div>
                    <div class="card-body">
                    <div style="">
                        {!! $chartjs->render() !!}
                    </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-success" style="max-width: 30rem;">
                    <div class="card-header">
                      <h3 class="card-title">Donations Number</h3>
                    </div>
                    <div class="card-body">
                        <div style="">
                            {!! $lineChart->render() !!}
                        </div>
                    </div>
                  </div>
            </div>
        </div>            
                        
    
                    
    
    </div>
   <script>

</script>
@endsection