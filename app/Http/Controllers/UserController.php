<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id){
        // 获得用户的数据
        $questions =  User::find($id)->questions()->get();

        return view('user_questions',compact('questions'));
    }
}
