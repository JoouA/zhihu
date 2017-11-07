<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\pic;
use Auth;
use App\Favorite;

class testController extends Controller
{
     public function __construct()
     {
         $this->middleware('auth');
     }
    public function show(){
        $pics = pic::paginate(6);
        $favorites = Favorite::where('user_id',Auth::id())->pluck('pic_id')->toArray();  // 获得是某一列的值数组 laravel5.3用的是lists
//        dd(Favorite::where('user_id',Auth::id())->pluck('pic_id')->toArray());     //get到的是favorite
//        dd(Auth::user()->favorites()->get());   // get 的是pic
        return view('fy',compact('pics','favorites'));
    }
}
