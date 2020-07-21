<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donation;
use App\Status;
use App\Location;
use App\FoodCategory;
use App\rewardPoint;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\foodItem;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\donationNotification;
use App\Http\Resources\DonationCollection;



class DonationController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Donor|Admin')->except('chartSample1', 'show','apiIndex');
    }

    public function index()
    {
        if(Auth::user()->roles->pluck( 'name' )->contains( 'Admin' )){
            
             $donationPending = Donation::whereHas('status', function ($query) {
                $query->where('name', 'Pending');
            })->count();
            $donationDelivered = Donation::whereHas('status', function ($query) {
                $query->where('name', 'Delivered');
            })->count();
            $donationReady = Donation::whereHas('status', function ($query) {
                $query->where('name', 'Ready for Pickup');
            })->count();

            $donations = Donation::with('foodItems')->get();
            $donationsNumber = Donation::with('foodItems')->count();
            return view('donation.index', ['donations' => $donations, 'donationPending' => $donationPending, 'donationDelivered'=> $donationDelivered, 'donationReady'=> $donationReady, 'donationsNumber'=> $donationsNumber]);
        }
        else{
             //return $donationStatus = Donation::where('user_id', Auth::user()->id)->withCount('status')->get();
            $donationsX = Donation::where('user_id',Auth::user()->id )->with('rewardPoint')->get();
            $points = $donationsX->sum('rewardPoint.points');
            $donationPending = Donation::where('user_id',Auth::user()->id)->whereHas('status', function ($query) {
                $query->where('name', 'Pending');
            })->count();
            $donationDelivered = Donation::where('user_id',Auth::user()->id)->whereHas('status', function ($query) {
                $query->where('name', 'Delivered');
            })->count();
            $donationReady = Donation::where('user_id',Auth::user()->id)->whereHas('status', function ($query) {
                $query->where('name', 'Ready for Pickup');
            })->count();
            $donations = Donation::where('user_id',Auth::user()->id)->with('foodItems')->get();
            return view('donation.index', ['donations' => $donations, 'donationPending' => $donationPending, 'donationDelivered'=> $donationDelivered, 'donationReady'=> $donationReady, 'points'=> $points]);
        }
        
    }

    public function create()
    {
        return view('donation.create');
    }

    public function store(Request $request)
    {
        $location = new Location;
        $location->address = $request->address;
        $location->longitude= $request->lng;
        $location->latitude= $request->lat;
        $location->save();
        //dd($location->id);

        $status = Status::where('name', 'Pending')->first();
        $rewardPoint = rewardPoint::where('name', 'Food Donation')->first();

        $donation = new Donation;
        $donation->title = $request->title;
        $donation->details = $request->details;
        $donation->availableDate = $request->availableDate;
        $donation->user_id = $request->user()->id;
        $donation->location()->associate($location);
        $donation->status_id = $status->id;
        $donation->rewardPoint_id = $rewardPoint->id;
        $donation->save();

        $user = Auth::user();
        $user->notify(new donationNotification("New Donation", "Thank you for creating a new donation"));

        //return back()->with('status', 'The donation has been added succesfully!');
        return redirect()->route('foodItem.create', ['id' => $donation->id]);
    }

    public function show($id)
    {
        
        $donation = Donation::whereId($id)->with('foodItems')->firstOrFail();
        $categories = FoodCategory::all();
        //dd($donation);
        return view('donation.show', ['donation' => $donation, 'categories' => $categories]);
    }
    public function edit($id)
    {
        $donation = Donation::whereId($id)->firstOrFail();
        $dt = \DateTime::createFromFormat('Y-m-d H:i:s', $donation->availableDate);
        $date = $dt->format('Y-m-d\TH:i:s'); //To change date format so that I can display the default value
        return view('donation.edit', ['donation' => $donation, 'date' => $date]);
        
    }
    public function update(Request $request, Donation $donation)
    {
        //dd($request);
        $location = Location::whereId($donation->location_id)->firstOrFail();
        $location->address = $request->address;
        $location->longitude= $request->lng;
        $location->latitude= $request->lat;
        $location->save();
        //dd($location->id);

        $status = Status::where('name', 'Pending')->first();
        $rewardPoint = rewardPoint::where('name', 'Food Donation')->first();


        $donation = Donation::whereId($donation->id)->firstOrFail();
        $donation->title = $request->title;
        $donation->details = $request->details;
        $donation->availableDate = $request->availableDate;
        $donation->user_id = $request->user()->id;
        $donation->location()->associate($location);
        $donation->status_id = $status->id;
        $donation->rewardPoint_id = $rewardPoint->id;
        $donation->save();

        $user = Auth::user();
        $user->notify(new donationNotification("Updated Donation", "Thank you for updating your donation"));

        //return back()->with('status', 'The donation has been added succesfully!');
        return redirect()->route('donation.show', $donation->id);
    }

    public function destroy(Donation $donation)
    {
       $donation->delete();
        $user = Auth::user();
        $user->notify(new donationNotification("Deleted Donation", "your donation was deleted"));
       return redirect()->route('donation.index')->with('status', 'Donation has been deleted!');
    }

    public function chartSample1()
    {
        
            $donationNumber = Donation::all()->count();
            $foodItemNumber = foodItem::all()->count();
            $userNumber = User::all()->count();
            $categoryNumber = FoodCategory::all()->count();
        
        // $result['donation'] = Donation::count();
        // $result['foodItem'] = foodItem::all()->count();
        // $result['user'] = User::all()->count();
        // $result['category'] = FoodCategory::all()->count();
        //dd($result);
        
        $categories = FoodCategory::with('foodItems')->withCount('foodItems')->orderBy('food_items_count','desc')->get()->toArray();
        $labels = array_column($categories, 'name');
        $values = array_column($categories, 'food_items_count');

        //return $donation = DB::select('select month(created_at) AS month, count(id) as total_number from donations group by month(created_at)');
        $donations = DB::table("donations")
        ->select(DB::raw('MONTHNAME(created_at) AS month, COUNT(id) AS value'))
        ->orderBy('created_at', 'asc')
        ->groupBy(DB::raw('month'))
        ->get()->toArray();
        $labels2 = array_column($donations, 'month');
        $values2 = array_column($donations, 'value');

        $money = DB::table("money")
        ->select(DB::raw('MONTHNAME(created_at) AS month, COUNT(id) AS value'))
        ->orderBy('created_at', 'asc')
        ->groupBy(DB::raw('month'))
        //->orderBy(DB::raw('month'), 'desc')
        ->get()->toArray();
        $labels3 = array_column($money, 'month');
        $values3 = array_column($money, 'value');

        $chartjs = app()->chartjs
        ->name('foodCategoryChart')
        ->type('doughnut')
        ->size(['width' => 400, 'height' => 200])
        ->labels($labels)
        ->datasets([
            [
                'backgroundColor' => ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                'data' => $values,
            ],
            
        ])
        ->options([]);

        $lineChart = app()->chartjs
        ->name('lineChartTest')
        ->type('bar')
        ->size(['width' => 400, 'height' => 200])
        ->labels($labels3)
        ->datasets([
            [
                "label" => "Food Donation",
                'backgroundColor' => '#36A2EB',
                'borderColor' => '#36A2EB',
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $values2,
            ],
            [
                "label" => "Money Donation",
                'backgroundColor' => '#FF6384',
                'borderColor' => '#36A2EB',
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $values3,
            ],
            
        ])
        ->options([]);

        return view('chart.index', ['chartjs'=>$chartjs, 'lineChart'=>$lineChart, 'donation'=>$donationNumber, 'foodItem'=>$foodItemNumber, 'user'=>$userNumber, 'category'=>$categoryNumber]);
        
    }

    public function apiIndex()
    {
        $donations = Donation::with('user','status')->get();
        return  DonationCollection::collection($donations);
    }
}
