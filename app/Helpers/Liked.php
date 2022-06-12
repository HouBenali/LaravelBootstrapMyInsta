<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\Like;

class Liked{
    public static function IsLiked($image_id){

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

}
