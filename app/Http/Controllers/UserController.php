<?php

namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Document;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
    
class UserController extends Controller
{
    public function __construct()
    {
        //$this->middleware('role:Admin')->except('create');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->paginate(5);
        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create',compact('roles'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'icNumber' => 'required'
        ]);
    
        $input = $request->all();
        $role = Role::whereId($request->roles)->firstOrFail();
        $input['password'] = Hash::make($input['password']);
        if($role->name == 'Admin' || $role->name == 'Donor'){
           $input['status'] = "Approved";
        } else 
        {
            $input['status'] = "Blocked";
        }
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        //$role = Role::where('name',$request->input('roles'))->first();
        //$user->syncPermissions($role->permissions);
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('users.edit',compact('user','roles','userRole'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
            'icNumber' => 'required',
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));    
        }
            
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }

    public function approve($id)
    {
        $user = User::whereId($id)->firstOrFail();
        $user->status = "Approved";
        $user->save();

        return back()->with('status', 'User with ID '. $user->id.' has been approved');
    }

    public function showProfile()
    {
        $user = User::whereId(Auth::user()->id)->firstOrFail();
        return view('users.profile', compact('user') );
    }

    public function saveProfile(Request $request)
    {
        //dd($request);
        //$user = User::whereId($request->id);
        // $this->validate($request, [
        //     'name' => 'required',
        //     'email' => 'required|email|unique:users,email,',
        //     'password' => 'same:confirm-password',
        //     'icNumber' => 'required',
        // ]);
           // dd($request->hasFile('avatar'));
        $input = $request->all();
        $path = "";
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));    
        }
        if($request->hasFile('avatar'))
        {
            $file = $request->file('avatar');
            // Generate a file name with extension
            $fileName = 'avatar-'.time().'.'.$file->getClientOriginalExtension();
            // Save the file
            //dd($request->user()->id);
            $path = $file->storeAs('avatar'. $request->id, $fileName, 'public');
        }  
        // $document = new Document();
        //$user = User::find($request->id);
        // $document->name = "Avatar";
        // $document->url = $path;
        // $document->user_id = Auth::user()->id;
        //$user->documents()->save($document->id);

        $user = User::whereId($request->id)->with('documents')->firstOrFail();
        if(!$user->documents->isEmpty())
        {
         foreach($user->documents as $document)
         {
             if($document->name = "Avatar" && $document->user_id == $request->id ){
                //dd($document);
                $odocument = Document::whereId($document->id)->firstOrFail();
                $odocument->name = "Avatar";
                $odocument->url = $path;
                $odocument->user_id = $request->id;
                $odocument->save();
                break;
             } 
         }
        } else
        {
           $document = new Document();
           $document->name = "Avatar";
           $document->url = $path;
           $document->user_id = $request->id;
           $document->save();
        }
    
        $user->update($input);
        return back()->with('status', 'Your profile info has been updated');
    }

    public function register1(){
        $roles = Role::all();
        return view('users.register', compact('roles'));
    }

    public function save(Request $request)
    {
        //dd($request);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'icNumber' => 'required'
        ]);
    
        $input = $request->all();
        $role = Role::whereId($request->roles)->firstOrFail();
        $input['password'] = Hash::make($input['password']);
        if($role->name == 'Admin' || $role->name == 'Donor'){
           $input['status'] = "Approved";
        } else 
        {
            $input['status'] = "Blocked";
        }
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        //$role = Role::where('name',$request->input('roles'))->first();
        //$user->syncPermissions($role->permissions);
    
        return redirect()->route('login')
                        ->with('success','User created successfully');
    }


}