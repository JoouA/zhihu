<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;


class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $settings = Auth::user()->settings;
        return view('users.settings',compact('settings'));
    }

    public function store(Request $request)
    {
        /*$user = Auth::user();


        $settings =  array_only($request->all(),['name','bio','live']);

        $user->update(['settings'=>$settings]);*/

        $isSuccess =  Auth::user()->settings()->merge($request->all());

        /**
        $user->settings = $settings;

        $user->save();
        **/
        if ($isSuccess){
            flash('个人信息更新成功')->success()->important();
        }else{
            flash('个人信息更新失败')->warning()->important();
        }

        return back();
    }


}
