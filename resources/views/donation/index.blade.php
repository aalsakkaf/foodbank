@extends('layouts.master')

@section('title', 'All Donations')

@section('content')
<form id="deleteForm" method="POST" >
@method('DELETE')
@csrf
<div id="deleteDonation" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <div class="modal-body">
                
                    <input type="hidden" class="form-control" id="id" name="id" >
                <p>Do you really want to delete this donation? This process cannot be undone.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>
</form>


<div class="container">
    @foreach ($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p>
            @endforeach
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
             @endif           
             <div class="row">
                 @isset($points)
                <div class="col-lg-3 col-3">
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
                  @isset($donationsNumber)
                <div class="col-lg-3 col-3">
                    <!-- small box -->
                    <div class="small-box bg-info">
                      <div class="inner">
                      <h3>{{$donationsNumber}}</h3>
          
                        <p>Number of Donations</p>
                      </div>
                      <div class="icon">
                        <i class="fas fa-hand-holding-heart"></i>
                      </div>
                    </div>
                  </div>
                  @endisset
                <div class="col-lg-3 col-3">
                  <!-- small box -->
                  <div class="small-box bg-info">
                    <div class="inner">
                    <h3>{{$donationPending}}</h3>
        
                      <p>Pending</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-recycle"></i>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-3">
                  <!-- small box -->
                  <div class="small-box bg-info">
                    <div class="inner">
                    <h3>{{$donationDelivered}}</h3>
        
                      <p>Ready-for-pickup</p>
                    </div>
                    <div class="icon">
                        <i class="fab fa-superpowers"></i>
                    </div>
                  </div>
                </div>
                
                <div class="col-lg-3 col-3">
                  <!-- small box -->
                  <div class="small-box bg-info">
                    <div class="inner">
                    <h3>{{$donationReady}}</h3>
        
                      <p>Delivered</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-truck"></i>
                    </div>
                  </div>
                </div>     
         </div>
    <div class="Tablewrapper" style="margin: 0 auto; width: 100%;">
        <table id="donationTable" class="table" style="width:100%;">
            <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Donor</th>
                    <th scope="col">Date of Creation</th>
                    <th scope="col">Availability Date & Time</th>
                    <th scope="col">Food Item</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
        <tbody>
    @if(!$donations->isEmpty())
    @foreach($donations as $donation)
        <tr>
            <td>{{$donation->title}}</td>
            <td>{{$donation->user->name}}</td>
            <td>{{$donation->created_at}}</td>
            <td>{{$donation->availableDate}}</td>
            <td style="padding:0;">
                <table class="table table-borderless" style="padding: 0;border:0;margin:0;">
                @foreach ($donation->foodItems as $foodItem)
                     <tr >
                         <td style="padding: 0;border:0;">{{$foodItem->name}}</td>
                     </tr>
                @endforeach
            </table>   

            </td>
            <td>{{$donation->status->name}}</td>
        <td><a class="btn btn-info" href="{{url('donation/'.$donation->id )}}">Details</a>|<a class="btn btn-primary" href="{{url('donation/'.$donation->id .'/edit'  )}}">Edit</a>|<a class="btn btn-danger text-white" data-toggle="modal" data-target="#deleteDonation" data-url="{{route('donation.destroy', $donation)}}" data-whatever="{{$donation}}">Delete</a></td>
        </tr>
    @endforeach
    @else
    <tr>
        <td>No Record Found</td>
    </tr>
    @endif
        </tbody>
    </table>
</div>
<br>
    <div class="row">
        <div class="col-12">
        <a href="{{url('donation/create')}}" class="btn btn-success float-right">Create new Donation</a>
        </div>
    </div>
    <br>
</div>   
    <script>
        $(document).ready(function() {
        var table = $('#donationTable').DataTable({
            lengthChange: false,
            buttons: [
                {
                extend: 'pdfHtml5',
                customize: function(doc) {
                    doc.styles.tableBodyEven.alignment = 'center';
                    doc.styles.tableBodyOdd.alignment = 'center'; 
                    },
                exportOptions: {
                    pageSize: 'A4',
                    columns: [ 0, 1, 2,3,4,5 ],
                    
                    
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    pageSize: 'A4',
                    columns: [ 0, 1, 2,3,4,5 ]
                }
            },
            {
                extend: 'excel',
                exportOptions: {
                    pageSize: 'A4',
                    columns: [ 0, 1, 2,3,4,5 ]
                }
            },
        ]
    });
        table.buttons().container()
        .appendTo( '#donationTable_wrapper .col-md-6:eq(0)' );
        
    $('.buttons-pdf, .buttons-excel, .buttons-csv').each(function() {
   $(this).removeClass('btn-secondary').addClass('btn-primary')
});
} );
$('#deleteDonation').on('show.bs.modal', function (event) {
        var edit = $(event.relatedTarget); // Button that triggered the modal
        var item = edit.data('whatever'); // Extract info from data-* attributes
        var modal = $(this);
        
        modal.find('.modal-body input#id').val(item.id);
        var url = edit.data('url');
        $('#deleteForm').attr('action', url);
    });
    </script>
@endsection
