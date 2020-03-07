<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        // dd($request);
        // $this->middleware('auth');
        if ($request->cookie('access_token')) {
            return redirect('/login');
        }else {
            return redirect('/fdbfdbd');
        }
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
}
