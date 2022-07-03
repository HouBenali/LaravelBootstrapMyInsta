<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Like;
use App\Models\Image;
use Illuminate\Support\Facades\DB;



class LikeController extends Controller
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
    public function like(Request $request, $image_id){
        
        $logged_user =\Auth::user()->id;

        $date = DB::raw('CURRENT_TIMESTAMP');
        $info = DB::table('images')->where('id',$image_id)->first();
        $user = User::where('id',$logged_user)->first();

        $liked=$this->liked($image_id);

        Like::create([
            'user_id' => $logged_user,
            'image_id' => $image_id,
            'created_at' => $date,
            'updated_at' => $date,
    ]);
        $countLikes=$this->countLikes($image_id);

        $url= explode('?',url()->previous());
    
        if ($url[0] =='http://127.0.0.1:8000/detail/'.$image_id){
            
            return redirect()->route('detail',
            
            ['id' => $image_id]);
        }
           
        else{
            if (count($url)>1){
                $page=explode('=',$url[1]);
                $page[1];
                
                return redirect()->route('home',
                [ 'page' => $page[1]]
            );
            }

            else{
                return redirect()->route('home');

            }
        }

        
       
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


    public function dislike(Request $request, $image_id){

        $logged_user =\Auth::user()->id;
        $info = DB::table('images')->where('id',$image_id)->first();
        $user = User::where('id',$logged_user)->first();
        $liked=$this->liked($image_id);

        $likes = Like::all();
        $like_id = "";
        foreach($likes as $like){
            if ($like->user_id == $logged_user && $like->image_id== $image_id){
                $like_id = $like->id;
            } 
        }
    
        $likes=Like::where('id',$like_id)->first();
        $likes->delete();
        
        $countLikes=$this->countLikes($image_id);

        $url= explode('?',url()->previous());

        if ($url[0] =='http://127.0.0.1:8000/detail/'.$image_id){
            
            return redirect()->route('detail',
            ['id' => $image_id]);
        }
           
         else{
     
            if (count($url)>1){
                $page=explode('=',$url[1]);
                $page[1];

                return redirect()->route('home',
                [ 'page' => $page[1]]
            );
            }

            else{
                return redirect()->route('home');

            }

            
         }

    }






}
