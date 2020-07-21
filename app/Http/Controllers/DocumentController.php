<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use App\FoodCategory;
use App\Document;
use App\User;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Notifications\donationNotification;




class DocumentController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        
        $this->middleware('approved')->only('index', 'destroy');
    }
    public function index()
    {
         $users = User::where('status', 'Pending')->with('documents')->get();
        
        return view('document.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //$doucment =  Document::all();
        return view('document.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->hasFile('id'))
        {
        $file = $request->file('id');
        //dd($file);
        
        // Generate a file name with extension
        $fileName = 'id-'.time().'.'.$file->getClientOriginalExtension();
        // Save the file
        $path = $file->storeAs('id/'. Auth::user()->id, $fileName);

        $document = new Document();
            $document->name = "ID";
            $document->url = $path;
            $document->user_id = Auth::user()->id;
            $document->save();
        }  

        if($request->hasFile('letter')) 
     {
    
        $file = $request->file('letter');
        // Generate a file name with extension
        $fileName = 'letter-'.time().'.'.$file->getClientOriginalExtension();
        // Save the file
        $path = $file->storeAs('letter/'. Auth::user()->id, $fileName);

        $document = new Document();
            $document->name = "Reference Letter";
            $document->url = $path;
            $document->user_id = Auth::user()->id;
            $document->save();

} 
    if($request->hasFile('other')) 
{
    $file = $request->file('other');
        // Generate a file name with extension
        $fileName = 'other-'.time().'.'.$file->getClientOriginalExtension();
        // Save the file
        $path = $file->storeAs('other/'. Auth::user()->id, $fileName);

        $document = new Document();
            $document->name = "Other Document";
            $document->url = $path;
            $document->user_id = Auth::user()->id;
            $document->save();
}
        $user = User::whereId(Auth::user()->id)->firstOrFail();
        $user->status = "Pending";
        $user->save();

        $user = User::role('Admin')->first();
        $user->notify(new donationNotification("New Documents Submitted", "Please Check documentes submitted by Student/Volunteer"));
        return redirect()->route('waiting')->with('success', 'The document has been added succesfully!');
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
        $document = Document::whereId($id)->get();
        return view('document.edit', ['document' => $document]);
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
        
        if($request->hasFile('file')){
            $id = $request->id;
            $document = Document::whereId($id)->firstOrFail();
            $file = $request->file('file');
            
            $fileName = $document->name.'-'.time().'.'.$file->getClientOriginalExtension();
            // Save the file
            $path = $file->storeAs($document->name.'/'. Auth::user()->id, $fileName);
                $document->url = $path;
                $document->user_id = Auth::user()->id;
                $document->save();
    }
    $user = User::role('Admin')->first();
    $user->notify(new donationNotification("Updated Documents Submitted", "Please Check documentes updated by Student/Volunteer"));  
            return back()->with('success', 'The document has been updated succesfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $document)
    {
        //dd($request->id);
        Document::destroy($request->id);
        return back()->with('success', 'The food document has been deleted succesfully!');
    }

    public function getFile($id)
    {
        $document = Document::whereId($id)->firstOrFail();
        return Storage::download($document->url);

    }
}
