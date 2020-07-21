@extends('layouts.master')

@section('title', 'Online Payment')

@section('content')
<div class="container">
  <br>
    <h4 style="text-align: center">Online Payment to FoodBank</h4>
  
    <div class="row align-items-center h-100">
        <div class="col-md-6 col-md-offset-3 mx-auto">
            <div class="card  credit-card-box card-block " >
                <div class="card-header display-table" >
                    <div class="row display-tr" >
                        <h3 class="card-title display-td" >Payment Details</h3>
                        <div class="display-td" >                            
                            <img class="img-fluid float-right" src="http://i76.imgup.net/accepted_c22e0.png">
                        </div>
                    </div>                    
                </div>
                <div class="card-body">
  
                    @foreach ($errors->all() as $error)
                    <p class="alert alert-danger">{{ $error }}</p>
                @endforeach
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                 @endif
  
                    <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation"
                                                     data-cc-on-file="false"
                                                    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                                                    id="payment-form">
                        @csrf
  
                        <div class='form-row'>
                            <div class='col-sm-12 form-group required'>
                                <label class='col-form-label'>Name on Card</label> <input
                                    class='form-control' size='4' type='text'>
                            </div>
                        </div>

                        <div class='form-row'>
                            <div class='col-sm-12 form-group  required'>
                                <label class='col-form-label'>Card Number</label> <input
                                    class='form-control card-number' size='20' type='text' id="credit-card">
                            </div>
                        </div>
  
                        <div class='form-row'>
                            <div class='col-sm-12 col-md-4 form-group cvc required'>
                                <label class='col-form-label'>CVC</label> <input autocomplete='off'
                                    class='form-control card-cvc' placeholder='ex. 311' size='4'
                                    type='text'>
                            </div>
                            <div class='col-sm-12 col-md-4 form-group expiration required'>
                                <label class='col-form-label'>Expiration Month</label> <input
                                    class='form-control card-expiry-month' placeholder='MM' size='2'
                                    type='text'>
                            </div>
                            <div class='col-sm-12 col-md-4 form-group expiration required'>
                                <label class='col-form-label'>Expiration Year</label> <input
                                    class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                    type='text'>
                            </div>
                        </div>

                        <div class='form-row'>
                            <div class='col-sm-12 form-group  required'>
                                <label class='col-form-label'>Donation Amount</label> <input
                                    class='form-control amount' size='20' type='text' placeholder="MYR" name="amount" required>
                            </div>
                        </div>
  
                        <div class='form-row'>
                            <div class='col-md-12 error form-group' style="display: none;">
                                <div class='alert-danger alert'>Please correct the errors and try
                                    again.</div>
                            </div>
                        </div>
  
                        <div class="row">
                            <div class="col-sm-12">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now</button>
                            </div>
                        </div>
                          
                    </form>
                </div>
            </div>        
        </div>
    </div>
      
</div>
@endsection