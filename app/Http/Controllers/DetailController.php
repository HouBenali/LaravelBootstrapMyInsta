<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Support\Facades\DB;



class DetailController extends Controller{
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
    public function index($image_id){

        $logged_user =\Auth::user()->id;

        $info = DB::table('images')->where('id',$image_id)->first();
        
        $image = Image::where('user_id',$logged_user)->first();
        
        $comments =Comment::all();

        $main_user = User::where('id',$logged_user)->first();

        $user = User::where('id',$info->user_id)->first();

        $users = User::all();

        $liked=$this->liked($image_id);

        $countLikes=$this->countLikes($image_id);

        return view('detail', compact('info','user', 'main_user', 'users','image', 'comments', 'image_id', 'logged_user', 'liked', 'countLikes'));

    }

    public function liked($image_id){

        $logged_user =\Auth::user()->id;
        $likes = Like::all();
        $array = array();
        foreach($likes as $like){
            if ($like->user_id == $logged_user && $like->image_id== $image_id){
                array_push($array, true);
            } else {
                array_push($array, false); 
                }
        }
        $liked=in_array(true, $array);

        if ($liked){
            return true;
        }else{
            return false;
        }
        
    }

    public function countLikes($image_id){

        $likes = Like::all();
        $num = 0;
        foreach($likes as $like){
            if ($like->image_id== $image_id){
                $num++;
            }
        }
        return $num;
    }






}
