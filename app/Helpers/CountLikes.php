<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\Like;

class CountLikes {
    public  static function LikesCounter($image_id){

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
