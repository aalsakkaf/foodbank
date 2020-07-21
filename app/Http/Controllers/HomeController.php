<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Document;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function waiting()
    {
        $id = Auth::user()->id;
        $documents = Document::where('user_id', $id)->get();

        return view('users.waiting', compact('documents'));
    }

    public function error()
    {
        return view('error');
    }
}
