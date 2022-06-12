<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Image;
use App\Models\Like;
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
    public function index(Request $request){

        $data= Image::orderBy('created_at', 'desc')->paginate(5);
        $users = User::all();

        $id =\Auth::user()->id;
        $info = DB::table('users')->where('id',$id)->first();
        $user = User::where('id',$info->id)->first();
        $main_user = User::where('id',$id)->first();

        return view('home', compact('data','users', 'user', 'main_user'));
 

    }
    
  




}
