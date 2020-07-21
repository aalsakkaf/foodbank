<?php

namespace App\Http\Controllers;

use App\rewardPoint;
use Illuminate\Http\Request;

class RewardPointController extends Controller
{
    public function __construct()
    {
   
        $this->middleware('role:Admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $points = rewardPoint::all();
        return view('reward.index', ['points' => $points]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reward.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $point = new rewardPoint;
        $point->name = $request->name;
        $point->description = $request->description; 
        $point->points = $request->points; 

        $point->save();

        return back()->with('status', 'The reward point has been added succesfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\rewardPoint  $rewardPoint
     * @return \Illuminate\Http\Response
     */
    public function show(rewardPoint $rewardPoint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\rewardPoint  $rewardPoint
     * @return \Illuminate\Http\Response
     */
    public function edit(rewardPoint $rewardPoint)
    {
        //$rewardPoint = rewardPoint::whereId($id)->firstOrFail();
        return view('reward.edit', compact('rewardPoint')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\rewardPoint  $rewardPoint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rewardPoint = rewardPoint::whereId($id)->firstOrFail();
        $rewardPoint->name = $request->name;
        $rewardPoint->description = $request->description; 
        $rewardPoint->points = $request->points; 

        $rewardPoint->save();
        return back()->with('status', 'The reward point has been updated succesfully!');
    }    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\rewardPoint  $rewardPoint
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        rewardPoint::destroy($id);
        return redirect()->route('reward.index')->with('status', 'The Reward Point has been deleted!');
    }
}
