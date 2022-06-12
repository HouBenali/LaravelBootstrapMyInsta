<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Image;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;



class CommentController extends Controller{
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
    public function index(Request $request, $image_id){

        $user_id =\Auth::user()->id;
        $date = DB::raw('CURRENT_TIMESTAMP');

        $info = DB::table('images')->where('id',$image_id)->first();
        $image = Image::where('user_id',$info->user_id)->first();

        $validate = $this->validate($request, [
            'description' => ['string', 'max:255'],
            ]);

            Comment::create([
                'user_id' => $user_id,
                'image_id' => $image_id,
                'content' => $request->input('description'),
                'created_at' => $date,
                'updated_at' => $date,
        ]);

        $comments =Comment::all();
        
        $logged_user =\Auth::user()->id;

        $user = User::where('id',$info->user_id)->first();

        $users = User::all();

        return redirect()->route('detail', 
        [
            'info' => $info,
            'user' => $user,
            'users' => $users,
            'image' => $image,
            'comments' => $comments,
            'id' => $image_id,
            'logged_user' => $logged_user,

            ])->with('commented', 'Commented Succesfully');

    }

    public function delete($comment_id){
        
        $comment=Comment::where('id',$comment_id)->first();

        $comment->delete();

        return redirect()->route('detail',['id' => $comment->image_id])->with('deleted','Comment deleted successfully');

    }




}
