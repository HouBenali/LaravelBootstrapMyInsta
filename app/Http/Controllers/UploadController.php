<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Image;
use App\Models\User;

class UploadController extends Controller
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
        $id =\Auth::user()->id;
        $info = DB::table('users')->where('id',$id)->first();
        $user = User::where('id',$info->id)->first();
        $main_user = User::where('id',$id)->first();
        return view('uploadPhoto',[
            'info' => $info,
            'user' => $user,
            'main_user' =>$main_user
        ]);

    }

    public function create(Request $request){

        $id =\Auth::user()->id;
        $date = DB::raw('CURRENT_TIMESTAMP');

        $validate = $this->validate($request, [
            'description' => ['string','min:8', 'max:255'],
            'image'   => ['required', 'mimes:jpg,png,jpeg,gif,tiff,svg|max:2024'],
            ]);

        $image=$request->file('image');
        $imageB64 = base64_encode(file_get_contents($image));
        $imageFileType = $request->file('image')->extension();
        $photo = 'data:image/'.$imageFileType.';base64,'.$imageB64;

        if ($image){
            $path= $image->store('images');
            $regex="/\/(.*)/";
            $route=array();
            preg_match($regex,$path,$route);
            $filename=$route[1];
            Image::create([
                'user_id' => $id,
                'photo' => $photo,
                'description' => $request->input('description'),
                'updated_at' => $date,
        ]);
            return redirect()->route('uploadPhoto')
                             ->with(['posted'=>'Photo uploaded successfully']);
        } else{
            return redirect()->route('uploadPhoto')
                             ->with(['notposted'=>'Error uploading']);
        }






    }
}
