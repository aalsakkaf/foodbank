<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use App\FoodCategory;
use App\foodItem;
use Carbon\Carbon;
use Session;


class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Donor|Admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->id;
        //$id = 1;
        $categories =  FoodCategory::all();
        return view('fooditem.create', ['categories' => $categories, 'id' =>$id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax())
        {
        //dd($request);
        $paths = [];
        if($request->hasFile('files')){
        $files = $request->file('files');
        

    foreach ($files as $file)
    {
        // Generate a file name with extension
        $fileName = 'foodItem-'.time().'.'.$file->getClientOriginalExtension();
        // Save the file
        $paths[] = $file->storeAs('foodItems/'.$request->user()->id, $fileName, 'public');
    }
}
        $inputData = $request->except(['_token']);
      
        
        $size = (collect($inputData['donationId'])->count());
        //return response()->json([var_dump($inputData) ]);
        //return response()->json([gettype($paths[0]) ]);
        for($i=0; $i < $size; $i++) {
            $item = new foodItem();
            $item->name = $inputData['name'][$i];
            $item->quantityType = $inputData['quantityType'][$i];
            $item->quantity = $inputData['quantity'][$i]; //convert to number
            $item->photoURL = $paths[$i];
            $item->donation_id = $inputData['donationId'][$i]; //convert to number
            $item->category_id = $inputData['categoryId'][$i]; //convert to number
            $item->save();
        }
      return response()->json([
       'success'  => 'Data Added successfully.'
      ]);

    } else {
        //dd($request);
        $path = null;
        if($request->hasFile('files')){
            $file = $request->file('files');
            
    
            // Generate a file name with extension
            $fileName = 'foodItem-'.time().'.'.$file->getClientOriginalExtension();
            // Save the file
            $path = $file->storeAs('foodItems/'.$request->user()->id, $fileName, 'public');
        
    }
            $inputData = $request->except(['_token']);
            
                $item = new foodItem();
                $item->name = $inputData['name'];
                $item->quantityType = $inputData['quantityType'];
                $item->quantity = $inputData['quantity']; //convert to number
                $item->photoURL = $path;
                $item->donation_id = $inputData['donationId']; //convert to number
                $item->category_id = $inputData['categoryId']; //convert to number
                $item->save();
            
        return back()->with('success', 'The food item has been added succesfully!');
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //dd($id);
        Session::put('donationId', $id);
        $items = foodItem::where('donation_id', $id)->get();
        //dd($items);
        $categories =  FoodCategory::all();
        return view('foodItem.edit', ['items' => $items, 'categories'=>$categories]);
        //return view('status.edit', ['status' => $status]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //dd($request);
        $path = null;
        if($request->hasFile('files')){
            $file = $request->file('files');
            // Generate a file name with extension
            $fileName = 'foodItem-'.time().'.'.$file->getClientOriginalExtension();
            // Save the file
            //dd($request->user()->id);
            $path = $file->storeAs('foodItems/'.$request->user()->id, $fileName, 'public');
    }
            $item = foodItem::whereId($request->id)->firstOrFail();
            $inputData = $request->except(['_token']);
                $item->name = $request->name;
                $item->quantityType = $request->quantityType;
                $item->quantity = $request->quantity; //convert to number
                $item->photoURL = $path;
                $item->donation_id = $request->donationId; //convert to number
                $item->category_id = $request->categoryId; //convert to number
                $item->save();
            return back()->with('success', 'The food item has been updated succesfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $item)
    {
        //dd($request->id);
        foodItem::destroy($request->id);
        return back()->with('success', 'The food item has been deleted succesfully!');
    }
}
