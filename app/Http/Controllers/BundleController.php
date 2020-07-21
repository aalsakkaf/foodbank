<?php

namespace App\Http\Controllers;

use App\Charts\DonationChart;
use App\Bundle;
use App\User;
use App\foodItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\donationNotification;


class BundleController extends Controller
{

    public function __construct()
{
    $this->middleware('role:Student|Admin');
    //$this->middleware('role:Admin');
    //$this->middleware('role:Admin')->only('index');
    //$this->middleware('permission:bundle-list')->only('index');
    //$this->middleware('role:Admin')->only('index');


}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    //    $bundles = Bundle::all();
    //    return view('bundle.index', compact('bundles'));
       if(Auth::user()->roles->pluck( 'name' )->contains( 'Admin' )){
        $bundles = Bundle::all();
        $bundleCollected = Bundle::where('isCollected', true)->count();
        $bundleUncollected = Bundle::where('isCollected', false)->count();
        return view('bundle.index', compact('bundles','bundleCollected','bundleUncollected'));
    }
    else{
        $bundleCollected = Bundle::where('user_id', Auth::user()->id)->where('isCollected', true)->count();
        $bundleUncollected = Bundle::where('user_id', Auth::user()->id)->where('isCollected', false)->count();
        $bundles = Bundle::where('user_id',Auth::user()->id)->get();
        return view('bundle.index', compact('bundles','bundleCollected','bundleUncollected'));
    }    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $foodItems = foodItem::where('quantity', '>', 0)->with('donation.status')->get();
        return view('bundle.create', ['foodItems' => $foodItems]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach($request->get('foodItems') as $id){
           foodItem::whereId($id)->decrement('quantity');
        }
        $bundle = new Bundle();
        $bundle->pickupDate = $request->pickupDate;
        $bundle->note = $request->note;
        $bundle->isCollected = false;
        $bundle->user_id = Auth::user()->id;
        $bundle->save();
        $bundle->foodItems()->sync($request->get('foodItems'), false);

        $user = Auth::user();
        $user->notify(new donationNotification("New Food Bundle", "Thank you for creating a new food bundle"));

        return redirect()->route('bundle.index')->with('status', 'Your food bundle has been created succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function show($bundle)
    {
        $bundles = Bundle::whereId($bundle)->with('foodItems')->get();
        return view('bundle.single', compact('bundles') );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bundle = bundle::whereId($id)->with('foodItems')->firstOrFail();
        $foodItems = foodItem::with('donation.status')->get();
        //dd($foodItems);
        $selectedItems = $bundle->foodItems->pluck('id')->toArray();
        $dt = \DateTime::createFromFormat('Y-m-d H:i:s', $bundle->pickupDate);
        $date = $dt->format('Y-m-d\TH:i:s'); //To change date format so that I can display the default value

        return view('bundle.edit', ['bundle' => $bundle, 'foodItems' => $foodItems, 'selectedItems' => $selectedItems, 'date'=> $date]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $bundle)
    {
         $bundle = Bundle::whereId($bundle)->firstOrFail();
         $bundle->pickupDate = $request->pickupDate;
         $bundle->note = $request->note;
         $bundle->isCollected = false;
         $bundle->user_id = Auth::user()->id;
         $bundle->save();
         $bundle->foodItems()->sync($request->get('foodItems'));

         $selectedItems = $request->get('selectedItems');
        //dd($selectedItems);
        foreach( $selectedItems as $id){
            foodItem::whereId($id)->increment('quantity');;
         }
         foreach($request->get('foodItems') as $id){
            foodItem::whereId($id)->decrement('quantity');;
         }
         $user = Auth::user();
        $user->notify(new donationNotification("Updated Food Bundle", "Thank you for updaing your food bundle"));
         return redirect()->route('bundle.index')->with('status', 'Your food bundle has been updated succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bundle $bundle)
    {
        foreach($bundle->foodItems as $foodItem){
            $foodItem->increment('quantity');
         }
        $bundle->delete();
        
        $user = Auth::user();
        $user->notify(new donationNotification("Deleted Food Bundle", "your food bundle was deleted"));
       return redirect()->route('bundle.index')->with('bundle.index')->with('status', 'Food Bundle has been deleted!');
    }
   

    public function collect($id)
    {
       $bundle = Bundle::whereId($id)->firstOrFail();
       $bundle->isCollected = TRUE;
       $bundle->save();
       return back()->with('status', 'Food Bundle has been collected and delivered successfully!');
    }

    
}
