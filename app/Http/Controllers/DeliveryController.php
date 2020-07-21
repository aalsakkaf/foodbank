<?php

namespace App\Http\Controllers;

use App\Delivery;
use App\Donation;
use App\Status;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Notifications\donationNotification;



class DeliveryController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Volunteer|Admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $donations = Donation::doesntHave('delivery')->get();
        //dd($donations);
        return view('delivery.index', ['donations' => $donations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('delivery.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $donation = Donation::whereId($request->donation_id)->firstOrFail();
        $donation->status_id = Status::where('name', 'Ready for Pickup')->first()->id;
        $donation->save();
        
        $delivery = new Delivery();
        $delivery->note = $request->note;
        $delivery->pickupDate = $request->pickupDate;
        $delivery->user_id = $request->user()->id;
        $delivery->donation_id = $request->donation_id;
        $delivery->save();

        $user = User::find($donation->user_id);
        $user->notify(new donationNotification("Donation Status", "your donation status was updated to Ready for Pickup"));

        return back()->with('status', 'Your pickup request has been placed succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function show(Delivery $delivery)
    {
        //
    }

    public function show_past_food_pickup(){
        $dt = Carbon::now()->toDateString();
        // $deliveries = Delivery::where('pickupDate', '<', $dt)->with('donation', 'donation.status')->where('name', '<>','Delivered')->get();
        //$deliveries = Delivery::where('pickupDate', '<', $dt)->with('donation.status')->get();

        if(Auth::user()->roles->pluck( 'name' )->contains( 'Admin' )){
            $deliveries = Delivery::where('pickupDate', '<', $dt)->with('donation.status')->get();
            return view('delivery.past', ['deliveries' => $deliveries]);
        }
        else{
            $deliveries = Delivery::where('pickupDate', '<', $dt)->where('user_id',Auth::user()->id)->with('donation.status')->get();
            return view('delivery.past', ['deliveries' => $deliveries]);
        }

        
    }
    public function show_upcoming_food_pickup(){
        $dt = Carbon::now()->toDateString();

        if(Auth::user()->roles->pluck( 'name' )->contains( 'Admin' )){
            $deliveries = Delivery::where('pickupDate', '>', $dt)->with('donation.status')->get();
            return view('delivery.upcoming', ['deliveries' => $deliveries]);
        }
        else{
            $deliveries = Delivery::where('pickupDate', '>', $dt)->where('user_id',Auth::user()->id)->with('donation.status')->get();
            return view('delivery.upcoming', ['deliveries' => $deliveries]);
        }
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function edit(Delivery $delivery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $delivery = Delivery::whereId($id)->firstOrFail();
        $delivery->note = $request->note;
        $delivery->pickupDate = $request->pickupDate;
        $delivery->user_id = $request->user()->id;
        $delivery->donation_id = $request->donation_id;
        $delivery->save();

        return back()->with('status', 'Your pickup request has been placed succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delivery = Delivery::whereId($id)->firstOrFail();
        $donation = Donation::whereId($delivery->donation_id)->firstOrFail();
        $donation->status = Status::where('name', 'Pending')->first()->id;
        $donation->save();
        Delivery::destroy($id);
        
        $user = User::find($donation->user_id);
        $user->notify(new donationNotification("Pickup request Deleted", "your donation pickup request was deleted."));
        
        return back()->with('status', 'Your pickup request has been cancelled succesfully');

    }
    public function collect($id)
    {
       $donation = Donation::whereId($id)->firstOrFail();
       $donation->status_id = Status::where('name', 'Delivered')->first()->id;
       //dd($donation->status_id);
       $donation->save();

        $user = User::find($donation->user_id);
        $user->notify(new donationNotification("Donation Status", "your donation status was picked up and delivered succesfully."));

       return back()->with('status', 'Donation has been collected and delivered successfully!');
    }
}
