<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Money;
use Illuminate\Support\Facades\Auth;
use App\Notifications\donationNotification;



class StripePaymentController extends Controller
{
    public function __construct()
    {
   
        $this->middleware('role:Donor|Admin');
    }
    public function index(){
        if(Auth::user()->roles->pluck( 'name' )->contains( 'Admin' )){
            $data = Money::all();
            $moneyNumber = Money::where('user_id', Auth::user()->id)->count();
           return view('money', compact('data','moneyNumber'));
        }
        else{
            $data = Money::where('user_id',Auth::user()->id)->with('rewardPoint','user')->get();
            $points = $data->sum('rewardPoint.points');
            $moneyNumber = Money::where('user_id', Auth::user()->id)->count();
            return view('money', compact('data', 'points', 'moneyNumber'));
        }    
        return view('money');
    }
    public function stripe()
    {
        return view('stripe');
    }
  
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => $request->amount * 100,
                "currency" => "MYR",
                "source" => $request->stripeToken,
                "description" => "Money Donation to FoodBank" 
        ]);
  
        Session::flash('success', 'Payment successful!');
            $moneyDonation = new Money();
            $moneyDonation->amount = $request->amount;
            $moneyDonation->user_id = Auth::user()->id;
            $moneyDonation->save();

            $user = Auth::user();
            $user->notify(new donationNotification("New Money Donation", "Thank you for making a new money donation"));
        return back();
    }
}
