<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use App\Models\User;

class ProfileController extends Controller
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

        $id =\Auth::user()->id;
        $info = DB::table('users')->where('id',$id)->first();
        $user = User::where('id',$info->id)->first();
        $main_user = User::where('id',$id)->first();
        
        return view('profile',[
            'info' => $info,
            'user' => $user,
            'main_user' => $main_user
        ]);
    }

    public function getImage(){
        $id =\Auth::user()->id;
        $info = DB::table('users')->where('id',$id)->first();

        $filename=$info->image;

        $file = Storage::disk('users')->get($filename);
        return new Response($file,200);
    }
}
