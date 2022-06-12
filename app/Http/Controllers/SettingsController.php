<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use App\Models\User;

class SettingsController extends Controller
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
        $users = User::all();
        $user = User::where('id',$info->id)->first();
        $main_user = User::where('id',$id)->first();
        
        return view('settings',[
            'info' => $info,
            'users' => $users,
            'user' => $user,
            'main_user' => $main_user
        ]);
    }

    public function update(Request $request){
        $id =\Auth::user()->id;
        $date = DB::raw('CURRENT_TIMESTAMP');
       
        $image=$request->file('image');

        if ($image){
            $path= $image->store('users');
            $regex="/\/(.*)/";
            $route=array();
            preg_match($regex,$path,$route);
            $filename=$route[1];
            $user = DB::table('users')->where('id',$id)->update(
                [
                    'image' => $filename,
                    'updated_at' => $date,
                    ]
                );
        }

        $validate = $this->validate($request, [
            'name' => ['string', 'max:255'],
            'surname' => ['string', 'max:255'],
            'nick' => ['string', 'max:255', 'unique:users,nick,'.$id],
            'email' => ['string', 'email', 'max:255','unique:users,email,'.$id]
            ]);
    
        $usuari = DB::table('users')->where('id',$id)->update(
            [
                'name' => $request->input('name'),
                'surname' => $request->input('surname'),
                'nick' => $request->input('nick'),
                'email' => $request->input('email'),
                'updated_at' => $date,
            ]
        );

        return redirect()->route('settings')
                         ->with(['message'=>'Usuari actualitzat correctament']);
       
    }

    public function updatePass(Request $request){

        $id =\Auth::user()->id;
        $date = DB::raw('CURRENT_TIMESTAMP');

        $validate = $this->validate($request, [
            'password' => ['string', 'min:8', 'confirmed'],
        ]);
        
        $usuari = DB::table('users')->where('id',$id)->update(
            [
            'password' => Hash::make($request['password']),
            'updated_at' => $date,
            ]);

        return redirect()->route('settings')
            ->with(['updatedPass'=>'Usuari actualitzat correctament']);

    }

    public function getImage(){
        $id =\Auth::user()->id;
        $info = DB::table('users')->where('id',$id)->first();

        $filename=$info->image;

        $file = Storage::disk('users')->get($filename);
        return new Response($file,200);
    }
}
