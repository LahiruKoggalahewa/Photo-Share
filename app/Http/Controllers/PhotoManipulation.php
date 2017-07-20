<?php

namespace App\Http\Controllers;

use App\Photo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;


class PhotoManipulation extends Controller
    {
    //
    public function upload(Request $request){

        $photo = new Photo();

        $photo -> user_id = Auth::user()->id;
        $photo -> location = $request -> location;
        $photo -> description = $request -> description;


        if($request->image) {

            $file = Input::file('image');
            $ext = $file->guessClientExtension();
            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
            $name = $request->user_id."-".$timestamp. "." .$ext;
            $photo->photo = url('/images/'.$name);
            $file->move(public_path().'/images/', $name);
        }

        $photo->save();
        return Redirect::to('/upload');
    }

    public function search(Request $request){

        $result = Photo::where('location', 'LIKE', '%' . $request->search . '%')
            ->orderBy('created_at', 'desc')
            ->get();
        return view ('index', compact('result'));
    }
}
