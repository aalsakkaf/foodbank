<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\donationNotification;



class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Student|Admin')->except('welcome');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     
        if(Auth::user()->roles->pluck( 'name' )->contains( 'Admin' )){
            $posts = Post::all();
            return view('post.index', ['posts'=> $posts]);
        }
        else{
            $posts = Post::where('user_id',Auth::user()->id)->get();
            return view('post.index', ['posts'=> $posts]);
        }    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->save();

        $user = Auth::user();
        $user->notify(new donationNotification("New Post", "Thank you for creating a new appreciation post"));
        return redirect()->route('post.index')->with('status', 'The post has been successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //dd($post);
        return view('post.single', ['post'=> $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('post.edit', ['post'=> $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();

        $user = Auth::user();
        $user->notify(new donationNotification("Updated Post", "Your appreciation post was updated"));
        return redirect()->route('post.index')->with('status', 'Post has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        $user = Auth::user();
        $user->notify(new donationNotification("Deleted Post", "Your appreciation post was deleted"));
        return redirect()->route('post.index')->with('status', 'Post has been deleted');

    }

    public function welcome()
    {
            $posts = Post::with('user')->get();
            return view('welcome', ['posts'=> $posts]);
    }
}
