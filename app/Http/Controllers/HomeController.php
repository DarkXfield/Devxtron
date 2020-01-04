<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
Use Auth;
use Illuminate\Support\Facades\DB;

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
        return view('welcome');
    }

    public function admin()
    {
        return view('panel');
    }

    public function fetchContacts(){
        return User::all()->except(Auth::id());
    }

    public function contacts($id)
    {
        $userMsg = DB::table('users')->where('users.id', $id)->get();
        return $userMsg;
    }
    
}
